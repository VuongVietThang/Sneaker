<?php
class Product extends Db
{
    public function searchProducts($searchTerm) {
        $sql = "SELECT p.product_id, p.name, p.description, p.price, p.type, pi.image_url 
        FROM product p LEFT JOIN product_image pi 
        ON p.product_id = pi.product_id AND pi.is_main = 1 
        WHERE p.name LIKE ? OR p.description LIKE ? OR p.type LIKE ?"; 
        $stmt = self::$connection->prepare($sql);
        $searchTerm = "%$searchTerm%"; 
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm); $stmt->execute(); 
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 
    }
    public function getAllColors(){
        $sql = self::$connection->prepare("SELECT * FROM color");
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getAllBrands(){
        $sql = self::$connection->prepare("SELECT * FROM brand");
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function fillterProduct($brand_id, $color_name) {
        $sql = " 
        SELECT p.product_id, p.name AS name, p.price, pi.image_url, c.name AS color_name 
        FROM product p 
        JOIN product_color pc ON p.product_id = pc.product_id 
        JOIN color c ON pc.color_id = c.color_id 
        LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1 
        WHERE p.brand_id = ? AND c.name = ? 
        ";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("is", $brand_id, $color_name);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getSizeId($product_id)
    {
        $sql = "SELECT size_id FROM product_size WHERE product_id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $sizeIds = [];
            while ($row = $result->fetch_assoc()) {
                $sizeIds[] = $row['size_id'];
            }
            return $sizeIds;
        } else {
            return null;
        }
    }
    public function getColorId($pro_id) {}
    // Lấy sản phẩm theo brand_id và type
    public function getProductsByBrand($brand_id)
    {
        $sql = self::$connection->prepare("SELECT p.product_id, p.name, p.price, pi.image_url
                FROM product p
                LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
                WHERE p.brand_id = ?");



        $sql->bind_param("i", $brand_id);


        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public static function getNewProducts($limit)
    {
        $sql = self::$connection->prepare("SELECT p.product_id, p.name, p.type, p.price, pi.image_url, b.brand_id, b.name AS brand_name
            FROM product p
            LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
            LEFT JOIN brand b ON p.brand_id = b.brand_id
            ORDER BY p.created_at DESC
            LIMIT ?");

        // Liên kết biến limit vào câu truy vấn
        $sql->bind_param("i", $limit); // "i" là kiểu dữ liệu Integer
        $sql->execute();

        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function getBestSellingProducts($limit)
    {
        $sql = self::$connection->prepare("SELECT p.product_id, p.name, p.type, p.price, pi.image_url, b.brand_id, b.name AS brand_name, SUM(oi.quantity) AS total_sold
                  FROM product p
                  JOIN order_item oi ON p.product_id = oi.product_id
                  JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
                  JOIN orders o ON oi.order_id = o.order_id
                  JOIN brand b ON p.brand_id = b.brand_id
                  WHERE o.status = 'completed'
                  GROUP BY p.product_id
                  ORDER BY total_sold DESC
                  LIMIT ?");

        // Liên kết biến limit vào câu truy vấn
        $sql->bind_param("i", $limit); // "i" là kiểu dữ liệu Integer
        $sql->execute();

        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Get the most popular products (to be implemented)
    public function getProductPopular() {
        $sql = "
            SELECT 
                p.product_id,
                p.name,
                p.price,
                SUM(oi.quantity) AS total_quantity,
                pi.image_url,
                b.brand_id,
                b.name AS brand_name
            FROM 
                product p
            JOIN 
                order_item oi ON p.product_id = oi.product_id
            JOIN 
                product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
            JOIN 
                orders o ON oi.order_id = o.order_id
            JOIN 
                brand b ON p.brand_id = b.brand_id
            GROUP BY 
                p.product_id
            ORDER BY 
                total_quantity DESC
            LIMIT 8;
        ";
        $stmt = self::$connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
