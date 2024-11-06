<?php 
session_start();
if (!isset($_SESSION['user']) || !$_SESSION['user']['admin_id']) {
    include('403.php'); 
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shop Bán Giày Trực Tuyến</title>
  <!-- Thêm Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style_admin.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href=""><img src="../images/logo.svg" class="mr-2"
            alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href=""><img src="../images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <i class="fas fa-bars"></i> <!-- Sử dụng biểu tượng menu từ Font Awesome -->
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item">
          <?php 
            if (isset($_SESSION['user'])) { 
                echo '<a class="nav-link" href="../view/logout.php"> 
                          <button class="btn btn-danger">Logout</button>
                      </a>'; 
            } 
            ?>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <i class="fas fa-bars"></i> <!-- Sử dụng biểu tượng menu từ Font Awesome -->
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fas fa-th-large menu-icon"></i> <!-- Biểu tượng Dashboard -->
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="quanlysanpham.php">
              <i class="fas fa-box menu-icon"></i> <!-- Biểu tượng Quản lý sản phẩm -->
              <span class="menu-title">Quản lý sản phẩm</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="quanlydonhang.php">
              <i class="fas fa-shopping-cart menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
              <span class="menu-title">Quản lý đơn hàng</span>
            </a>
          </li>
        </ul>

      </nav>
      <!-- partial -->
      <div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Doanh thu</h4>
                  <canvas id="revenueChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Người dùng mới</h4>
                  <canvas id="newUsersChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- plugins:js -->
  <script src="../js/vendor.bundle.base.js"></script>
  <!-- inject:js -->
  <script src="../js/sidebar-menu.js"></script>
  <!-- Thêm Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script src="../js/chart_admin.js"></script>

</body>

</html>