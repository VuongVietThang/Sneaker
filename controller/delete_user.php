<?php 
require '../model/user.php';
function decryptBrandId($decryptedId, $secret_salt)
{
    $decoded = base64_decode($decryptedId);
    return str_replace($secret_salt, '', $decoded);
}
$secret_salt = "my_secret_salt";

if (isset($_GET['user_id'])) {
    $user_id = decryptBrandId($_GET['user_id'],$secret_salt);

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
