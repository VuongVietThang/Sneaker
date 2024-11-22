<?php include 'header.php';

$brandModel = new Brand();
$brandsWithCount = $brandModel->getAllBrandsWithCount();
$productModel = new Product();
// Lấy brand_id và type từ URL nếu có 
$encryptedBrandId = isset($_GET['brand_id']) ? $_GET['brand_id'] : null;
//get color
$allColors = $productModel->getAllColors();
$allBrands = $productModel->getAllBrands();

// Kiểm tra nếu có dữ liệu hợp lệ và giải mã
if ($encryptedBrandId !== null) {
    // Giải mã dữ liệu từ URL
    $brand_id = decryptProductId($encryptedBrandId); // Giải mã brand_id
   
} else {
    // Nếu không có dữ liệu hợp lệ, gán giá trị mặc định
    $brand_id = null;
    
}
// lọc
$products = [];
// Kiểm tra nếu có brand_id và type hợp lệ
if ($brand_id !== null) {
    // Truy vấn danh sách sản phẩm theo brand_id và type
    $products = $productModel->getProductsByBrand($brand_id);
} else {
    // Nếu không có thông tin, gán danh sách sản phẩm rỗng
    $products = [];
}
if (isset($_GET['brand_id']) && isset($_GET['color_name'])) { 
    $brand_id = $_GET['brand_id']; $color_name = $_GET['color_name']; 
    $product = new Product(); 
    $filteredProducts = $product->fillterProduct($brand_id, $color_name); 
    $products = $filteredProducts;
}
// Hiển thị sản phẩm ở đây, ví dụ:
?>

<!-- ================ start banner area ================= -->
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
                                        $encryptedBrandId = encryptProductId($brand['brand_id'] ?? '');
                                        ?>
                                        
                                        <li>
                                        <input class="pixel-radio" type="radio" name="brand" value="<?php echo htmlspecialchars($encryptedBrandId); ?>" <?php echo ($brand_id == $brand['brand_id']) ? 'checked' : ''; ?>>

                                            <label for="<?php echo htmlspecialchars($brand['brand_name']); ?>">
                                                <?php echo htmlspecialchars($brand['brand_name']); ?>
                                                <span>  (<?php echo htmlspecialchars($brand['product_count']); ?>)</span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- <div class="sidebar-filter">
                    <div class="top-filter-head">Product Filters</div>
                    <div class="common-filter">
                        <div class="head">Brands</div>
                        <form action="#">
                            <ul>
                                <?php foreach ($allBrands as $brand):?>
                                    <li class="filter-list"><input class="pixel-radio" type="radio" id="apple" name="brand">
                                    <label for="apple"><?php echo $brand['name'] ?></label>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                    </div>
                    <div class="common-filter">
                        <div class="head">Color</div>
                            <ul>
                                <?php foreach ($allColors as $color):?>
                                    <li class="filter-list">
                                        <input class="pixel-radio" type="radio" id="<?php echo htmlspecialchars($color['color_id']);?>" name="color">
                                        <label for="<?php echo htmlspecialchars($color['name']);?>"><?php echo htmlspecialchars($color['name']);?></label>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </form>
                    </div>
                    <div class="common-filter">
                        <div class="head">Price</div>
                        <div class="price-range-area">
                            <div id="price-range"></div>
                            <div class="value-wrapper d-flex">
                                <div class="price">Price:</div>
                                <span>$</span>
                                <div id="lower-value"></div>
                                <div class="to">to</div>
                                <span>$</span>
                                <div id="upper-value"></div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="sidebar-filter">
                    <div class="top-filter-head">Product Filters</div>
                    
                    <!-- Filter by Brands -->
                    <div class="common-filter">
                        <div class="head">Brands</div>
                        <form id="filter-form">
                            <ul>
                                <?php foreach ($allBrands as $brand): ?>
                                    <li class="filter-list">
                                        <input class="pixel-radio" type="radio" id="brand_<?php echo htmlspecialchars($brand['name']); ?>" name="brand_id" value="<?php echo $brand['brand_id']; ?>">
                                        <label for="brand_<?php echo htmlspecialchars($brand['name']); ?>"><?php echo htmlspecialchars($brand['name']); ?></label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <!-- Filter by Color -->
                        <div class="common-filter">
                            <div class="head">Color</div>
                            <ul>
                                <?php foreach ($allColors as $color): ?>
                                    <li class="filter-list">
                                        <input class="pixel-radio" type="radio" id="color_<?php echo htmlspecialchars($color['color_id']); ?>" name="color_name" value="<?php echo htmlspecialchars($color['name']); ?>">
                                        <label for="color_<?php echo htmlspecialchars($color['name']); ?>"><?php echo htmlspecialchars($color['name']); ?></label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Submit Button -->
                            <div class="common-filter text-center">
                                <button type="submit" class="btn btn-primary btn-lg btn-sm">Apply Filters</button>
                            </div>
                        </div>
                    </form>
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
                        <form action="search_result.php" method="get">
                            <div class="input-group filter-bar-search">
                                <input type="text" name="searchTerm" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button"><i class="ti-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Filter Bar -->
                <!-- Start Best Seller -->
                <section class="lattest-product-area pb-40 category-list">
                    <div class="row" id="productList">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
<<<<<<< HEAD
=======
<<<<<<< HEAD
                                <div class="col-md-6 col-lg-4">
                                    <div class="card text-center card-product">
                                        <div class="card-product__img">
                                            <img style="width: 255px; height: 325px;" class="card-img" src="../images/product/<?php echo htmlspecialchars($product['image_url'] ?? ''); ?>" alt="">
                                            <ul class="card-product__imgOverlay">
                                               
                                                <li><button><i class="ti-shopping-cart"></i></button></li>
                                                <li><button><i class="ti-heart"></i></button></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">

                                            <h4 class="card-product__title"><a href="#"><?php echo htmlspecialchars($product['name'] ?? ''); ?></a></h4>
                                            <p class="card-product__price"><?php echo htmlspecialchars(number_format($product['price'] ?? 0)); ?> VND</p>
=======
>>>>>>> a9b2f78 (Merge branch 'main' into chart)
                                <a href="#">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card text-center card-product">
                                            <div class="card-product__img">
                                                <img class="card-img" src="../images/product/<?php echo htmlspecialchars($product['image_url'] ?? ''); ?>" alt="">
                                                <ul class="card-product__imgOverlay">
                                                
                                                <li>
                                                    <form action="../controller/addToCartController.php" method="post">
                                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id'] ?>" id="">
                                                            <button><i class="ti-shopping-cart"></i></button>
                                                    </form>
                                                </li>
                                                    <li><button><i class="ti-heart"></i></button></li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
    
                                                <h4 class="card-product__title"><a href="#"><?php echo htmlspecialchars($product['name'] ?? ''); ?></a></h4>
                                                <p class="card-product__price"><?php echo htmlspecialchars(number_format($product['price'] ?? 0)); ?> VND</p>
                                            </div>
<<<<<<< HEAD
=======
>>>>>>> main
>>>>>>> a9b2f78 (Merge branch 'main' into chart)
                                        </div>
                                    </div>
                                </a>
                        <?php endforeach;
                        endif; ?>

                    </div>
                </section>
                <!-- End Best Seller -->
            </div>
        </div>
    </div>
</section>
<!-- ================ category section end ================= -->

<!-- ================ top product area start ================= -->

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