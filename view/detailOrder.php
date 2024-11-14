<?php
include 'header.php';
$cartModel = new Cart();
$orderId = $_GET['order_id'];
$detailOrders = $cartModel->getDetailOrder($orderId);

// Kiểm tra nếu có dữ liệu
if (empty($detailOrders)) {
    echo "Không có sản phẩm trong đơn hàng.";
} else {
?>
    <h3>Chi tiết đơn hàng #<?php echo $orderId; ?></h3>
    <table class="container table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Size</th>
                <th>Màu sắc</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng tiền</th>
                <th>Hình ảnh</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalAmount = 0;
            foreach ($detailOrders as $index => $order) {
                $totalPrice = $order['price'] * $order['quantity'];
                $totalAmount += $totalPrice;
            ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $order['product_name']; ?></td>
                    <td><?php echo $order['size_id']; ?></td>
                    <td><?php echo $order['color_id']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo number_format($order['price'], 0); ?> VND</td>
                    <td><?php echo number_format($totalPrice); ?> VND</td>
                    <td>
                    <img src="../images/product/<?php echo $order['image_url']; ?>" alt="<?php echo $order['product_name']; ?>" width="50">

                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <h4>Tổng đơn hàng: <?php echo number_format($totalAmount, 2); ?> VND</h4>
<?php
}
?>

<?php
include 'footer.php';
?>
