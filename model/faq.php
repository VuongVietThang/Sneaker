<?php
include_once __DIR__ . '../db.php';
class FAQ extends Db
{
    public function getTotalFAQCount() {
        $sql = "SELECT COUNT(*) AS total FROM faq";
        $result = self::$connection->query($sql);
        $data = $result->fetch_assoc();
        return $data['total'];
    }
    
    public function getAllFAQ($page = 1) {
        $items_per_page = 10;
        $offset = ($page - 1) * $items_per_page;
        $sql = "SELECT * FROM faq LIMIT ? OFFSET ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ii", $items_per_page, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getFAQById($faq_id) {
        $sql = "SELECT * FROM faq WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $faq_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();  // Trả về một dòng dữ liệu
    }
    // Tạo FAQ mới
    public function createFAQ($question, $answer) {
        $sql = "INSERT INTO faq (question, answer) VALUES (?, ?)";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ss", $question, $answer);
        return $stmt->execute();  // Trả về true nếu thành công, false nếu thất bại
    }
    // Xóa FAQ theo ID
    public function deleteFAQById($faq_id) {
        $sql = "DELETE FROM faq WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("i", $faq_id);
        return $stmt->execute();  // Trả về true nếu thành công, false nếu thất bại
    }
    // Cập nhật FAQ theo ID
    public function updateFAQById($faq_id, $question, $answer) {
        $sql = "UPDATE faq SET question = ?, answer = ? WHERE id = ?";
        $stmt = self::$connection->prepare($sql);
        $stmt->bind_param("ssi", $question, $answer, $faq_id);
        return $stmt->execute();  // Trả về true nếu thành công, false nếu thất bại
    }
}