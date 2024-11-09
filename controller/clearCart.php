<?php 
require_once '../model/cart.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['user_id'];
    $CartModel = new Cart();
    $isCleared = $CartModel->clearMyCart($user_id);

    if (!$isCleared) {
        header("Location: ../view/cart.php?errors=Giỏ hàng trống");
        exit();
    }

    header("Location: ../view/cart.php");
    exit();
}