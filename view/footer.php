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
              <li><img src="../images/gallery/r1.jpg" alt=""></li>
              <li><img src="../images/gallery/r2.jpg" alt=""></li>
              <li><img src="../images/gallery/r3.jpg" alt=""></li>
              <li><img src="../images/gallery/r5.jpg" alt=""></li>
              <li><img src="../images/gallery/r7.jpg" alt=""></li>
              <li><img src="../images/gallery/r8.jpg" alt=""></li>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Xử lý sự kiện khi thay đổi radio button
    $('input[name="brand"]').on('change', function() {
        const brandId = $(this).val(); // Lấy giá trị brand_id của radio được chọn
        
        $.ajax({
            url: '../api/fetch_products.php', // Tệp PHP xử lý yêu cầu
            method: 'POST',
            data: { brand_id: brandId }, // Gửi brand_id tới server
            success: function(response) {
                $('#productList').html(response); // Đổ dữ liệu sản phẩm vào div có id là 'productList'
            },
            error: function() {
                alert('Lỗi khi tải sản phẩm!');
            }
        });
    });

    // Khởi tạo Swiper
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: {
            delay: 5000,  // Thời gian giữa các slide
            disableOnInteraction: false,  // Không tắt autoplay khi người dùng tương tác
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,  // Cho phép click vào pagination
        },
    });

    // Dừng autoplay khi hover vào
    const swiperContainer = document.querySelector('.swiper-container');
    if (swiperContainer) {
        swiperContainer.addEventListener('mouseover', function() {
            swiper.autoplay.stop();  // Dừng autoplay
        });

        // Tiếp tục autoplay khi hover ra ngoài
        swiperContainer.addEventListener('mouseout', function() {
            swiper.autoplay.start();  // Tiếp tục autoplay
        });
    }

    // Khởi tạo Owl Carousel cho best seller
    $('#bestSellerCarousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true, // Hiển thị nút điều hướng
        dots: false, // Không hiển thị dot
        autoplay: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });

    $('#newestProductCarousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true, // Hiển thị nút điều hướng
        dots: false, // Không hiển thị dot
        autoplay: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });
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