<?php
// Khởi động session để có thể hiển thị thông báo nếu cần
session_start();

// Kết nối với tệp chứa class Cart
include_once '../model/cart.php';

// Kiểm tra xem `cart_item_id` có được gửi qua URL không
if (isset($_GET['cart_item_id'])) {
    // Lấy giá trị `cart_item_id` từ URL
    $cartItemId = intval($_GET['cart_item_id']);

    // Tạo đối tượng Cart để gọi phương thức removeProductFromCart
    $cartModel = new Cart();

    // Gọi hàm xóa sản phẩm khỏi giỏ hàng
    $isRemoved = $cartModel->removeProductFromCart($cartItemId);

    // Kiểm tra xem sản phẩm đã được xóa thành công chưa
    if ($isRemoved) {
        $_SESSION['message'] = "Sản phẩm đã được xóa khỏi giỏ hàng thành công.";
    } else {
        $_SESSION['error'] = "Không thể xóa sản phẩm khỏi giỏ hàng.";
    }
} else {
    $_SESSION['error'] = "Mã sản phẩm không hợp lệ.";
}

// Sau khi xóa, chuyển hướng lại về trang giỏ hàng
header("Location: ../view/cart.php");
exit;
