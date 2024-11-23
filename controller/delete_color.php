<?php 
include '../config/database.php';
require '../model/db.php';
require '../model/color.php';  // Assuming you have a Color model instead of Brand
require '../model/encryption_helpers.php';

if (isset($_GET['color_id'])) {
    $color_id = decryptProductId($_GET['color_id']); // Using decryptProductId for color_id

    // Kiểm tra color_id là số hợp lệ
    if (!is_numeric($color_id)) {
        header("Location: ../admin/404.php");
        exit();
    }

    $colorModel = new Color(); // Use Color model instead of Brand

    // Gọi phương thức deleteColor
    $deleteColor = $colorModel->deleteColor($color_id);

    if ($deleteColor) {
        // Nếu xóa thành công, chuyển hướng về trang quản lý
        header("Location: ../admin/quanlycolor.php");  // Redirect to color management page
        exit();
    } else {
        // Nếu không xóa thành công, chuyển hướng đến trang lỗi
        header("Location: ../admin/404.php");
        exit();
    }
} else {
    // Nếu không có color_id trong URL, chuyển hướng đến trang lỗi
    header("Location: ../admin/404.php");
    exit();
}
?>
