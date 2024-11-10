<?php include 'header.php';  ?>
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
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        </div>
      </div>
    </div>
  </div>
  <!-- plugins:js -->
  <?php include 'footer.php'; ?>