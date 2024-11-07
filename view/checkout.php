<?php
include 'header.php';
require_once __DIR__ . '/../model/color.php';
require_once __DIR__ . '/../model/size.php';

$colorModel = new Color();
$sizeModel = new Size();

$allSizes = $sizeModel->getAllSizes();
$allColors = $colorModel->getAllColors();

// Lấy dữ liệu giỏ hàng từ session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/cart.css">
    <style>
        .checkout-table {
            width: 100%;
            border-collapse: collapse;
        }

        .checkout-table th,
        .checkout-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .checkout-actions {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #28a745;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Checkout</h1>
        <?php if (!empty($cart)): ?>
            <table class="checkout-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $product_id => $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>
                                <?php
                                // Xử lý kích thước (size_id)
                                $selectedSize = isset($item['size_id']) ? $item['size_id'] : null;
                                $sizeName = '';
                                if ($selectedSize !== null) {
                                    foreach ($allSizes as $size) {
                                        if ($size['size_id'] == $selectedSize) {
                                            $sizeName = $size['value'];
                                            break;
                                        }
                                    }
                                }
                                echo htmlspecialchars($sizeName); // In ra tên kích thước
                                ?>
                            </td>
                            <td>
                                <?php
                                // Xử lý màu sắc (color_id)
                                $selectedColor = isset($item['color_id']) ? $item['color_id'] : null;
                                $colorName = '';
                                if ($selectedColor !== null) {
                                    foreach ($allColors as $color) {
                                        if ($color['color_id'] == $selectedColor) {
                                            $colorName = $color['name'];
                                            break;
                                        }
                                    }
                                }
                                echo htmlspecialchars($colorName); // In ra tên màu sắc
                                ?>
                            </td>
                            <td><?php echo number_format($item['price'], 2); ?> VND</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($subtotal, 2); ?> VND</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">Total:</td>
                        <td><?php echo number_format($total, 2); ?> VND</td>
                    </tr>
                </tfoot>
            </table>

            <div class="checkout-actions">
                <a href="cart.php" class="btn">Back to Cart</a>
                <a href="payment.php" class="btn btn-primary">Proceed to Payment</a>
            </div>
        <?php else: ?>
            <p>Your cart is empty. <a href="index.php">Continue shopping</a></p>
        <?php endif; ?>
    </div>

</body>

</html>

<?php include 'footer.php'; ?>