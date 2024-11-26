<?php 
require_once '../model/db.php';
require_once '../model/cart.php';

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Lấy các giá trị từ form
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
    $user_id = $_SESSION['user']['user_id'];
    $size_id = isset($_POST['size_id']) ? $_POST['size_id'] : 1; // Lấy size được chọn, mặc định là 1 nếu không có
    $color_id = isset($_POST['color_id']) ? $_POST['color_id'] : 1; // Lấy màu sắc được chọn, mặc định là 1 nếu không có
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Lấy số lượng, mặc định là 1 nếu không có

    // Kiểm tra nếu các dữ liệu cần thiết có tồn tại
    if ($product_id) {
        // Thêm vào giỏ hàng
        $CartModel = new Cart();
        //$sizeId = $CartModel->getSize($sizeValue);
        // var_dump($sizeId);
        //$colorId = $CartModel->getColor($colorName);
        $newCart = $CartModel->addToCart($user_id, $product_id, $size_id, $color_id, $quantity);
        
        if ($newCart) {
            // Chuyển hướng đến trang giỏ hàng
            header("Location: ../view/cart.php");
            exit();
        } else {
            // Nếu có lỗi trong quá trình thêm sản phẩm vào giỏ
            echo "Có lỗi xảy ra khi thêm vào giỏ hàng.";
        }
    } else {
        // Nếu thiếu thông tin cần thiết
        echo "Dữ liệu không hợp lệ.";
    }
}

