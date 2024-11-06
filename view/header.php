<?php
// Kết nối đến cơ sở dữ liệu (đảm bảo bạn đã bao gồm file db.php hoặc tương tự)
include '../config/database.php';
require '../model/db.php';
require '../model/brand.php';
require '../model/product.php';
require '../model/banner.php';

session_start();

$brandModel = new Brand();
$brands = $brandModel->getAllBrand();
$bannerModel = new Banner();
$banners = $bannerModel->getAllBanner();
$productModel = new Product();
$newestProducts = $productModel->getNewProducts(10);
$productModel = new Product();
$sellProducts = $productModel->getBestSellingProducts(10);

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
              <li class="nav-item active"><a class="nav-link" href="index.php">HOME</a></li>
              <?php
              
              if (isset($brands) && is_array($brands) && !empty($brands)):
                foreach ($brands as $item):
                  
                    
                    // Mã hóa brand_id với secret_salt
                    $encoded_brand_id = base64_encode($item['brand_id'] . $secret_salt);
                    $encoded_type = base64_encode($item['type'] . $secret_salt);
              ?>
                    <li class="nav-item submenu dropdown">
                      <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false"><?php echo htmlspecialchars($item['name']); ?></a>
                      <ul class="dropdown-menu">
                      
                      <?php if (!empty($item['type'])): ?>
                        <li class="nav-item">
                          <a class="nav-link" href="brand.php?brand_id=<?php echo urlencode($encoded_brand_id); ?>&type=<?php echo urlencode($encoded_type); ?>">
                            <?php echo htmlspecialchars($item['type']); ?>
                          </a>
                        </li>
                      <?php endif; ?>
                      </ul>
                    </li>
                <?php endforeach;
              endif; ?>
            </ul>
            <ul class="nav-shop">
              <li class="nav-item"><button><i class="ti-search"></i></button></li>
              <li class="nav-item"><button><i class="ti-shopping-cart"></i><span class="nav-shop__circle">3</span></button> </li>
            </ul>
            <ul class="nav-user">
              <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti-user"></i> <?php echo $_SESSION['user']['name']; ?>
                  </a>
                  <div class="logout">
                    <div class="dropdown-menu dropdowns" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item info" href="">Profile</a>
                      <a class="dropdown-item info" href="logout.php">Logout</a>
                    </div>
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
</body>

</html>