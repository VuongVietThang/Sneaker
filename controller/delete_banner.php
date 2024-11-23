<?php 
require '../model/banner.php';
require '../model/encryption_helpers.php';


if (isset($_GET['banner_id'])) {
    $banner_id = decryptProductId($_GET['banner_id']);



    // Kiểm tra banner_id là số hợp lệ
    if (!is_numeric($banner_id)) {
        header("Location: ../admin/404.php");
        exit();
    }

    $bannerModel = new Banner();

    // Gọi phương thức deleteBanner
    $deleteBanner = $bannerModel->deleteBanner($banner_id);

    if ($deleteBanner) {
        // Nếu xóa thành công, chuyển hướng về trang quản lý
        header("Location: ../admin/quanlybanner.php");
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
