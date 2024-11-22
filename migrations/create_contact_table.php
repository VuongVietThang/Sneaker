<?php
require_once(__DIR__ . '/../config/database.php');

class CreateContactTable
{
    public static function up()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS `contact` (
            `id` int NOT NULL AUTO_INCREMENT,
            `email` varchar(100) NOT NULL,
            `phone` int NOT NULL,
            `message` varchar(255) NOT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS contact;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
