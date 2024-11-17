<?php
require_once(__DIR__ . '/../config/database.php');

class CreateFavoriteTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `favorite` (
                `id` int NOT NULL AUTO_INCREMENT,
                `user_id` int NOT NULL,
                `product_id` int NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk_favorite_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE,
                CONSTRAINT `fk_favorite_product_id` FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) ON DELETE CASCADE
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        ";


    

        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS favorite;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
