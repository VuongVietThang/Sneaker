<?php 
require_once '../model/db.php';
require_once '../model/cart.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$shippingAddress = isset($_POST['shippingAddress']) ? $_POST['shippingAddress'] : '';
    $user_id = $_SESSION['user']['user_id'];
    // create
    $CartModel = new Cart();
    $newOrder = $CartModel->createOrder($user_id,$shippingAddress);
    if($newOrder){
        header("Location: ../view/cart.php");
        exit();
    }
}
die();
