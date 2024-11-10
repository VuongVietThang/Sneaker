<?php 
session_start();
require_once '../model/user.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
    $user_id = $_SESSION['user']['user_id'];
    $userModel = new User();
    $isFavorite = $userModel->addToFavorites($user_id, $product_id);
    if($isFavorite){
        header("Location: ../view/profile.php");
        exit();
    }
    header("Location: ../view/index.php");
    exit();
}