<?php
require_once(__DIR__ . '/../config/database.php');

class CreateProductSizeTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `product_size` (
                `product_size_id` int NOT NULL AUTO_INCREMENT,
                `product_id` int NOT NULL,
                `size_id` int NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`product_size_id`),
                CONSTRAINT `fk_product_size_product_id` FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_product_size_size_id` FOREIGN KEY (`size_id`) REFERENCES `size`(`size_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

    

        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS product_size;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
