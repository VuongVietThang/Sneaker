<?php
require_once(__DIR__ . '/../config/database.php');

class CreateProductTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `product` (
                `product_id` int NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `brand_id` int NOT NULL,
                `description` text NOT NULL,
                `price` int NOT NULL,
                `type` varchar(255) NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`product_id`),
                CONSTRAINT `fk_product_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brand`(`brand_id`)
                    ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS product;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
