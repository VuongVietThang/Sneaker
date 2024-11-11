
<?php
require_once '../model/cart.php'; // Include the Cart model to access the orders

$CartModel = new Cart();
$orders = $CartModel->getAllOrders(); // Fetch all orders
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Quản lý đơn hàng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/style_admin.css">
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- Navbar and Sidebar code (unchanged) -->

    <!-- Content -->
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

</body>

</html>

