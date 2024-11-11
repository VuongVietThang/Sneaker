<?php
// Include necessary files and start the session
include '../config/database.php';
require '../model/db.php';
require '../model/brand.php';
require '../model/product.php';
require '../model/banner.php';
require '../model/cart.php';
require '../model/user.php';
session_start();

// Fetch product names from the Product model
$productModel = new Product();
$productNames = $productModel->getAllProducts();  // Ensure this line is called to fetch product names

// Fetch other required data
$brandModel = new Brand();
$userModel = new User();
$brands = $brandModel->getAllBrand();
$bannerModel = new Banner();
$banners = $bannerModel->getAllBannerAction();
$productModel = new Product();
$newestProducts = $productModel->getNewProducts(10);
$sellProducts = $productModel->getBestSellingProducts(10);
if (isset($_SESSION['user']['user_id'])) {
  $user_id = $_SESSION['user']['user_id'];
  $cartModel = new Cart();
  $totalCart = $cartModel->countItemsInCart($user_id);
} else {

  $totalCart = 0;
}


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
<style>
  /* Style the search button */
  #searchButton {
    background-color: transparent;
    border: none;
    cursor: pointer;
  }

  /* Style the combo box (dropdown) */
  .search-box {
    display: none;
    /* Hidden by default */
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 200px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 999;
  }

  .search-box ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .search-box ul li {
    padding: 10px;
    cursor: pointer;
  }

  .search-box ul li:hover {
    background-color: #f1f1f1;
  }

  .nav-item {
    position: relative;
  }
</style>

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
                          <a class="nav-link" href="brand.php?brand_id=<?php echo urlencode($encoded_brand_id); ?>&type=<?php echo htmlspecialchars($item['type']); ?>">
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
              <li class="nav-item">

                <!-- Search Button with Icon -->
                <button id="searchButton"><i class="ti-search"></i></button>

                <!-- Combo Box (Dropdown) -->
                <div id="searchBox" class="search-box">
                  <ul>
                    <?php foreach ($productNames as $productName): ?>
                      <li><?php echo htmlspecialchars($productName); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </li>
              <?php
              if (isset($_SESSION['user'])) {
                echo '
                    <li class="nav-item">
                        <a href="cart.php">
                            <button><i class="ti-shopping-cart"></i><span class="nav-shop__circle">' . $totalCart . '</span></button> 
                        </a>
                    </li>';
              }
              ?>


            </ul>
            <ul class="nav-user">

              <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item"><a href="./cart.php"><button><i class="ti-shopping-cart"></i><span class="nav-shop__circle"><?php echo $totalCart ?></span></button> </a></li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti-user"></i> <?php echo $_SESSION['user']['name']; ?>
                  </a>

                  <div class="logout">
                    <div class="dropdown-menu dropdowns" aria-labelledby="navbarDropdown">
                      <?php
                      if (isset($_SESSION['user']) && isset($_SESSION['user']['admin_id'])) {
                        echo '<a class="dropdown-item info" href="">Admin</a>';
                      }
                      ?>
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


  <script>
    // Get the search button and search box (combo box)
    const searchButton = document.getElementById('searchButton');
    const searchBox = document.getElementById('searchBox');

    // Toggle the combo box visibility when the search button is clicked
    searchButton.addEventListener('click', function() {
      searchBox.style.display = (searchBox.style.display === 'block') ? 'none' : 'block';
    });

    // Close the combo box if clicked outside
    document.addEventListener('click', function(event) {
      if (!searchButton.contains(event.target) && !searchBox.contains(event.target)) {
        searchBox.style.display = 'none';
      }
    });
  </script>


</body>

</html>