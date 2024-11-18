    <?php
    require_once 'db.php';

    class Product_db extends Db
    {
        // Phương thức lấy tổng số sản phẩm
        public function getTotalProductCount()
        {
            $sql = self::$connection->prepare("SELECT COUNT(*) FROM product");
            $sql->execute();
            $result = $sql->get_result()->fetch_row();
            return $result[0];
        }

        public function getAllProductWithDetails($page = 1, $items_per_page = 10)
        {
            $offset = ($page - 1) * $items_per_page;

            $sql = self::$connection->prepare("
        SELECT p.*, 
               b.name AS brand_name,
               GROUP_CONCAT(DISTINCT ps.size_id) AS size_ids, 
               GROUP_CONCAT(DISTINCT s.value) AS sizes,
               GROUP_CONCAT(DISTINCT c.name) AS color_names, 
               GROUP_CONCAT(DISTINCT pi.image_url) AS image_urls
        FROM product p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN product_color pc ON p.product_id = pc.product_id
        LEFT JOIN color c ON pc.color_id = c.color_id
        LEFT JOIN product_image pi ON p.product_id = pi.product_id
        LEFT JOIN product_size ps ON p.product_id = ps.product_id
        LEFT JOIN size s ON ps.size_id = s.size_id
        GROUP BY p.product_id
        LIMIT ? OFFSET ?
    ");

            $sql->bind_param("ii", $items_per_page, $offset);
            $sql->execute();

            if ($sql->error) {
                die("Lỗi thực thi câu lệnh: " . $sql->error);
            }

            $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
            return $items;
        }




        public function addProduct($brand_id, $name, $description, $price, $type, $sizes = [], $colors = [], $images = [])
        {
            // Thêm sản phẩm vào bảng product
            $sql = self::$connection->prepare("INSERT INTO product (brand_id, name, description, price, type) VALUES (?, ?, ?, ?, ?)");
            $sql->bind_param("issds", $brand_id, $name, $description, $price, $type);
            $sql->execute();

            // Lấy product_id tự động tạo ra
            $product_id = self::$connection->insert_id;
            $sql->close();


            // Thêm kích thước vào bảng product_size
            foreach ($sizes as $size_id) {
                $this->addProductSize($product_id, $size_id);
            }

            // Thêm màu sắc vào bảng product_color
            foreach ($colors as $color_id) {
                $this->addProductColor($product_id, $color_id);
            }

            // Thêm hình ảnh vào bảng product_image
            foreach ($images as $image) {
                $image_url = $image['url'];
                $is_main = $image['is_main'] ?? 0;
                $this->addProductImage($product_id, $image_url, $is_main);
            }
        }
        public function getLastProductId()
        {
            return self::$connection->insert_id;
        }


        public function deleteProduct($id)
        {
            // Xóa tất cả hình ảnh liên quan đến sản phẩm và tệp tin trên hệ thống
            $this->deleteProductImagesAndFiles($id);

            // Xóa tất cả màu sắc liên quan đến sản phẩm
            $this->deleteProductColors($id);

            // Xóa tất cả kích thước liên quan đến sản phẩm
            $this->deleteProductSizes($id);

            // Cuối cùng xóa sản phẩm chính
            $sql = self::$connection->prepare("DELETE FROM product WHERE product_id = ?");
            $sql->bind_param("i", $id);
            $sql->execute();
            $sql->close();
        }

        public function deleteProductImagesAndFiles($product_id)
        {
            // Lấy tất cả hình ảnh từ cơ sở dữ liệu
            $sql = self::$connection->prepare("SELECT image_url FROM product_image WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $result = $sql->get_result();

            // Xóa từng hình ảnh khỏi thư mục ../images/product/
            while ($row = $result->fetch_assoc()) {
                $image_url = $row['image_url'];
                $file_path = '../images/product/' . basename($image_url); // Đường dẫn đến tệp tin

                // Kiểm tra xem tệp có tồn tại không
                if (file_exists($file_path)) {
                    unlink($file_path); // Xóa tệp tin
                }
            }

            // Xóa tất cả hình ảnh liên quan đến sản phẩm trong cơ sở dữ liệu
            $sql = self::$connection->prepare("DELETE FROM product_image WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $sql->close();
        }

        public function deleteProductColors($product_id)
        {
            $sql = self::$connection->prepare("DELETE FROM product_color WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $sql->close();
        }

        public function deleteProductSizes($product_id)
        {
            $sql = self::$connection->prepare("DELETE FROM product_size WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $sql->close();
        }

        public function timSanPham($product_id)
        {
            $sql = self::$connection->prepare("
                SELECT p.product_id, p.name, p.description, p.price, p.type,
                    GROUP_CONCAT(DISTINCT c.name) AS color_names,
                    GROUP_CONCAT(DISTINCT s.value) AS sizes,
                    GROUP_CONCAT(DISTINCT pi.image_url) AS image_urls,
                    b.name AS brand_name  -- Thêm thương hiệu vào kết quả
                FROM product p
                LEFT JOIN product_color pc ON p.product_id = pc.product_id
                LEFT JOIN color c ON pc.color_id = c.color_id
                LEFT JOIN product_size ps ON p.product_id = ps.product_id
                LEFT JOIN size s ON ps.size_id = s.size_id
                LEFT JOIN product_image pi ON p.product_id = pi.product_id
                LEFT JOIN brand b ON p.brand_id = b.brand_id  -- Kết nối với bảng thương hiệu
                WHERE p.product_id = ?
                GROUP BY p.product_id
            ");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
            return $items;
        }


        public function editSanPham($product_id, $brand_id, $name, $description, $price, $type, $sizes = [], $colors = [], $main_image = null, $additional_images = [])
        {
            // Cập nhật thông tin sản phẩm chính
            $sql = self::$connection->prepare("UPDATE product SET brand_id = ?, name = ?, description = ?, price = ?, type = ? WHERE product_id = ?");
            $sql->bind_param("issdsi", $brand_id, $name, $description, $price, $type, $product_id);
            $sql->execute();
            $sql->close();

            // Cập nhật kích thước sản phẩm
            $this->deleteProductSizes($product_id);
            foreach ($sizes as $size_id) {
                $this->addProductSize($product_id, $size_id);
            }

            // Cập nhật màu sắc sản phẩm
            $this->deleteProductColors($product_id);
            foreach ($colors as $color_id) {
                $this->addProductColor($product_id, $color_id);
            }

            // Xử lý ảnh chính
            if ($main_image !== null) {
                // Xóa ảnh chính cũ
                $old_main_image = $this->getMainImage($product_id);
                if ($old_main_image) {
                    $file_path = '../images/product/' . basename($old_main_image['image_url']);
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    $sql = self::$connection->prepare("DELETE FROM product_image WHERE product_id = ? AND is_main = 1");
                    $sql->bind_param("i", $product_id);
                    $sql->execute();
                    $sql->close();
                }

                // Thêm ảnh chính mới
                $this->addProductImage($product_id, $main_image, 1);

                // Xóa tất cả ảnh phụ nếu thay đổi cả ảnh chính
                $this->deleteProductImages($product_id, 0);

                // Thêm một bản sao ảnh chính làm ảnh phụ
                $this->addProductImage($product_id, $main_image, 0);
            }

            // Xử lý ảnh phụ
            if (!empty($additional_images)) {
                // Xử lý trường hợp người dùng muốn xóa một hoặc nhiều ảnh phụ
                $images_to_remove = isset($_POST['remove_images']) ? $_POST['remove_images'] : [];

                // Xóa ảnh phụ cũ đã được chọn để xóa
                foreach ($images_to_remove as $image_to_remove) {
                    $this->deleteProductImageById($product_id, $image_to_remove);
                }

                // Trường hợp cập nhật hoặc thay thế ảnh phụ:
                // Xóa tất cả các ảnh phụ cũ trước khi thêm ảnh mới (nếu không giữ nguyên ảnh cũ)
                $old_additional_images = $this->getAdditionalImages($product_id);
                foreach ($old_additional_images as $old_image) {
                    $file_path = '../images/product/' . basename($old_image);
                    if (file_exists($file_path)) {
                        unlink($file_path);  // Xóa file cũ
                    }
                }

                // Xóa ảnh phụ khỏi CSDL (nếu cập nhật tất cả ảnh phụ)
                $sql = self::$connection->prepare("DELETE FROM product_image WHERE product_id = ? AND is_main = 0");
                $sql->bind_param("i", $product_id);
                $sql->execute();
                $sql->close();

                // Thêm ảnh phụ mới vào CSDL (cập nhật hoặc thêm mới ảnh phụ)
                foreach ($additional_images as $image) {
                    $this->addProductImage($product_id, $image, 0);  // `0` nghĩa là ảnh phụ
                }
            }
        }
        // Hàm để xóa ảnh phụ khỏi CSDL và thư mục
        public function deleteProductImageById($product_id, $image_url)
        {
            // Xóa ảnh khỏi thư mục
            $file_path = '../images/product/' . basename($image_url);
            if (file_exists($file_path)) {
                unlink($file_path); // Xóa ảnh khỏi thư mục
            }

            // Xóa ảnh khỏi cơ sở dữ liệu
            $sql = self::$connection->prepare("DELETE FROM product_image WHERE product_id = ? AND image_url = ?");
            $sql->bind_param("is", $product_id, $image_url);
            $sql->execute();
            $sql->close();
        }

        // Hàm xóa tất cả ảnh phụ khỏi CSDL và thư mục
        public function deleteProductImages($product_id, $is_main)
        {
            // Xóa các hình ảnh từ cơ sở dữ liệu
            $sql = self::$connection->prepare("SELECT image_url FROM product_image WHERE product_id = ? AND is_main = ?");
            $sql->bind_param("ii", $product_id, $is_main);
            $sql->execute();
            $result = $sql->get_result();

            // Xóa các hình ảnh từ thư mục
            while ($row = $result->fetch_assoc()) {
                $file_path = '../images/product/' . basename($row['image_url']);
                if (file_exists($file_path)) {
                    unlink($file_path); // Xóa ảnh khỏi thư mục
                }
            }

            // Xóa các hình ảnh khỏi cơ sở dữ liệu
            $delete_sql = self::$connection->prepare("DELETE FROM product_image WHERE product_id = ? AND is_main = ?");
            $delete_sql->bind_param("ii", $product_id, $is_main);
            $delete_sql->execute();
            $delete_sql->close();
        }
        public function isMainImage($product_id, $image_url)
        {
            // Truy vấn để kiểm tra xem ảnh có phải là ảnh chính của sản phẩm không
            $sql = self::$connection->prepare("SELECT is_main FROM product_image WHERE product_id = ? AND image_url = ?");
            $sql->bind_param("is", $product_id, $image_url);
            $sql->execute();
            $result = $sql->get_result();

            // Nếu tìm thấy ảnh và is_main = 1 thì trả về true
            if ($row = $result->fetch_assoc()) {
                return $row['is_main'] == 1;
            }

            return false; // Nếu không tìm thấy hoặc không phải ảnh chính, trả về false
        }


        public function getSelectedBrand($product_id)
        {
            // Chuẩn bị truy vấn để lấy brand_id từ sản phẩm
            $sql = self::$connection->prepare("SELECT brand_id FROM product WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $result = $sql->get_result();
            $brand = $result->fetch_assoc();
            $sql->close();


            // Trả về brand_id hoặc null nếu không tìm thấy
            return $brand ? $brand['brand_id'] : null;
        }
        public function editProductBrand($product_id, $brand_id)
        {
            // Chuẩn bị truy vấn để cập nhật brand_id cho sản phẩm
            $sql = self::$connection->prepare("UPDATE product SET brand_id = ? WHERE product_id = ?");
            $sql->bind_param("ii", $brand_id, $product_id);

            if ($sql->execute()) {
                // Kiểm tra xem số dòng bị ảnh hưởng có lớn hơn 0 không
                if ($sql->affected_rows > 0) {
                    $sql->close();
                    return true; // Cập nhật thành công
                } else {
                    $sql->close();
                    return false; // Không có thay đổi
                }
            } else {
                $sql->close();
                return false; // Cập nhật không thành công
            }
        }




        // Phương thức lấy danh sách ID màu đã chọn của sản phẩm
        public function getSelectedColors($product_id)
        {
            $sql = self::$connection->prepare("SELECT color_id FROM product_color WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $result = $sql->get_result();
            $colors = [];
            while ($row = $result->fetch_assoc()) {
                $colors[] = $row['color_id'];
            }
            $sql->close();
            return $colors;
        }

        // Phương thức lấy danh sách ID kích thước đã chọn của sản phẩm
        public function getSelectedSizes($product_id)
        {
            $sql = self::$connection->prepare("SELECT size_id FROM product_size WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $result = $sql->get_result();
            $sizes = [];
            while ($row = $result->fetch_assoc()) {
                $sizes[] = $row['size_id'];
            }
            $sql->close();
            return $sizes;
        }

        public function getAllColors()
        {
            $sql = self::$connection->prepare("SELECT color_id, name FROM color");
            $sql->execute();
            $result = $sql->get_result();
            return $result->fetch_all(MYSQLI_ASSOC); // Trả về mảng các màu sắc
        }

        public function getAllSizes()
        {
            $sql = self::$connection->prepare("SELECT size_id, value FROM size");
            $sql->execute();
            $result = $sql->get_result();
            return $result->fetch_all(MYSQLI_ASSOC); // Trả về mảng các kích thước
        }

        public function getAllBrands()
        {
            $sql = self::$connection->prepare("SELECT brand_id, name FROM brand");
            $sql->execute();
            $result = $sql->get_result();
            return $result->fetch_all(MYSQLI_ASSOC); // Trả về mảng các thương hiệu
        }

        // Thêm phương thức lưu hình ảnh
        public function addProductImage($product_id, $image_url, $is_main)
        {
            $sql = self::$connection->prepare("INSERT INTO product_image (product_id, image_url, is_main) VALUES (?, ?, ?)");
            $sql->bind_param("isi", $product_id, $image_url, $is_main);
            $sql->execute();
            $sql->close();
        }

        // Thêm phương thức lấy hình ảnh chính của sản phẩm
        public function getMainImage($product_id)
        {
            $sql = self::$connection->prepare("SELECT image_url FROM product_image WHERE product_id = ? AND is_main = 1");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $result = $sql->get_result();
            return $result->fetch_assoc();
        }


        public function getAdditionalImages($product_id)
        {
            $sql = self::$connection->prepare("SELECT image_url FROM product_image WHERE product_id = ? AND is_main = 0 LIMIT 3");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $result = $sql->get_result();

            // Tạo mảng chứa các hình ảnh phụ
            $additional_images = [];
            while ($row = $result->fetch_assoc()) {
                $additional_images[] = $row['image_url'];
            }

            return $additional_images; // Trả về mảng hình ảnh phụ
        }


        // Thêm phương thức lưu màu sắc sản phẩm
        public function addProductColor($product_id, $color_id)
        {
            $sql = self::$connection->prepare("INSERT INTO product_color (product_id, color_id) VALUES (?, ?)");
            $sql->bind_param("ii", $product_id, $color_id);
            $sql->execute();
            $sql->close();
        }

        // Thêm phương thức lưu kích thước sản phẩm
        public function addProductSize($product_id, $size_id)
        {
            $sql = self::$connection->prepare("INSERT INTO product_size (product_id, size_id) VALUES (?, ?)");
            $sql->bind_param("ii", $product_id, $size_id);
            $sql->execute();
            $sql->close();
        }

        public function checkProductExists($product_id)
        {
            $sql = self::$connection->prepare("SELECT product_id FROM product WHERE product_id = ?");
            $sql->bind_param("i", $product_id);
            $sql->execute();
            $result = $sql->get_result();
            $sql->close();
            return $result->num_rows > 0;
        }
    }

    $banhang = new Product_db();
