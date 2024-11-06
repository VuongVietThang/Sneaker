<footer class="footer">
  <div class="footer-area">
    <div class="container">
      <div class="row section_gap">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="single-footer-widget tp_widgets">
            <h4 class="footer_title large_title">Our Mission</h4>
            <p>
              So seed seed green that winged cattle in. Gathering thing made fly you're no
              divided deep moved us lan Gathering thing us land years living.
            </p>
            <p>
              So seed seed green that winged cattle in. Gathering thing made fly you're no divided deep moved
            </p>
          </div>
        </div>
        <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
          <div class="single-footer-widget tp_widgets">
            <h4 class="footer_title">Quick Links</h4>
            <ul class="list">
              <li><a href="#">Home</a></li>
              <li><a href="#">Shop</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Product</a></li>
              <li><a href="#">Brand</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="single-footer-widget instafeed">
            <h4 class="footer_title">Gallery</h4>
            <ul class="list instafeed d-flex flex-wrap">
              <li><img src="../img/gallery/r1.jpg" alt=""></li>
              <li><img src="../img/gallery/r2.jpg" alt=""></li>
              <li><img src="../img/gallery/r3.jpg" alt=""></li>
              <li><img src="../img/gallery/r5.jpg" alt=""></li>
              <li><img src="../img/gallery/r7.jpg" alt=""></li>
              <li><img src="../img/gallery/r8.jpg" alt=""></li>
            </ul>
          </div>
        </div>
        <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
          <div class="single-footer-widget tp_widgets">
            <h4 class="footer_title">Contact Us</h4>
            <div class="ml-40">
              <p class="sm-head">
                <span class="fa fa-location-arrow"></span>
                Head Office
              </p>
              <p>123, Main Street, Your City</p>

              <p class="sm-head">
                <span class="fa fa-phone"></span>
                Phone Number
              </p>
              <p>
                +123 456 7890 <br>
                +123 456 7890
              </p>

              <p class="sm-head">
                <span class="fa fa-envelope"></span>
                Email
              </p>
              <p>
                free@infoexample.com <br>
                www.infoexample.com
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <div class="row d-flex">
        <p class="col-lg-12 footer-text text-center">
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          Copyright &copy;<script>
            document.write(new Date().getFullYear());
          </script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </p>
      </div>
    </div>
  </div>
</footer>
<!--================ End footer Area  =================-->

<script>
  window.addEventListener('touchmove', function(e) {
    e.preventDefault(); // Ngừng hành vi mặc định của cuộn
  }, {
    passive: false
  }); // Đánh dấu sự kiện là non-passive
</script>
<script>
  function loadProducts(encryptedBrandId) {
    const type = document.querySelector('input[name="type"]:checked')?.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'brand.php?brand_id=' + encodeURIComponent(encryptedBrandId) + '&type=' + encodeURIComponent(type) + '&ajax=true', true);

    xhr.onload = function() {
      if (xhr.status === 200) {
        const products = JSON.parse(xhr.responseText);
        const productList = document.getElementById('product-list');
        productList.innerHTML = '';

        products.forEach(product => {
          productList.innerHTML += `
                    <div class="col-md-6 col-lg-4">
                        <div class="card text-center card-product">
                            <div class="card-product__img">
                                <img class="card-img" src="../img/${product.image_url}" alt="">
                                <ul class="card-product__imgOverlay">
                                    <li><button><i class="ti-search"></i></button></li>
                                    <li><button><i class="ti-shopping-cart"></i></button></li>
                                    <li><button><i class="ti-heart"></i></button></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h4 class="card-product__title"><a href="#">${product.name}</a></h4>
                                <p class="card-product__price">${Number(product.price).toLocaleString()} VND</p>
                            </div>
                        </div>
                    </div>
                `;
        });
      } else {
        console.error('Error fetching products: ' + xhr.statusText);
      }
    };

    xhr.send();
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    let swiper = new Swiper('.swiper-container', {
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });

    // Hàm tạm dừng slide
    window.pauseSlide = function() {
      swiper.autoplay.stop();
    };

    // Hàm tiếp tục slide
    window.startAutoSlide = function() {
      swiper.autoplay.start();
    };
  });
</script>







<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/skrollr.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/jquery.nice-select.min.js"></script>
<script src="../js/jquery.ajaxchimp.min.js"></script>
<script src="../js/mail-script.js"></script>
<script src="../js/mains.js"></script>
<script src="../js/nouislider.min.js"></script>
<script src="../js/swiper-bundle.min.js"></script>
</body>

</html>