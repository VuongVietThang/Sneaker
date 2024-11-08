<?php
include 'header.php';
?>


<main class="site-main">

  <!--================ Hero banner start =================-->
  <section class="hero-banner">
    

   
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php
          if (!empty($banners)):
          foreach ($banners as $banner): ?>
          <div class="swiper-slide"><img src="../images/banner/<?php echo htmlspecialchars($banner['image_url'] ?? ''); ?>" ></div>
          <?php endforeach; endif; ?>
          
        </div>
       
        <!-- Điểm đánh dấu -->
        <div class="swiper-pagination"></div>
      </div>
  

    <!-- Dấu chấm điều hướng -->

  </section>
  <!--================ Hero banner start =================-->

  <!--================ Hero Carousel start =================-->
  <section class="section-margin calc-60px">
    <div class="container">
        <div class="section-intro pb-60px">
            <h2>New <span class="section-intro__style">Product</span></h2>
        </div>
        <div class="owl-carousel owl-theme" id="newestProductCarousel">
            <?php if (!empty($newestProducts)):
                foreach ($newestProducts as $product):
                  $encoded_brand_id = base64_encode($product['brand_id'] . $secret_salt);
                    $encoded_type = base64_encode($product['type'] . $secret_salt);
            ?>
                <div class="card text-center card-product">
                    <div class="card-product__img">
                        <img class="img-fluid" src="../images/product/<?php echo htmlspecialchars($product['image_url'] ?? 'default.jpg'); ?>" alt="">
                        <ul class="card-product__imgOverlay">
                            <li>
                                <button onclick="window.location.href='brand.php?brand_id=<?php echo urlencode($encoded_brand_id); ?>&type=<?php echo urlencode($encoded_type); ?>'">
                                    <i class="ti-search"></i>
                                </button>
                            </li>
                            <li><button><i class="ti-shopping-cart"></i></button></li>
                            <li><button><i class="ti-heart"></i></button></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <p> <?php echo htmlspecialchars($product['brand_name'] ?? ''); ?></p>
                        <h4 class="card-product__title"><a href="single-product.html"><?php echo htmlspecialchars($product['name'] ?? ''); ?></a></h4>
                        <p class="card-product__price"><?php echo number_format($product['price'], 0, ',', '.' ?? ''); ?> VND</p>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>



  <!--================ Hero Carousel end =================-->

  <!-- ================ trending product section start ================= -->
  <section class="section-margin calc-60px">
    <div class="container">
      <div class="section-intro pb-60px">
        <p>Popular Item in the market</p>
        <h2>Trending <span class="section-intro__style">Product</span></h2>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product1.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Accessories</p>
              <h4 class="card-product__title"><a href="single-product.html">Quartz Belt Watch</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product2.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Beauty</p>
              <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product3.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Decor</p>
              <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product4.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Decor</p>
              <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product5.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Accessories</p>
              <h4 class="card-product__title"><a href="single-product.html">Man Office Bag</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product6.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Kids Toy</p>
              <h4 class="card-product__title"><a href="single-product.html">Charging Car</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product7.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Accessories</p>
              <h4 class="card-product__title"><a href="single-product.html">Blutooth Speaker</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="../images/product/product8.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Kids Toy</p>
              <h4 class="card-product__title"><a href="#">Charging Car</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ trending product section end ================= -->


  <!-- ================ offer section start ================= -->
  <section class="offer" id="parallax-1" data-anchor-target="#parallax-1" data-300-top="background-position: 20px 30px" data-top-bottom="background-position: 0 20px">
    <div class="container">
      <div class="row">
        <div class="col-xl-5">
          <div class="offer__content text-center">
            <h3>Up To 50% Off</h3>
            <h4>Winter Sale</h4>
            <p>Him she'd let them sixth saw light</p>
            <a class="button button--active mt-3 mt-xl-4" href="#">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ offer section end ================= -->

  <!-- ================ Best Selling item  carousel ================= -->
  <section class="section-margin calc-60px">
    <div class="container">
        <div class="section-intro pb-60px">
            <h2>Best <span class="section-intro__style">Sellers</span></h2>
        </div>
        <div class="owl-carousel owl-theme" id="bestSellerCarousel">
            <?php if (!empty($sellProducts)):
                foreach ($sellProducts as $product):
                  $encoded_brand_id = base64_encode($product['brand_id'] . $secret_salt);
                    $encoded_type = base64_encode($product['type'] . $secret_salt);
            ?>
                <div class="card text-center card-product">
                    <div class="card-product__img">
                        <img class="img-fluid" src="../images/product/<?php echo htmlspecialchars($product['image_url'] ?? ''); ?>" alt="">
                        <ul class="card-product__imgOverlay">
                            <li>
                                <button onclick="window.location.href='brand.php?brand_id=<?php echo urlencode($encoded_brand_id); ?>&type=<?php echo urlencode($encoded_type); ?>'">
                                    <i class="ti-search"></i>
                                </button>
                            </li>
                            <li><button><i class="ti-shopping-cart"></i></button></li>
                            <li><button><i class="ti-heart"></i></button></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <p> <?php echo htmlspecialchars($product['brand_name'] ?? ''); ?></p>
                        <h4 class="card-product__title"><a href="single-product.html"><?php echo htmlspecialchars($product['name'] ?? ''); ?></a></h4>
                        <p class="card-product__price"><?php echo number_format($product['price'], 0, ',', '.' ?? ''); ?> VND</p>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
  <!-- ================ Best Selling item  carousel end ================= -->

  <!-- ================ Blog section start ================= -->
  <section class="blog">
    <div class="container">
      <div class="section-intro pb-60px">
        <p>Popular Item in the market</p>
        <h2>Latest <span class="section-intro__style">News</span></h2>
      </div>

      <div class="row">
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card card-blog">
            <div class="card-blog__img">
              <img class="card-img rounded-0" src="../images/blog/blog1.png" alt="">
            </div>
            <div class="card-body">
              <ul class="card-blog__info">
                <li><a href="#">By Admin</a></li>
                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
              </ul>
              <h4 class="card-blog__title"><a href="single-blog.html">The Richland Center Shooping News and weekly shooper</a></h4>
              <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
              <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card card-blog">
            <div class="card-blog__img">
              <img class="card-img rounded-0" src="../images/blog/blog2.png" alt="">
            </div>
            <div class="card-body">
              <ul class="card-blog__info">
                <li><a href="#">By Admin</a></li>
                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
              </ul>
              <h4 class="card-blog__title"><a href="single-blog.html">The Shopping News also offers top-quality printing services</a></h4>
              <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
              <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card card-blog">
            <div class="card-blog__img">
              <img class="card-img rounded-0" src="../images/blog/blog3.png" alt="">
            </div>
            <div class="card-body">
              <ul class="card-blog__info">
                <li><a href="#">By Admin</a></li>
                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
              </ul>
              <h4 class="card-blog__title"><a href="single-blog.html">Professional design staff and efficient equipment you’ll find we offer</a></h4>
              <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
              <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ Blog section end ================= -->

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



</main>

<?php
include 'footer.php';
?>
<!--================ Start footer Area  =================-->