<?php
require_once(__DIR__ . '/../config/database.php');

class CreateProductColorTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `product_color` (
                `product_color_id` int NOT NULL AUTO_INCREMENT,
                `product_id` int NOT NULL,
                `color_id` int NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`product_color_id`),
                CONSTRAINT `fk_product_color_product_id` FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_product_color_color_id` FOREIGN KEY (`color_id`) REFERENCES `color`(`color_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    




        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS product_color;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
