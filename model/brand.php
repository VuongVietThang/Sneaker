<?php
class Brand extends Db
{
    // Lấy tất cả danh mục
    public function getAllBrand()
    {
        $sql = self::$connection->prepare("SELECT * FROM brand");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllBrandsWithCount()
    {
        $sql = self::$connection->prepare("
            SELECT b.brand_id, b.name AS brand_name, COUNT(p.product_id) AS product_count
            FROM brand b
            LEFT JOIN product p ON b.brand_id = p.brand_id
            GROUP BY b.brand_id
        ");

        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
