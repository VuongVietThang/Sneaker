<?php
require_once 'db.php';

class Color extends Db
{
    public function getColorById($color_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM color WHERE color_id = ?");
        $sql->bind_param("i", $color_id);
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_assoc();
    }

    public function getAllColors()
    {
        $sql = self::$connection->prepare("SELECT * FROM color ORDER BY name");
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
