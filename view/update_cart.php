<?php
session_start();

// Kiểm tra xem các tham số có được gửi đến không
if (isset($_POST['product_id'], $_POST['size_id'], $_POST['color_id'], $_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $sizeId = $_POST['size_id'];
    $colorId = $_POST['color_id'];
    $quantity = $_POST['quantity'];

    // Kiểm tra và cập nhật giỏ hàng
    if ($quantity > 0) {
        // Cập nhật giỏ hàng trong session
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['size_id'] = $sizeId;
            $_SESSION['cart'][$productId]['color_id'] = $colorId;
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    } else {
        // Xóa sản phẩm khỏi giỏ hàng nếu số lượng bằng 0
        unset($_SESSION['cart'][$productId]);
    }

    // Trả về kết quả cho client (dạng JSON)
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
