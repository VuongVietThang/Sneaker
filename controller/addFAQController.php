<?php
require_once '../model/db.php';
require_once '../model/faq.php';
$faq = new FAQ();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    if($faq->createFAQ($question, $answer)){
        header("Location: ../admin/quanlyFAQ.php");
        exit();
    }
}
?>