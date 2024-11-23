<?php
include_once __DIR__ . '../db.php';

class Contact extends Db
{
    public function createContact($email, $phone, $message)
    {
        $sql = self::$connection->prepare("INSERT INTO contact (email, phone, message, created_at) VALUES (?, ?, ?, NOW())");
        $sql->bind_param("sss", $email, $phone, $message);
        return $sql->execute();
    }
    public function getTotalContactCount() {
        $sql = "SELECT COUNT(*) AS total FROM contact";
        $result = self::$connection->query($sql);
        $data = $result->fetch_assoc();
        return $data['total'];
    }
    
    public function getAllContact($page = 1) {
        $items_per_page = 10;
        $offset = ($page - 1) * $items_per_page;
        $sql = "SELECT * FROM contact LIMIT ? OFFSET ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
