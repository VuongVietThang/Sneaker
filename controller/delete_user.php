<?php 
require '../model/user.php';
require '../model/encryption_helpers.php';


if (isset($_GET['user_id'])) {
    $user_id = decryptProductId($_GET['user_id']);

    // Kiểm tra banner_id là số hợp lệ
    if (!is_numeric($user_id)) {
        header("Location: ../admin/404.php");
        exit();
    }

    $userModel = new User();

    // Gọi phương thức deleteBanner
    $deleteUser = $userModel->deleteUser($user_id);

    if ($deleteUser) {
        // Nếu xóa thành công, chuyển hướng về trang quản lý
        header("Location: ../admin/quanlyuser.php");
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
