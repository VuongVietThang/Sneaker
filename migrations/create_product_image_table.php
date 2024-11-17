<?php
require_once(__DIR__ . '/../config/database.php');

class CreateProductImageTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `product_image` (
                `image_id` int NOT NULL AUTO_INCREMENT,
                `product_id` int NOT NULL,
                `image_url` varchar(255) NOT NULL,
                `is_main` tinyint(1) NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`image_id`),
                CONSTRAINT `fk_product_image_product_id` FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    

        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS product_image;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
