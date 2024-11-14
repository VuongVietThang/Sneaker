<?php
require_once '../model/product_db.php';
$product_db = new Product_db();
// Lấy sản phẩm cho trang hiện tại
$products = $product_db->getAllProductWithDetails();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Chi Tiết</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/style_details.css" rel="stylesheet" />
</head>

<body>
    <section class="py-5">
   

            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <!-- Main image -->
                    

                        <div class="d-flex overflow-auto" style="max-width: 77%; padding-bottom: 10px; margin-top: 20px;">
                        
                        </div>
                    </div>
             <div class="col-md-6">
    <h1 class="display-5 fw-bolder">Tên Sản Phẩm</h1>
    <div class="fs-5 mb-5">
        <span>Giá: <span class="text-danger">120,000 VNĐ</span></span>
    </div>
    <p class="lead">Mô tả: Giày thể thao chất lượng cao, phù hợp cho mọi lứa tuổi.</p>

    <!-- Kiểu giày -->
    <div class="small mb-1"><strong>Kiểu Giày:</strong> Sneaker</div>

    <!-- Hãng -->
    <div class="small mb-1"><strong>Hãng:</strong> Nike</div>

    <!-- Màu -->
    <div class="small mb-1"><strong>Màu:</strong> Đen</div>

    <!-- Kích thước -->
    <div class="small mb-1"><strong>Kích thước:</strong> 42</div>

    <!-- Nhập số lượng và thêm vào giỏ hàng -->
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
    </section>

    <!-- Related items section-->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Related products</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- Add related products here -->
                <!-- Example product card -->
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                        <!-- Product image-->
                        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">Special Item</h5>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <!-- Product price-->
                                <span class="text-muted text-decoration-line-through">$20.00</span>
                                $18.00
                            </div>
                        </div>
                        <!-- Product actions-->
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
    <!-- Core theme JS-->

</body>

</html>
