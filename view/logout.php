<?php
session_start();

// Xóa tất cả session
session_unset(); // Xóa tất cả biến session
session_destroy(); // Hủy session hiện tại

// Chuyển hướng về trang đăng nhập hoặc trang chủ
header("Location: index.php");
exit();
?>
