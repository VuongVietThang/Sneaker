<?php
require_once(__DIR__ . '/../config/database.php');

class CreatePaymentTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `payment` (
                `payment_id` int NOT NULL AUTO_INCREMENT,
                `order_id` int NOT NULL,
                `payment_method` enum('credit_card', 'paypal', 'bank_transfer') NOT NULL,
                `payment_date` datetime DEFAULT NULL,
                `payment_status` enum('pending', 'completed', 'failed') NOT NULL,
                `transaction` varchar(255) NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`payment_id`),
                CONSTRAINT `fk_payment_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`) 
                    ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";




        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS payment;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
