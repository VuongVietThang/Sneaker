<?php
include '../config/database.php';
include '../model/db.php'; // Đảm bảo bao gồm tệp chứa kết nối cơ sở dữ liệu

// Khởi tạo kết nối
$db = new Db();
$connection = Db::$connection; // Lấy kết nối

if (isset($_POST['brand_id'])) {
    $brandId = $_POST['brand_id'];

    // Sử dụng kết nối mysqli để thực hiện truy vấn
    $stmt = $connection->prepare("SELECT p.*, pi.image_url
FROM product p
LEFT JOIN product_image pi ON p.product_id = pi.product_id AND pi.is_main = 1
WHERE p.brand_id = ?
");
    $stmt->bind_param('s', $brandId); // 's' cho kiểu dữ liệu string
    $stmt->execute();

    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    // Xử lý hiển thị sản phẩm
    foreach ($products as $product) {
        echo '<div class="col-md-6 col-lg-4">';
        echo '    <div class="card text-center card-product">';
        echo '        <div class="card-product__img">';
        echo '            <img class="card-img" src="../images/product/' . htmlspecialchars($product['image_url'] ?? '') . '" alt="">';
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
    echo 'Không có brand_id được gửi.';
}
