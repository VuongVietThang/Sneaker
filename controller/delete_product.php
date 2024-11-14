<?php
require_once '../model/product_db.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product_db = new Product_db(); 

    // Kiểm tra nếu sản phẩm tồn tại
    if (!$product_db->checkProductExists($product_id)) {
        header("Location: ../admin/quanlysanpham.php?error=product_not_found");
        exit();
    }

    // Xóa thông tin hình ảnh của sản phẩm
    $product_db->deleteProductImagesAndFiles($product_id); // Thay đổi phương thức

    // Xóa thông tin màu sắc của sản phẩm
    $product_db->deleteProductColors($product_id);

    // Xóa thông tin kích thước của sản phẩm
    $product_db->deleteProductSizes($product_id);

    // Cuối cùng, xóa sản phẩm chính
    $product_db->deleteProduct($product_id);  

    header("Location: ../admin/quanlysanpham.php");
    exit();
} else {
    // Nếu không có product_id, có thể redirect hoặc hiển thị thông báo lỗi
    header("Location: ../admin/quanlysanpham.php?error=invalid_id");
    exit();
}
?>
