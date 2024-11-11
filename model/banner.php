<?php
class Banner extends Db
{
    public function getAllBanner(){
        $sql = self::$connection->prepare("SELECT * FROM banner WHERE `action` = 1 ORDER BY `order` ASC");
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}