<?php
class Product extends Db
{
    public function getSizeId($product_id) {
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
    public function getColorId($pro_id){
        
    }
    // Lấy sản phẩm theo brand_id và type
    public function getProductsByBrandAndType($brand_id, $type = null) {
        $sql = "SELECT p.product_id, p.name, p.price, pi.image_url
                FROM product p
                LEFT JOIN product_image pi ON p.product_id = pi.product_id
                WHERE p.brand_id = ?";
        
        if ($type !== null) {
            $sql .= " AND p.type = ?";
        }
    
        $stmt = self::$connection->prepare($sql);
        
        if ($type !== null) {
            $stmt->bind_param("is", $brand_id, $type);
        } else {
            $stmt->bind_param("i", $brand_id);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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


}
