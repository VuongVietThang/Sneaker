<?php 
require_once '../model/db.php';
require_once '../model/order.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
    $orderModel = new Order();
    $status = 'completed';
    $isSuccess = $orderModel->setCompleteOrder($status, $order_id);
    if($isSuccess){
        header("Location: ../admin/quanlydonhang.php");
        exit();
    }
} else {
    header("Location: ../admin/quanlydonhang.php");
    exit();
}
?>
