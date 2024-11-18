<?php

require_once '../model/db.php';
require_once '../model/faq.php';

$faq = new FAQ();


if (isset($_GET['id'])) {
    $faq_id = $_GET['id'];
    if ($faq->deleteFAQById($faq_id)) {
        header("Location: ../admin/quanlyFAQ.php");
        exit();
    } else {
        echo "Có lỗi xảy ra khi xóa câu hỏi. Vui lòng thử lại!";
    }
} else {
    echo "ID của câu hỏi không hợp lệ.";
}
?>
