<?php 
require_once '../model/contact.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $contact = new Contact();

    if ($contact->createContact($email, $phone, $message)) {
        $_SESSION['success'] = "Contact created successfully!";
    } else {
        $_SESSION['error'] = "Failed to create contact.";
    }
    header("Location: ../view/index.php");
    exit();
}
?>
