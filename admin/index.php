<?php
include 'header.php';
include 'statistical_chart.php';

?>


<!-- partial -->
<div class="container-fluid page-body-wrapper">

<<<<<<< HEAD
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
      <li class="nav-item">
        <a class="nav-link" href="quanlybanner.php">
          <i class="fas fa-image menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
          <span class="menu-title">Quản lý banner</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="quanlyuser.php">
          <i class="fas fa-user menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
          <span class="menu-title">Quản lý user</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="quanlybrand.php">
          <i class="fas fa-list menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
          <span class="menu-title">Quản lý brand</span>
        </a>
      </li>
    </ul>
=======
    <?php include 'sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel">
>>>>>>> main

  </nav>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-tale">
            <div class="card-body">
              <h3 class="mb-4">Revenue</h3>
              <p class="fs-30 mb-2"><?php echo number_format($total_sales, 0, ',', '.' ) ?></p>
              <p><?php echo round($sales_change, 2) . "%" ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-dark-blue">
            <div class="card-body">
              <h3 class="mb-4">Products Sold</h3>
              <p class="fs-30 mb-2"><?php echo $total_sold ?></p>
              <p><?php echo round($sold_change, 2) . "%" ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-light-blue">
            <div class="card-body">
              <h3 class="mb-4">New Users</h3>
              <p class="fs-30 mb-2"><?php echo $total_users ?></p>
              <p><?php echo round($users_change, 2) . "%" ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
          <div class="card card-light-danger">
            <div class="card-body">
              <h3 class="mb-4">Orders</h3>
              <p class="fs-30 mb-2"><?php echo $total_orders ?></p>
              <p><?php echo round($orders_change, 2) . "%" ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Revenue</h4>
              <canvas id="salesChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">New Users</h4>
              <canvas id="userChart"></canvas>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Products Sold</h4>
              <canvas id="productsChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Orders</h4>
              <canvas id="ordersChart"></canvas>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

  <!-- plugins:js -->

  <?php include 'footer.php'; ?>
  <script src="../js/chart_admin.js"></script>