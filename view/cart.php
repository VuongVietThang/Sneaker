<?php
include 'header.php';
if (isset($_SESSION['user']['user_id'])) {
$user_id = $_SESSION['user']['user_id']; // Lấy user_id từ session
$cartModel = new Cart();
$productsInCart = $cartModel->getAllProductsInCart($user_id);
$myOrder = $cartModel->getOrdersByUserId($user_id);
$totalCart = $cartModel->countItemsInCart($user_id);
// Lấy tổng số lượng sản phẩm trong giỏ
} else {
  include('404.php');
  exit();
}

?>

<section class="h-100 h-custom" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card">
          <div class="card-body p-4">

            <div class="row">

              <div class="col-lg-7">
                <h5 class="mb-3">
                  <a href="javascript:history.back()" class="text-body">
                    <i class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping
                  </a>
                    <form action="../controller/clearCart.php" method="POST" style="display: inline; margin-left: 330px;">
                      <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc muốn dọn sạch giỏ hàng?');">
                        <i class="fas fa-trash-alt me-2"></i>Clear Cart
                      </button>
                    </form>

                </h5>


                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <p class="mb-1">Shopping cart</p>
                    <p class="mb-0">You have <?php echo $totalCart; ?> items in your cart</p>
                  </div>
                </div>



                <?php
                $totalPrice = 0; // Khởi tạo biến tổng giá

                // Bắt đầu vòng lặp
                foreach ($productsInCart as $product):
                  // Cộng dồn giá tiền của từng sản phẩm vào tổng
                  $totalPrice += $product['price'] * $product['quantity'];
                ?>

                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                          <div>
                            <img src="../images/product/<?php echo $product['image_url']; ?>"
                              class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                          </div>
                          <div class="ms-3">
                            <h5><?php echo $product['product_name']; ?></h5>
                            <p class="small mb-0">Size: <?php echo $product['size_id']; ?>, Color: <?php echo $product['color_id']; ?></p>
                          </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                          <div style="width: 50px;">
                            <h5 class="fw-normal mb-0"><?php echo $product['quantity']; ?></h5>
                          </div>
                          <div style="width: 80px;">
                            <h5 class="mb-0">$<?php echo number_format($product['price'], 2); ?></h5>
                          </div>
                          <a href="../controller/removeFromCart.php?cart_item_id=<?php echo $product['cart_item_id']; ?>" style="color: #cecece;" title="Remove">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>

              </div>

              <div class="col-lg-5">
                <div class="card bg-primary text-white rounded-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <h5 class="mb-0">Card details</h5>
                    </div>

                    <p class="small mb-2">Card type</p>
                    <a href="#!" type="submit" class="text-white"><i
                        class="fab fa-cc-mastercard fa-2x me-2"></i></a>
                    <a href="#!" type="submit" class="text-white"><i
                        class="fab fa-cc-visa fa-2x me-2"></i></a>
                    <a href="#!" type="submit" class="text-white"><i
                        class="fab fa-cc-amex fa-2x me-2"></i></a>
                    <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-paypal fa-2x"></i></a>

                    <form method="POST" action="../controller/orderController.php" class="mt-4">
                      <div data-mdb-input-init class="form-outline form-white mb-4">
                        <input type="text" id="typeName" class="form-control form-control-lg" siez="17"
                          placeholder="Enter your name" />
                        <label class="form-label" for="typeName">Name</label>
                      </div>

                      <div data-mdb-input-init class="form-outline form-white mb-4">
                        <input type="text" id="typeText" class="form-control form-control-lg" siez="17"
                          placeholder="enter your address" name="shippingAddress" minlength="10" maxlength="100" />
                        <label class="form-label" for="typeText">Address</label>
                      </div>


                      <hr class="my-4">

                      <?php if($totalCart >= 1) { ?>                 
                          <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-block btn-lg">
                          <div class="d-flex justify-content-between">
                            <span>$4818.00</span>
                            <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                          </div>
                        </button>
                    <?php }?>

                    </form>

                  </div>
                </div>

              </div>

            </div>

            <hr class="my-4">
            <h5>My Orders</h5>

            <?php if (empty($myOrder)): ?>
              <p>You have no orders yet.</p>
            <?php else: ?>
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
                    <?php foreach ($myOrder as $order): ?>
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
                  </tbody>
                </table>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>





<?php
include 'footer.php';
?>