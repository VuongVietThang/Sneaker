<?php
require_once '../model/faq.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $faq_id = $_POST['faq_id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $faqModel = new FAQ();
    $faqModel->updateFAQById($faq_id, $question, $answer);

    header("Location: ../admin/quanlyFAQ.php");
    exit();
}
