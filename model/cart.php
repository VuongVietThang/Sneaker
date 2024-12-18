<?php
include_once __DIR__ . '../db.php';
class Cart extends Db
{
    public function getColor($name) {
        // Câu truy vấn SQL
        $sql = "SELECT color_id FROM color WHERE name = ?";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = self::$connection->prepare($sql);
        if ($stmt === false) {
            // Nếu chuẩn bị không thành công, trả về null hoặc thông báo lỗi
            return null;
        }
        
        // Liên kết tham số và thực thi câu lệnh
        $stmt->bind_param("s", $name);
        $stmt->execute();
        
        // Lấy kết quả truy vấn
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Trả về mảng kết quả
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data['color_id'];  // Trả về color_id
        } else {
            $stmt->close();
            return null;  // Nếu không có kết quả
        }
    }
    
    public function getSize($value) {
        // Câu truy vấn SQL
        $sql = "SELECT size_id FROM size WHERE value = ?";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = self::$connection->prepare($sql);
        if ($stmt === false) {
            // Nếu chuẩn bị không thành công, trả về null hoặc thông báo lỗi
            return null;
        }
        
        // Liên kết tham số và thực thi câu lệnh
        $stmt->bind_param("s", $value);
        $stmt->execute();
        
        // Lấy kết quả truy vấn
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Trả về mảng kết quả
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data['size_id'];  // Trả về size_id
        } else {
            $stmt->close();
            return null;  // Nếu không có kết quả
        }
    }
     

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($userId, $productId, $sizeId, $colorId, $quantity = 1)
    {
        $sql = "SELECT cart_id FROM cart WHERE user_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $sql = "INSERT INTO cart (user_id) VALUES (?)";
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $cartId = self::$connection->insert_id;
        } else {
            $row = $result->fetch_assoc();
            $cartId = $row['cart_id'];
        }

        // check 
        $sql = "SELECT cart_item_id FROM cart_item WHERE cart_id = ? AND product_id = ? AND size_id = ? AND color_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("iiii", $cartId, $productId, $sizeId, $colorId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // isset -> +1
            $sql = "UPDATE cart_item SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ? AND size_id = ? AND color_id = ?";
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param("iiiii", $quantity, $cartId, $productId, $sizeId, $colorId);
            $stmt->execute();
        } else {
            // add nếu !tồn tại+
            $sql = "INSERT INTO cart_item (cart_id, product_id, size_id, color_id, quantity) VALUES (?, ?, ?, ?, ?)";
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param("iiiii", $cartId, $productId, $sizeId, $colorId, $quantity);
            $stmt->execute();
        }

        return true;
    }

    public function getAllProductsInCart($user_id)
    {
        $sql = "SELECT ci.cart_item_id, ci.cart_id, ci.product_id, s.value AS size_value, c.name AS color_name, 
                       ci.quantity, p.name AS product_name, p.price, pi.image_url
                FROM cart_item ci
                JOIN product p ON ci.product_id = p.product_id
                LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
                LEFT JOIN color c ON c.color_id = ci.color_id
                LEFT JOIN size s ON s.size_id = ci.size_id
                WHERE ci.cart_id IN (SELECT cart_id FROM cart WHERE user_id = ?)";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = self::$connection->prepare($sql);
    
        // Kiểm tra lỗi chuẩn bị câu lệnh
        if ($stmt === false) {
            // Lấy thông báo lỗi từ MySQL
            die('MySQL Error: ' . self::$connection->error);
        }
        
        // Liên kết tham số và thực thi câu lệnh
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        // Lấy kết quả truy vấn
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Trả về mảng kết quả
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $data;
        } else {
            // Nếu không có sản phẩm nào trong giỏ hàng
            $stmt->close();
            return null;
        }
    }
    
    public function createOrder($userId, $shippingAddress)
    {
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        // Bắt đầu transaction để đảm bảo tính toàn vẹn của dữ liệu
        self::$connection->begin_transaction();
        try {
            // 1. Tạo đơn hàng mới
            $sql = "INSERT INTO `orders` (user_id, order_date, total_amount, status, shipping_address) 
                VALUES (?, ?, 0, 'Pending', ?)";
            // Kiểm tra nếu $shippingAddress là string
            $stmt = self::$connection->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Không thể chuẩn bị câu lệnh SQL: " . self::$connection->error);
            }
            $stmt->bind_param("iss", $userId, $now, $shippingAddress);

            if (!$stmt->execute()) {
                throw new Exception("Không thể tạo đơn hàng.");
            }

            $orderId = self::$connection->insert_id;

            // 2. Lấy tất cả sản phẩm trong giỏ hàng của người dùng
            $cart = new Cart();
            $cartItems = $cart->getAllProductsInCart($userId);

            // Kiểm tra nếu giỏ hàng trống
            if (empty($cartItems)) {
                throw new Exception("Giỏ hàng không có sản phẩm.");
            }

            $totalAmount = 0;

            // 3. Thêm sản phẩm vào đơn hàng và tính tổng số tiền
            foreach ($cartItems as $item) {
                $productId = $item['product_id'];
                $sizeId = $item['size_id'];
                $colorId = $item['color_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                // Thêm sản phẩm vào bảng order_item
                $sql = "INSERT INTO order_item (order_id, product_id, size_id, color_id, quantity, price)
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = self::$connection->prepare($sql);
                $stmt->bind_param("iiiiid", $orderId, $productId, $sizeId, $colorId, $quantity, $price);

                if (!$stmt->execute()) {
                    throw new Exception("Không thể thêm sản phẩm vào đơn hàng.");
                }

                // Cập nhật tổng số tiền của đơn hàng
                $totalAmount += $price * $quantity;
            }

            // 4. Cập nhật lại tổng số tiền cho đơn hàng
            $sql = "UPDATE `orders` SET total_amount = ? WHERE order_id = ?";
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param("si", $totalAmount, $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Không thể cập nhật tổng số tiền cho đơn hàng.");
            }

            // 5. Xóa giỏ hàng của người dùng sau khi tạo đơn hàng
            $sql = "DELETE FROM cart_item WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = ?)";
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param("i", $userId);
            if (!$stmt->execute()) {
                throw new Exception("Không thể xóa giỏ hàng của người dùng.");
            }

            // Cam kết transaction nếu mọi thứ thành công
            self::$connection->commit();

            return $orderId;
        } catch (Exception $e) {
            // Nếu có lỗi xảy ra, rollback lại transaction
            self::$connection->rollback();
            // Bạn có thể log lỗi hoặc thông báo lỗi cho người dùng
            return false;
        }
    }

    public function getOrdersByUserId($userId)
    {
        // SQL query để lấy tất cả đơn hàng của người dùng
        $sql = "SELECT order_id, order_date, total_amount, status, shipping_address
                FROM `orders`
                WHERE user_id = ?";

        // Chuẩn bị câu truy vấn
        $stmt = self::$connection->prepare($sql);

        // Kiểm tra nếu câu lệnh chuẩn bị bị lỗi
        if ($stmt === false) {
            die('Error preparing query: ' . self::$connection->error);
        }

        // Ràng buộc tham số vào câu truy vấn
        $stmt->bind_param("i", $userId);

        // Thực thi câu truy vấn
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();

        // Nếu có kết quả, trả về mảng chứa các đơn hàng
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];  // Trả về mảng rỗng nếu không có đơn hàng
        }
    }
    public function getOrderDetails($orderId)
    {
        // Truy vấn các sản phẩm trong đơn hàng
        $sql = "SELECT oi.order_item_id, oi.order_id, oi.product_id, oi.size_id, oi.color_id, oi.quantity, oi.price,
                       p.name AS product_name, p.price AS product_price, 
                       pi.image_url
                FROM order_item oi
                JOIN product p ON oi.product_id = p.product_id
                LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
                WHERE oi.order_id = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $orderId); // Liên kết tham số $orderId vào câu lệnh SQL
        $stmt->execute();
        $result = $stmt->get_result();

        // Trả về tất cả các sản phẩm trong đơn hàng dưới dạng mảng
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getDetailOrder($orderId)
    {
        // Truy vấn các sản phẩm trong đơn hàng với order_id
        $sql = "SELECT oi.order_item_id, oi.order_id, oi.product_id, oi.size_id, oi.color_id, oi.quantity, oi.price,
                       p.name AS product_name, p.price AS product_price, 
                       pi.image_url
                FROM order_item oi
                JOIN product p ON oi.product_id = p.product_id
                LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
                WHERE oi.order_id = ?";

        // Chuẩn bị câu lệnh SQL
        $stmt = self::$connection->prepare($sql);

        // Liên kết tham số $orderId vào câu lệnh SQL
        $stmt->bind_param("i", $orderId);

        // Thực thi câu lệnh
        $stmt->execute();

        // Lấy kết quả trả về
        $result = $stmt->get_result();

        // Kiểm tra nếu có dữ liệu và trả về dưới dạng mảng
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];  // Trả về mảng rỗng nếu không có sản phẩm nào
        }
    }
    public function countItemsInCart($userId)
    {
        $sql = "SELECT SUM(ci.quantity) AS total_items
                FROM cart_item ci
                JOIN cart c ON ci.cart_id = c.cart_id
                WHERE c.user_id = ?";

        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Lấy tổng số lượng sản phẩm trong giỏ hàng
        $row = $result->fetch_assoc();
        return $row['total_items'] ? $row['total_items'] : 0;
    }

    // Hàm xóa sản phẩm khỏi giỏ hàng theo `cart_item_id`
    public function removeProductFromCart($cartItemId)
    {
        // Sử dụng kết nối từ lớp Db đã có
        $conn = self::$connection; // Lấy kết nối từ lớp Db

        // Xóa sản phẩm khỏi giỏ hàng
        $query = "DELETE FROM cart_item WHERE cart_item_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $cartItemId);

        // Thực thi và kiểm tra kết quả
        return $stmt->execute();
    }



    public function getAllOrders()
    {
        $sql = "SELECT o.order_id, o.order_date, o.status, o.shipping_address, 
                       SUM(oi.quantity * oi.price) AS total_amount
                FROM orders o
                JOIN order_item oi ON o.order_id = oi.order_id
                GROUP BY o.order_id
                ORDER BY o.order_date DESC";

        $stmt = self::$connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
