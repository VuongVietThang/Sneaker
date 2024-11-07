<?php
require_once 'db.php';

class Size extends Db
{
    public function getSizeById($size_id)
    {
        $sql = self::$connection->prepare("SELECT * FROM size WHERE size_id = ?");
        $sql->bind_param("i", $size_id);
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_assoc();
    }

    public function getAllSizes()
    {
        $sql = self::$connection->prepare("SELECT * FROM size ORDER BY value");
        $sql->execute();
        $result = $sql->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
