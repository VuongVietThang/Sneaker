<?php
class Product extends Db
{
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
    

    public function getProductsByBrand($brand_id)
    {
        $sql = self::$connection->prepare("
            SELECT p.product_id, p.name, p.price, pi.image_url
            FROM product p
            LEFT JOIN product_image pi ON p.product_id = pi.product_id
            WHERE p.brand_id = ?
        ");
        $sql->bind_param("i", $brand_id); // Gán tham số brand_id
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
