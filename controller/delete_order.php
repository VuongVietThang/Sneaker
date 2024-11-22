<?php 
require_once '../model/db.php';
require_once '../model/order.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
    $orderModel = new Order();
    $isDelete = $orderModel->deleteOrder($order_id);
    if($isDelete){
        header("Location: ../admin/quanlydonhang.php");
        exit();
    }
}else {
    header("Location: ../admin/404.php");
    exit();
}
?>
