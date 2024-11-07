<?php
include 'header.php';
require_once __DIR__ . '/../model/color.php';
require_once __DIR__ . '/../model/size.php';

$colorModel = new Color();
$sizeModel = new Size();

$allSizes = $sizeModel->getAllSizes();
$allColors = $colorModel->getAllColors();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="../css/cart.css">
    <style>
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .quantity-input {
            width: 50px;
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

        select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your Shopping Cart</h1>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>
                                <select class="size-select" data-product-id="<?php echo $product_id; ?>">
                                    <?php foreach ($allSizes as $size): ?>
                                        <option value="<?php echo $size['size_id']; ?>"
                                            <?php echo (isset($item['size_id']) && $item['size_id'] == $size['size_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($size['value']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select class="color-select" data-product-id="<?php echo $product_id; ?>">
                                    <?php foreach ($allColors as $color): ?>
                                        <option value="<?php echo $color['color_id']; ?>"
                                            <?php echo (isset($item['color_id']) && $item['color_id'] == $color['color_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($color['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><?php echo number_format($item['price'], 2); ?> VND</td>
                            <td>
                                <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>"
                                    min="1" data-product-id="<?php echo $product_id; ?>">
                            </td>
                            <td><?php echo number_format($subtotal, 2); ?> VND</td>
                            <td>
                                <button class="remove-item" data-product-id="<?php echo $product_id; ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">Total:</td>
                        <td colspan="2"><?php echo number_format($total, 2); ?> VND</td>
                    </tr>
                </tfoot>
            </table>
            <div class="cart-actions">
                <a href="index.php" class="btn">Continue Shopping</a>
                <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p>Your cart is empty. <a href="index.php">Continue shopping</a></p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.quantity-input, .size-select, .color-select').change(function() {
                var productId = $(this).data('product-id');
                var quantity = $('.quantity-input[data-product-id="' + productId + '"]').val();
                var sizeId = $('.size-select[data-product-id="' + productId + '"]').val();
                var colorId = $('.color-select[data-product-id="' + productId + '"]').val();
                updateCart(productId, sizeId, colorId, quantity);
            });

            $('.remove-item').click(function() {
                var productId = $(this).data('product-id');
                updateCart(productId, null, null, 0);
            });

            function updateCart(productId, sizeId, colorId, quantity) {
                $.ajax({
                    url: 'update_cart.php',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        size_id: sizeId,
                        color_id: colorId,
                        quantity: quantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update cart. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });
    </script>
</body>

</html>

<?php include 'footer.php'; ?>