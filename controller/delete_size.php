<?php 
include '../config/database.php';
require '../model/db.php';
require '../model/size.php';  // Thay 'brand.php' thành 'size.php' để sử dụng model Size
require '../model/encryption_helpers.php';

if (isset($_GET['size_id'])) {
    $size_id = decryptProductId($_GET['size_id']);  // Giải mã size_id

    // Kiểm tra xem size_id có phải là số hợp lệ không
    if (!is_numeric($size_id)) {
        header("Location: ../admin/404.php");
        exit();
    }

    $sizeModel = new Size();  // Tạo đối tượng Size

    // Gọi phương thức deleteSize
    $deleteSize = $sizeModel->deleteSize($size_id);

    if ($deleteSize) {
        // Nếu xóa thành công, chuyển hướng về trang quản lý size
        header("Location: ../admin/quanlysize.php");
        exit();
    } else {
        // Nếu không xóa thành công, chuyển hướng đến trang lỗi
        header("Location: ../admin/404.php");
        exit();
    }
} else {
    // Nếu không có size_id trong URL, chuyển hướng đến trang lỗi
    header("Location: ../admin/404.php");
    exit();
}
?>
