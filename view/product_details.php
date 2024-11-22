    <?php
    include 'header.php';
    require_once '../model/product_db.php';
    require_once '../model/encryption_helpers.php';

    $product_db = new Product_db();

    if (isset($_GET['product_id'])) {
        $encrypted_product_id = $_GET['product_id'];
        $product_id = decryptProductId($encrypted_product_id);

        // Kiểm tra nếu giải mã không thành công
        if ($product_id === false || !is_numeric($product_id)) {
            header("Location: products.php");
            exit();
        }

        $products = $product_db->timSanPham($product_id);

        // Lấy các sản phẩm liên quan
        $related_products = $product_db->getRelatedProducts($product_id);
    } else {
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
            width: 430px;
            /* Đặt chiều rộng cố định */
            height: 430px;
            /* Đặt chiều cao cố định */
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            /* Đảm bảo hình ảnh hiển thị đúng tỷ lệ */
        }

        /* CSS cho hình ảnh phụ */
        .additional-image {
            width: 137px;
            /* Đặt chiều rộng cố định */
            height: 145px;
            /* Đặt chiều cao cố định */
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Khi rê chuột vào ảnh phụ */
        .additional-image:hover {
            transform: scale(1.1);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
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

        /* CSS cho lựa chọn màu sắc */
        .color-options {
            display: flex;
            gap: 10px;
        }

        /* CSS cho vòng màu sắc */
        .color-circle {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ddd;
            cursor: pointer;
            transition: transform 0.2s;
        }

        /* Khi rê chuột vào vòng màu sắc */
        .color-circle:hover {
            transform: scale(1.1);
            border-color: #333;
        }

        /* CSS cho các nút kích thước */
        .size-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-left: 8px;
        }

        /* CSS cho từng nút kích thước */
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

        /* Khi rê chuột vào nút kích thước */
        .size-btn:hover {
            background-color: #ddd;
        }

        /* CSS cho màu sắc đã chọn */
        .color-circle.selected {
            border: 2px solid #333;
            transform: scale(1.3);
        }

        /* CSS cho kích thước đã chọn */
        .size-btn.selected {
            background-color: #999999;
            border-color: #0dcaf0;
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
                                    echo '<img id="mainImage" src="' . $image_url . '" alt="Hình ảnh chính sản phẩm" class="main-image">';
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
                                            echo '<img src="' . $full_image_url . '" alt="Ảnh phụ sản phẩm" class="additional-image" onclick="swapImage(this)">';
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
                                            echo '<span class="color-circle" title="' . htmlspecialchars($color_name) . '" style="background-color: ' . htmlspecialchars($color_name) . ';" data-color="' . htmlspecialchars($color_name) . '"></span>';
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
                                            echo '<button class="size-btn" data-size="' . htmlspecialchars($size) . '">' . htmlspecialchars($size) . '</button>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- Thêm vào giỏ hàng -->
                                <form action="../controller/addToCartController.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id'] ?>" />
                                    <input type="hidden" name="color" id="selectedColorInput" />
                                    <input type="hidden" name="size" id="selectedSizeInput" />
                                    <input type="hidden" name="quantity" id="inputQuantity" value="1" />

                                    <div class="d-flex align-items-center">
                                        <label for="inputQuantity" class="me-2">Số lượng:</label>
                                        <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" min="1" style="max-width: 4rem" />

                                        <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                            <i class="bi-cart-fill me-1"></i>
                                            Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </form>

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
                <h2 class="fw-bolder mb-4">Đánh giá sản phẩm</h2>

            </div>
        </section>
        <section class="section-margin calc-60px">
            <div class="container">
                <div class="section-intro pb-60px">
                    <h2>Sản phẩm<span class="section-intro__style"> liên quan</span></h2>
                </div>

                <div class="owl-carousel owl-theme" id="newestProductCarousel">
                    <?php if (!empty($related_products)) : ?>
                        <?php foreach ($related_products as $related_product) : ?>
                            <div class="card text-center card-product">
                                <div class="card-product__img">
                                    <?php
                                    // Lấy URL của ảnh chính của sản phẩm
                                    $related_main_image = $product_db->getMainImage($related_product['product_id']);
                                    $related_image_url = $related_main_image ? '../images/product/' . htmlspecialchars($related_main_image['image_url']) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
                                    ?>
                                    <img class="card-img-top related-product-image" src="<?php echo $related_image_url; ?>" alt="Hình ảnh sản phẩm: <?php echo htmlspecialchars($related_product['name']); ?>" />
                                </div>

                                <div class="card-body">
                                    <p><?php echo htmlspecialchars($related_product['brand_name'] ?? ''); ?></p>
                                    <h4 class="card-product__title">
                                        <a href="product_details.php?product_id=<?= urlencode(encryptProductId($related_product['product_id'] ?? '')); ?>">
                                            <?= htmlspecialchars($related_product['name'] ?? ''); ?>
                                        </a>
                                    </h4>
                                    <p class="card-product__price"><?php echo number_format($related_product['price'], 0, ',', '.'); ?> VNĐ</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Không có sản phẩm liên quan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <script>
            function swapImage(clickedImage) {
                // Lấy ảnh chính
                const mainImage = document.getElementById('mainImage');

                // Lưu src của ảnh chính tạm thời
                const tempSrc = mainImage.src;

                // Đổi src giữa ảnh chính và ảnh phụ được click
                mainImage.src = clickedImage.src;
                clickedImage.src = tempSrc;
            }
        </script>
        <script>
            // Đặt biến toàn cục để lưu trữ màu sắc và kích thước đã chọn
            let selectedColor = null;
            let selectedSize = null;
            let quantity = document.getElementById('inputQuantity').value;

            // Xử lý sự kiện khi chọn màu
            const colorCircles = document.querySelectorAll('.color-circle');
            colorCircles.forEach(circle => {
                circle.addEventListener('click', function() {
                    // Hủy bỏ chọn màu trước đó
                    colorCircles.forEach(c => c.classList.remove('selected'));

                    // Đánh dấu màu được chọn
                    this.classList.add('selected');
                    selectedColor = this.getAttribute('data-color');
                    console.log(selectedColor);

                    // Cập nhật màu sắc trong giỏ hàng
                    updateCartButton();
                    updateHiddenInputs();
                });
            });

            // Xử lý sự kiện khi chọn kích thước
            const sizeButtons = document.querySelectorAll('.size-btn');
            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Hủy bỏ chọn kích thước trước đó
                    sizeButtons.forEach(b => b.classList.remove('selected'));

                    // Đánh dấu kích thước được chọn
                    this.classList.add('selected');
                    selectedSize = this.getAttribute('data-size');
                    console.log(selectedSize);
                    // Cập nhật kích thước trong giỏ hàng
                    updateCartButton();
                    updateHiddenInputs();
                });
            });

            // Cập nhật nút giỏ hàng để hiển thị màu và kích thước đã chọn
            function updateCartButton() {
                const cartButton = document.querySelector('button[type="submit"]');

                // Cập nhật thông tin màu sắc và kích thước vào nút giỏ hàng
                if (selectedColor && selectedSize) {
                    cartButton.innerHTML = `<i class="bi-cart-fill me-1"></i> Thêm vào giỏ hàng - Màu: ${selectedColor}, Kích thước: ${selectedSize}`;
                } else if (selectedColor) {
                    cartButton.innerHTML = `<i class="bi-cart-fill me-1"></i> Thêm vào giỏ hàng - Màu: ${selectedColor}`;
                } else if (selectedSize) {
                    cartButton.innerHTML = `<i class="bi-cart-fill me-1"></i> Thêm vào giỏ hàng - Kích thước: ${selectedSize}`;
                } else {
                    cartButton.innerHTML = `<i class="bi-cart-fill me-1"></i> Thêm vào giỏ hàng`;
                }
            }

            // Cập nhật các trường ẩn trong form
            function updateHiddenInputs() {
                document.getElementById('selectedColorInput').value = selectedColor || '';
                document.getElementById('selectedSizeInput').value = selectedSize || '';
                document.getElementById('inputQuantity').value = quantity;
            }

            // Cập nhật số lượng
            document.getElementById('inputQuantity').addEventListener('input', function() {
                quantity = this.value;
                updateHiddenInputs();
            });
        </script>

        <?php
        include 'footer.php';
        ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>