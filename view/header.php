<?php
// Kết nối đến cơ sở dữ liệu (đảm bảo bạn đã bao gồm file db.php hoặc tương tự)
include '../config/database.php';
require '../model/db.php';
require '../model/brand.php';
require '../model/product.php';
require '../model/banner.php';
require '../model/cart.php';
require '../model/user.php';
session_start();
$brandModel = new Brand();
$userModel = new User();
$brands = $brandModel->getAllBrand();
$bannerModel = new Banner();
$banners = $bannerModel->getAllBannerByAction();
$productModel = new Product();
$newestProducts = $productModel->getNewProducts(10);
$productModel = new Product();
$sellProducts = $productModel->getBestSellingProducts(10);
if (isset($_SESSION['user']['user_id'])) {
  $user_id = $_SESSION['user']['user_id'];
  $cartModel = new Cart();
  $totalCart = $cartModel->countItemsInCart($user_id);
} else {
  // Gán giá trị mặc định nếu người dùng chưa đăng nhập
  $totalCart = 1;  // Hoặc hiển thị thông báo lỗi, tùy vào yêu cầu của bạn
}


// Chuỗi bảo mật cho việc mã hóa
$secret_salt = "my_secret_salt";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aroma Shop - Home</title>
  <link rel="stylesheet" href="../css/swiper-bundle.min.css">
  <link rel="icon" href="../images/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="../css/themify-icons.css">
  <link rel="stylesheet" href="../css/nice-select.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/linericon.css">
  <link rel="stylesheet" href="../css/nouislider.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>


<body>
  <!--================ Start Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.php"><img src="../images/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <!-- Mục HOME mặc định có class active -->
              <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/index.php' ? 'active' : ''); ?>">
                <a class="nav-link" href="index.php">HOME</a>
              </li>

              <?php
              if (isset($brands)):
                foreach ($brands as $item):
                  // Mã hóa brand_id với secret_salt
                  $encoded_brand_id = base64_encode($item['brand_id'] . $secret_salt);

                  // Kiểm tra xem brand_id trong URL hiện tại có trùng với brand_id của item này không
                  $isActive = (isset($_GET['brand_id']) && $_GET['brand_id'] === urlencode($encoded_brand_id)) ? 'active' : '';
              ?>
                  <li class="nav-item submenu dropdown <?php echo $isActive; ?>">
                    <a href="brand.php?brand_id=<?php echo urlencode($encoded_brand_id); ?>" class="nav-link dropdown-toggle">
                      <?php echo htmlspecialchars($item['name']); ?>
                    </a>
                  </li>
              <?php endforeach;
              endif; ?>
            </ul>
            <ul class="nav-shop">
              <li class="nav-item">
                <div id="search-container">
                  <!-- <form id="search-form" action="search_api.php" method="GET">
                    <input type="text" id="search-input" name="query" placeholder="Search products..." autocomplete="off">
                  </form> -->
                  <ul id="search-results" class="search-results-list" style="display: none;"></ul>
                </div>
              </li>
              <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item"><a href="./cart.php"><button><i class="ti-shopping-cart"></i><span class="nav-shop__circle"><?php echo $totalCart ?></span></button> </a></li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti-user"></i> <?php echo $_SESSION['user']['name']; ?>
                  </a>
                  <div class="dropdown-menu dropdowns" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item info" href="../admin/index.php">ADMIN</a>
                    <a class="dropdown-item info" href="profile.php">Profile</a>
                    <a class="dropdown-item info" href="logout.php">Logout</a>
                  </div>
                </li>
              <?php else: ?>
                <li class="nav-item"><a class="button button-header" href="login.php">LOGIN</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <script src="../js/header.js"></script>
</body>

</html>