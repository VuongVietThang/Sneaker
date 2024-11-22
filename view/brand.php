<?php include 'header.php';

$brandModel = new Brand();
$brandsWithCount = $brandModel->getAllBrandsWithCount();
$productModel = new Product();
// Lấy brand_id và type từ URL nếu có 
$encryptedBrandId = isset($_GET['brand_id']) ? $_GET['brand_id'] : null;


// Kiểm tra nếu có dữ liệu hợp lệ và giải mã
if ($encryptedBrandId !== null) {
    // Giải mã dữ liệu từ URL
    $brand_id = decryptProductId($encryptedBrandId); // Giải mã brand_id
   
} else {
    // Nếu không có dữ liệu hợp lệ, gán giá trị mặc định
    $brand_id = null;
    
}

// Kiểm tra nếu có brand_id và type hợp lệ
if ($brand_id !== null) {
    // Truy vấn danh sách sản phẩm theo brand_id và type
    $products = $productModel->getProductsByBrand($brand_id);
} else {
    // Nếu không có thông tin, gán danh sách sản phẩm rỗng
    $products = [];
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
                <div class="sidebar-filter">
                    <div class="top-filter-head">Product Filters</div>
                    <div class="common-filter">
                        <div class="head">Brands</div>
                        <form action="#">
                            <ul>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="apple" name="brand"><label for="apple">Apple<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="asus" name="brand"><label for="asus">Asus<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="gionee" name="brand"><label for="gionee">Gionee<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="micromax" name="brand"><label for="micromax">Micromax<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="samsung" name="brand"><label for="samsung">Samsung<span>(19)</span></label></li>
                            </ul>
                        </form>
                    </div>
                    <div class="common-filter">
                        <div class="head">Color</div>
                        <form action="#">
                            <ul>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="black" name="color"><label for="black">Black<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="balckleather" name="color"><label for="balckleather">Black
                                        Leather<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="blackred" name="color"><label for="blackred">Black
                                        with red<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="gold" name="color"><label for="gold">Gold<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="spacegrey" name="color"><label for="spacegrey">Spacegrey<span>(19)</span></label></li>
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
                    <div class="row" id="productList">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
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
                                        </div>
                                    </div>
                                </div>
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