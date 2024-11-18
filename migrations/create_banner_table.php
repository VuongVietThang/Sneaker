<?php
require_once(__DIR__ . '/../config/database.php');

class CreateBannerTable
{
    public static function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `banner` (
                `banner_id` int NOT NULL AUTO_INCREMENT,
                `image_url` varchar(255) NOT NULL,
                `order` int NOT NULL,
                `action` enum('Show','Hiden') NOT NULL DEFAULT 'Show',
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`banner_id`)
            ) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }

    public static function down()
    {
        $sql = "DROP TABLE IF EXISTS banner;";
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);
        $connection->query($sql);
        $connection->close();
    }
}
?>
