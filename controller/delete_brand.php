<?php 
include '../config/database.php';
require '../model/db.php';
require '../model/brand.php';
require '../model/encryption_helpers.php';


if (isset($_GET['brand_id'])) {
    $brand_id = decryptProductId($_GET['brand_id']);

    // Kiểm tra banner_id là số hợp lệ
    if (!is_numeric($brand_id)) {
        header("Location: ../admin/404.php");
        exit();
    }

    $brandModel = new Brand();

    // Gọi phương thức deleteBanner
    $deleteBrand = $brandModel->deleteBrand($brand_id);

    if ($deleteBrand) {
        // Nếu xóa thành công, chuyển hướng về trang quản lý
        header("Location: ../admin/quanlybrand.php");
        exit();
    } else {
        // Nếu không xóa thành công, chuyển hướng đến trang lỗi
        header("Location: ../admin/404.php");
        exit();
    }
} else {
    // Nếu không có banner_id trong URL, chuyển hướng đến trang lỗi
    header("Location: ../admin/404.php");
    exit();
}
?>
