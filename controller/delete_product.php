<?php
require_once '../model/product_db.php';
require_once '../model/encryption_helpers.php';

if (isset($_GET['product_id'])) {
    $product_id = decryptProductId($_GET['product_id']);

    if (!$product_id) {
        header("Location: ../admin/quanlysanpham.php?error=invalid_product_id");
        exit();
    }

    $product_db = new Product_db();

    if (!$product_db->checkProductExists($product_id)) {
        header("Location: ../admin/404.php");
        exit();
    }

    // Xóa thông tin liên quan đến sản phẩm
    $product_db->deleteProductImagesAndFiles($product_id);
    $product_db->deleteProductColors($product_id);
    $product_db->deleteProductSizes($product_id);
    $product_db->deleteProduct($product_id);

    header("Location: ../admin/quanlysanpham.php?success=product_deleted");
    exit();
} else {

    header("Location: ../admin/quanlysanpham.php?error=missing_product_id");

    // Nếu không có product_id, có thể redirect hoặc hiển thị thông báo lỗi
    header("Location: ../admin/404.php");

    exit();
}
?>
