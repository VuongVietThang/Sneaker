<?php
require_once '../model/product_db.php';
$product_db = new Product_db();

// Kiểm tra nếu product_id có trong URL và là số hợp lệ
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $products = $product_db->timSanPham($product_id);
} else {
    // Điều hướng nếu không có product_id
    header("Location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Trang chi tiết sản phẩm" />
    <meta name="author" content="Admin" />
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style_details.css" rel="stylesheet" />
</head>

<style>
    /* CSS cho hình ảnh chính */
    .main-image {
        width: 100%;
        max-width: 500px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }

    /* CSS cho hình ảnh phụ */
.additional-image {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border-radius: 5px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Khi rê chuột vào ảnh phụ */
.additional-image:hover {
    transform: scale(1.1); /* Phóng to ảnh */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Tăng độ bóng */
}

/* Container căn chỉnh ảnh phụ */
.additional-image-container {
    display: inline-block;
    position: relative;
    margin-bottom: 10px;
}

    /* Container ảnh chính */
    .main-image-container {
        text-align: center;
        margin-bottom: 15px;
    }

    .color-options {
        display: flex;
        gap: 10px;
    }

    .color-circle {
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid #ddd;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .color-circle:hover {
        transform: scale(1.1);
        border-color: #333;
    }

    .size-buttons {
        display: flex;
        gap: 10px;
        /* Khoảng cách giữa các nút */
        flex-wrap: wrap;
        margin-left: 8px;
        /* Khoảng cách giữa "Kích thước:" và các nút */
    }

    .size-btn {
        width: 40px;
        height: 40px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
        line-height: 40px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .size-btn:hover {
        background-color: #ddd;
    }
</style>

<body>
    <section class="py-5">
        <?php if ($products) : // Kiểm tra nếu có sản phẩm 
        ?>
            <?php foreach ($products as $product) : ?>
                <div class="container px-4 px-lg-5 my-5">
                    <div class="row gx-4 gx-lg-5 align-items-center">
                        <div class="col-md-6">
                            <!-- Hình ảnh chính -->
                            <?php
                            $main_image = $product_db->getMainImage($product['product_id']);
                            if ($main_image) {
                                $image_url = '../images/product/' . htmlspecialchars($main_image['image_url']);
                                echo '<div class="main-image-container">';
                                echo '<img src="' . $image_url . '" alt="Hình ảnh chính sản phẩm" class="main-image">';
                                echo '</div>';
                            } else {
                                echo '<p>Chưa có hình ảnh chính</p>';
                            }
                            ?>

                            <!-- Hình ảnh phụ -->
                            <div class="d-flex justify-content-center overflow-auto" style="gap: 10px; max-width: 100%; padding-bottom: 10px; margin-top: 20px;">
                                <?php
                                $additional_images = $product_db->getAdditionalImages($product['product_id']);
                                if ($additional_images) {
                                    foreach ($additional_images as $image_url) {
                                        $full_image_url = '../images/product/' . htmlspecialchars($image_url);
                                        echo '<div class="additional-image-container">';
                                        echo '<img src="' . $full_image_url . '" alt="Ảnh phụ sản phẩm" class="additional-image">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>Chưa có ảnh phụ</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h1 class="display-5 fw-bolder"><?php echo htmlspecialchars($product['name']); ?></h1>
                            <div class="fs-5 mb-5">
                                <span>Giá: <span class="text-danger"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</span></span>
                            </div>
                            <p class="lead">Mô tả: <?php echo htmlspecialchars($product['description']); ?></p>

                            <div class="small mb-1"><strong>Kiểu Giày:</strong> <?php echo htmlspecialchars($product['type']); ?></div>
                            <div class="small mb-1"><strong>Hãng:</strong> <?php echo htmlspecialchars($product['brand_name']); ?></div>
                            <div class="d-flex align-items-center mb-3">
                                <strong class="me-2">Màu sắc:</strong>
                                <div class="color-options">
                                    <?php
                                    $colors = explode(',', $product['color_names']); // Giả định các màu được lưu dưới dạng chuỗi, phân tách bằng dấu phẩy
                                    foreach ($colors as $color_name) {
                                        $color_name = trim($color_name);
                                        echo '<span class="color-circle" title="' . htmlspecialchars($color_name) . '" style="background-color: ' . htmlspecialchars($color_name) . ';"></span>';
                                    }
                                    ?>
                                </div>
                            </div>


                            <div class="small mb-1 d-flex align-items-center">
                                <strong class="mr-2">Kích thước:</strong>
                                <div class="size-buttons ml-2">
                                    <?php
                                    $sizes = explode(',', $product['sizes']); // Tách các kích thước từ chuỗi thành mảng
                                    foreach ($sizes as $size) {
                                        $size = trim($size); // Loại bỏ khoảng trắng thừa nếu có
                                        echo '<button class="size-btn">' . htmlspecialchars($size) . '</button>';
                                    }
                                    ?>
                                </div>
                            </div>


                            <!-- Thêm vào giỏ hàng -->
                            <div class="d-flex align-items-center">
                                <label for="inputQuantity" class="me-2">Số lượng:</label>
                                <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 4rem" />
                                <button class="btn btn-outline-dark flex-shrink-0" type="button">
                                    <i class="bi-cart-fill me-1"></i>
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Sản phẩm không tồn tại hoặc đã bị xóa.</p>
        <?php endif; ?>
    </section>

    <!-- Related products section-->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Sản phẩm liên quan</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- Thêm sản phẩm liên quan ở đây -->
                <!-- Example product card -->
                <div class="col mb-5">
                    <div class="card h-100">
                        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">Special Item</h5>
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <span class="text-muted text-decoration-line-through">$20.00</span>
                                $18.00
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">WEB SITE Bán Giày Trực Tuyến</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>