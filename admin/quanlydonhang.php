
<?php
include 'header.php'; 
require_once '../model/cart.php'; // Include the Cart model to access the orders

$CartModel = new Cart();
$orders = $CartModel->getAllOrders(); // Fetch all orders
?>
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
              <i class="fas fa-shopping-cart menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
              <span class="menu-title">Quản lý banner</span>
          </a>
      </li>
  </ul>

</nav>
<!-- partial -->
<div class="main-panel">
      <div class="content-wrapper">
        <h2>Quản lý đơn hàng</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Shipping Address</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($orders)): ?>
                <tr>
                  <td colspan="6">No orders yet.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($orders as $order): ?>
                  <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td><?php echo $order['shipping_address']; ?></td>
                    <td>
                      <a href="detailOrder.php?order_id=<?php echo $order['order_id'] ?>">
                        <i class="fa-regular fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
</div>
<?php
include 'footer.php'; 