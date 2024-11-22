<?php
include 'header.php';  
require_once '../model/db.php';
require_once '../model/order.php';
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
$orderModel = new Order();
$order_detail = $orderModel->orderDetail($order_id);
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <?php include 'sidebar.php'; ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <h1>Chi tiết đơn hàng #<?php echo $order_id; ?></h1>
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá sản phẩm</th>
                        <th>Kích thước</th>
                        <th>Màu sắc</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($order_detail) > 0) {
                        foreach ($order_detail as $key => $item) {
                            echo "<tr>
                                    <td>" . ($key + 1) . "</td>
                                    <td>{$item['product_name']}</td>
                                    <td>{$item['product_price']}</td>
                                    <td>{$item['size_name']}</td>
                                    <td>{$item['color_name']}</td>
                                    <td>{$item['quantity']}</td>
                                    <td>{$item['item_price']}</td>
                                    <td>{$item['created_at']}</td>
                                    <td>{$item['updated_at']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>Không có chi tiết đơn hàng</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="quanlydonhang.php" class="btn btn-primary">Quay lại quản lý đơn hàng</a>
        </div>
    </div>
</div>

<!-- plugins:js -->
<?php include 'footer.php'; ?>
