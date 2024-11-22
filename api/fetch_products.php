<?php
include '../config/database.php';
include '../model/db.php'; // Bao gồm tệp chứa lớp Db và kết nối cơ sở dữ liệu
require '../model/encryption_helpers.php';

// Khởi tạo kết nối cơ sở dữ liệu
$db = new Db();
$connection = Db::$connection; // Lấy kết nối

// Kiểm tra xem brand_id có được gửi từ AJAX hay không
if (isset($_POST['brand_id'])) {

    $brandId = decryptProductId($_POST['brand_id']);
    $db = new Db();
    $connection = Db::$connection;
    // Chuẩn bị truy vấn lấy sản phẩm theo brand_id
    $stmt = $connection->prepare("SELECT p.*, pi.image_url
                                  FROM product p
                                  LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
                                  WHERE p.brand_id = ?");
    if ($stmt) {
        $stmt->bind_param('s', $brandId); // 's' cho kiểu dữ liệu string
        $stmt->execute();

        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);

        // Hiển thị sản phẩm
        if (!empty($products)) {
            foreach ($products as $product) {
                echo '<div class="col-md-6 col-lg-4">';
                echo '    <div class="card text-center card-product">';
                echo '        <div class="card-product__img">';
                echo '            <img style="width: 255px; height: 325px;" class="card-img" src="../images/product/' . htmlspecialchars($product['image_url'] ?? '') . '" alt="">';
                echo '            <ul class="card-product__imgOverlay">';
                echo '                <li><button><i class="ti-search"></i></button></li>';
                echo '                <li><button><i class="ti-shopping-cart"></i></button></li>';
                echo '                <li><button><i class="ti-heart"></i></button></li>';
                echo '            </ul>';
                echo '        </div>';
                echo '        <div class="card-body">';
                echo '            <h4 class="card-product__title"><a href="#">' . htmlspecialchars($product['name'] ?? '') . '</a></h4>';
                echo '            <p class="card-product__price">' . htmlspecialchars(number_format($product['price'] ?? 0)) . ' VND</p>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            exit();
        }
        
        $stmt->close();
    } else {
        exit();
    }
} else {
    exit();
}
?>
