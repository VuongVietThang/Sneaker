<?php include 'header.php';
$secret_salt = "my_secret_salt";
function decryptBrandId($encryptedId, $secret_salt)
{
    $decoded = base64_decode($encryptedId);
    // Loại bỏ chuỗi salt để lấy lại brand_id
    return str_replace($secret_salt, '', $decoded);
}

function encryptBrandId($brand_id, $secret_salt)
{
    // Thêm chuỗi salt để tăng độ bảo mật
    return base64_encode($brand_id . $secret_salt);
}

$brandModel = new Brand();
$brandsWithCount = $brandModel->getAllBrandsWithCount();
$productModel = new Product();

// Lấy brand_id và type từ URL nếu có
$encryptedBrandId = isset($_GET['brand_id']) ? $_GET['brand_id'] : null;

// Lưu ý là đây là id đã được mã hóa
$type = isset($_GET['type']) ? $_GET['type'] : null;

// Giải mã brand_id
if ($encryptedBrandId) {

    $brand_id = decryptBrandId($encryptedBrandId, $secret_salt); // Giải mã brand_id

} else {
    $brand_id = null; // Nếu không có brand_id, gán null
}

// Kiểm tra nếu có brand_id, thực hiện truy vấn
if ($brand_id) {
    // Lấy danh sách sản phẩm dựa theo brand_id và type
    $products = $productModel->getProductsByBrandAndType($brand_id, $type);
} else {
    // Nếu không có brand_id, khởi tạo danh sách sản phẩm trống
    $products = [];
}

// Hiển thị sản phẩm ở đây, ví dụ:
?>

<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Shop Category</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ================ end banner area ================= -->


<!-- ================ category section start ================= -->
<section class="section-margin--small mb-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="sidebar-categories">
                    <div class="head">Browse Brand</div>
                    <ul class="main-categories">
                        <li class="common-filter">
                            <form action="#" id="filterForm">
                                <ul class="filter-list">
                                    <?php foreach ($brandsWithCount as $brand):
                                        $encryptedBrandId = encryptBrandId($brand['brand_id'], $secret_salt);
                                    ?>

                                        <li>
                                            <input class="pixel-radio" type="radio" name="brand" value="<?php echo htmlspecialchars($encryptedBrandId); ?>" onchange="loadProducts(this.value)">
                                            <label for="<?php echo htmlspecialchars($brand['brand_id']); ?>">
                                                <?php echo htmlspecialchars($brand['brand_name']); ?>
                                                <span> (<?php echo htmlspecialchars($brand['product_count']); ?>)</span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <!-- Start Filter Bar -->
                <div class="filter-bar d-flex flex-wrap align-items-center">
                    <div class="sorting">
                        <select>
                            <option value="1">Default sorting</option>
                            <option value="1">Default sorting</option>
                            <option value="1">Default sorting</option>
                        </select>
                    </div>
                    <div class="sorting mr-auto">
                        <select>
                            <option value="1">Show 12</option>
                            <option value="1">Show 12</option>
                            <option value="1">Show 12</option>
                        </select>
                    </div>
                    <div>
                        <div class="input-group filter-bar-search">
                            <input type="text" placeholder="Search">
                            <div class="input-group-append">
                                <button type="button"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Filter Bar -->
                <!-- Start Best Seller -->
                <section class="lattest-product-area pb-40 category-list">
                    <div class="row" id="product-list">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card text-center card-product">
                                        <div class="card-product__img">
                                            <img class="card-img" src="../img/<?php echo htmlspecialchars($product['image_url'] ?? ''); ?>" alt="">
                                            <ul class="card-product__imgOverlay">
                                                <li><button><i class="ti-search"></i></button></li>
                                                <li>
                                                    <button onclick="addToCart(<?php echo htmlspecialchars(json_encode([
                                                                                    'brand_id' => $brand_id,
                                                                                    'product_id' => $product['product_id'],
                                                                                    'product_name' => $product['name'],
                                                                                    'price' => $product['price']
                                                                                ])); ?>)">
                                                        <i class="ti-shopping-cart"></i>
                                                    </button>
                                                </li>
                                                <li><button><i class="ti-heart"></i></button></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">

                                            <h4 class="card-product__title"><a href="#"><?php echo htmlspecialchars($product['name'] ?? ''); ?></a></h4>
                                            <p class="card-product__price"><?php echo htmlspecialchars(number_format($product['price'] ?? 0)); ?> VND</p>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach;
                        endif; ?>

                    </div>
                </section>
                <script>
                    function addToCart(productData) {
                        // Send an AJAX request to add the product to the cart
                        fetch('add_to_cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(productData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Product added to cart successfully!');
                                    // You can update the cart icon or perform any other UI updates here
                                } else {
                                    alert('Failed to add product to cart. Please try again.');
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                alert('An error occurred. Please try again.');
                            });
                    }
                </script>
                <!-- End Best Seller -->
            </div>
        </div>
    </div>
</section>
<!-- ================ category section end ================= -->

<!-- ================ top product area start ================= -->
<section class="related-product-area">
    <div class="container">
        <div class="section-intro pb-60px">
            <p>Popular Item in the market</p>
            <h2>Top <span class="section-intro__style">Product</span></h2>
        </div>
        <div class="row mt-30">
            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-1.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-2.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-3.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-4.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-5.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-6.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-7.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-8.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-9.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-1.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-2.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-3.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================ top product area end ================= -->

<!-- ================ Subscribe section start ================= -->
<section class="subscribe-position">
    <div class="container">
        <div class="subscribe text-center">
            <h3 class="subscribe__title">Get Update From Anywhere</h3>
            <p>Bearing Void gathering light light his eavening unto dont afraid</p>
            <div id="mc_embed_signup">
                <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe-form form-inline mt-5 pt-1">
                    <div class="form-group ml-sm-auto">
                        <input class="form-control mb-1" type="email" name="EMAIL" placeholder="Enter your email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '">
                        <div class="info"></div>
                    </div>
                    <button class="button button-subscribe mr-auto mb-1" type="submit">Subscribe Now</button>
                    <div style="position: absolute; left: -5000px;">
                        <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
<!-- ================ Subscribe section end ================= -->

<?php include 'footer.php'; ?>