<?php 
require_once '../model/cart.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
    $user_id = $_SESSION['user']['user_id'];
    $sizeId = 1;
    $colorId = 1;
    // add
    $CartModel = new Cart();
    $isDeleted = $CartModel->removeProductInCart($user_id,$product_id,$sizeId,$colorId);
    if($isDeleted){
        header("Location: ../view/cart.php");
        exit();
    }else{
        echo "Không thể xóa";
    }
}

