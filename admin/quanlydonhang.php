<?php include 'header.php';  
$orderModel = new Order();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_orders = $orderModel->getTotalOrderCount();
$items_per_page = 10;

// Tính số trang tổng cộng
$total_pages = ceil($total_orders / $items_per_page);
$getAllOrders = $orderModel->getAllOrders($page);
?>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
    <?php include 'sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <h1>Quản lý đơn hàng</h1>
          <table class="table table-striped table-bordered table-hover">
              <thead class="thead-dark">
                  <tr>
                      <th>#</th>
                      <th>Mã đơn hàng</th>
                      <th>Ngày đặt hàng</th>
                      <th>Tổng tiền</th>
                      <th>Trạng thái</th>
                      <th>Địa chỉ giao hàng</th>
                      <th>Ngày cập nhật</th>
                      <th>Hành động</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  if (count($getAllOrders) > 0) {
                  foreach ($getAllOrders as $key => $row) {
                      echo "<tr>
                              <td>" . ($key + 1 + ($page - 1) * $items_per_page) . "</td>
                              <td>{$row['order_id']}</td>
                              <td>{$row['order_date']}</td>
                              <td>{$row['total_amount']}</td>
                              <td>{$row['status']}</td>
                              <td>{$row['shipping_address']}</td>
                              <td>{$row['updated_at']}</td>
                              <td class='action-buttons'>";
                      if ($row['status'] == 'pending') {
                          echo "<a href='../controller/set_complete_order.php?order_id={$row['order_id']}' class='btn btn-success btn-sm'>Duyệt</a>";
                      }
                      echo "
                              <a href='./chitietdonhang.php?order_id={$row['order_id']}' class='btn btn-info btn-sm'>Chi tiết</a>
                              <a href='../controller/delete_order.php?order_id={$row['order_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa đơn hàng này?\")'>Xóa</a>
                          </td>
                        </tr>";
                  }

                  } else {
                      echo "<tr><td colspan='10' class='text-center'>Không có đơn hàng nào</td></tr>";
                  }
                  ?>
              </tbody>
          </table>
          
          <!-- Phân trang -->
          <nav id="Page" aria-label="Page navigation"> 
            <ul class="pagination"> <?php if ($page > 1): ?> <li class="page-item"> 
              <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a> 
            </li> <?php endif; ?> <?php for ($i = 1; $i <= $total_pages; $i++): ?> 
              <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>"> 
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a> 
              </li> <?php endfor; ?> <?php if ($page < $total_pages): ?> 
                <li class="page-item"> <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a> 
              </li> <?php endif; ?> 
              </ul> </nav>
        </div>
      </div>
    </div>
  </div>
  <style>
    #Page{
      margin: 10px 0px;
    }
  </style>
  <!-- plugins:js -->
  <?php include 'footer.php'; ?>
