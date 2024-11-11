<?php
session_start();

// Include tệp chứa lớp Cart và tạo đối tượng Cart
include_once '../model/Cart.php';
$cartModel = new Cart();

// Kiểm tra xem `cart_item_id` có được gửi qua URL không
if (isset($_GET['cart_item_id'])) {
    // Lấy giá trị `cart_item_id` từ URL
    $cartItemId = intval($_GET['cart_item_id']);

    // Gọi hàm xóa sản phẩm khỏi giỏ hàng
    $isRemoved = $cartModel->removeProductFromCart($cartItemId);

    // Kiểm tra xem sản phẩm đã được xóa thành công chưa
    if ($isRemoved) {
        $_SESSION['message'] = "Product removed from cart successfully.";
    } else {
        $_SESSION['error'] = "Failed to remove product from cart.";
    }
} else {
    $_SESSION['error'] = "Invalid product ID.";
}

// Quay lại trang giỏ hàng sau khi xóa
header("Location: ../view/cart.php"); // Đảm bảo đường dẫn đúng tới view giỏ hàng
exit;
