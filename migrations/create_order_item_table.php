<?php
require_once(__DIR__ . '/../config/database.php');

class CreateOrderItemTable
{
    public static function up()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `order_item` (
            `order_item_id` int NOT NULL AUTO_INCREMENT,
            `order_id` int NOT NULL,
            `product_id` int NOT NULL,
            `size_id` int NOT NULL,
            `color_id` int NOT NULL,
            `quantity` int NOT NULL,
            `price` int NOT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`order_item_id`),
            CONSTRAINT `fk_order_item_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`) 
                ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `fk_order_item_product_id` FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) 
                ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `fk_order_item_size_id` FOREIGN KEY (`size_id`) REFERENCES `size`(`size_id`) 
                ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `fk_order_item_color_id` FOREIGN KEY (`color_id`) REFERENCES `color`(`color_id`) 
                ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    



        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS order_item;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
