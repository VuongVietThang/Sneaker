<?php 
require_once '../model/db.php';
require_once '../model/cart.php';
require 'send_mail.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$shippingAddress = isset($_POST['shippingAddress']) ? $_POST['shippingAddress'] : '';
    $user_id = $_SESSION['user']['user_id'];
    $user_email = $_SESSION['user']['email'];
    // create
    $CartModel = new Cart();
    $newOrder = $CartModel->createOrder($user_id,$shippingAddress);
    // send mail 
    if($newOrder){
        sendMail($user_email, 'Đơn hàng đã đặt thành công', 'Chúc mừng bạn! Đơn hàng của bạn đã được đặt thành công. Chúng tôi sẽ sớm xử lý và giao hàng cho bạn.');
        header("Location: ../view/cart.php");
        exit();
    }else{
        echo 'Không thể đc';
    }
}

