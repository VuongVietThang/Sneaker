<?php
// Kết nối đến cơ sở dữ liệu (đảm bảo bạn đã bao gồm file db.php hoặc tương tự)
include '../config/database.php';
require '../model/db.php';
require '../model/brand.php';
require '../model/product.php';


session_start();

$brandModel = new Brand();
$brands = $brandModel->getAllBrand();


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
  <link rel="icon" href="../img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="../css/themify-icons.css">
  <link rel="stylesheet" href="../css/nice-select.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/linericon.css">
  <link rel="stylesheet" href="../css/header.css">
</head>

<body>
  <!--================ Start Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.php"><img src="../img/logo.png" alt=""></a>
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
              $currentBrand = null;
              if (isset($brands) && is_array($brands) && !empty($brands)):
                foreach ($brands as $item):
                  if ($currentBrand !== $item['brand_id']):
                    $currentBrand = $item['brand_id'];
                    // Mã hóa brand_id với secret_salt
                    $encoded_brand_id = base64_encode($item['brand_id'] . $secret_salt);
              ?>
                    <li class="nav-item submenu dropdown">
                      <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false"><?php echo htmlspecialchars($item['name']); ?></a>
                      <ul class="dropdown-menu">
                      <?php endif; ?>
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
                <div id="search-container">
                  <form id="search-form" action="search_api.php" method="GET">
                    <input type="text" id="search-input" name="query" placeholder="Search products..." autocomplete="off">
                  </form>
                  <ul id="search-results" class="search-results-list" style="display: none;"></ul>
                </div>
              </li>
              <li class="nav-item"><a href="./cart.php"><button><i class="ti-shopping-cart"></i><span class="nav-shop__circle">3</span></button> </a></li>
              <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti-user"></i> <?php echo $_SESSION['user']['name']; ?>
                  </a>
                  <div class="dropdown-menu dropdowns" aria-labelledby="navbarDropdown">
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