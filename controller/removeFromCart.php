<?php 
require_once '../model/cart.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$cart_item_id = isset($_GET['cart_item_id']) ? $_GET['cart_item_id'] : 0;
    $CartModel = new Cart();
    $isDeleted = $CartModel->removeProductFromCart($cart_item_id);
    if($isDeleted){
        header("Location: ../view/cart.php");
        exit();
    }else{
        header("Location: ../view/cart.php");
        exit();
    }
}

