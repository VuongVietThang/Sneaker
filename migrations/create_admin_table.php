<?php
require_once(__DIR__ . '/../config/database.php');


class CreateAdminTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `admin` (
                `admin_id` int NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `username` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`admin_id`)
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    

        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS admin;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
