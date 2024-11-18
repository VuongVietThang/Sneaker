<?php
require_once(__DIR__ . '/../config/database.php');

class CreateReviewTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `review` (
                `review_id` int NOT NULL AUTO_INCREMENT,
                `user_id` int NOT NULL,
                `product_id` int NOT NULL,
                `rating` tinyint NOT NULL,
                `comment` text NOT NULL,
                `review_date` datetime DEFAULT CURRENT_TIMESTAMP,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`review_id`),
                CONSTRAINT `fk_review_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk_review_product_id` FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";


    

        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS review;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
