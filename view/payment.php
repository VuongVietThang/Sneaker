<?php
include 'header.php';

$user_id = $_SESSION['user']['user_id']; 
$cartModel = new Cart();
$productsInCart = $cartModel->getAllProductsInCart($user_id);
$myOrder = $cartModel->getOrdersByUserId($user_id);

// Lấy tổng số lượng sản phẩm trong giỏ
$totalItems = count($productsInCart);

?>

<section class="h-100 h-custom" style="background-color: #eee;"> <div class="container py-5 h-100"> <div class="row d-flex justify-content-center align-items-center h-100"> <div class="col"> <div class="card"> <div class="card-body p-4"> <h3 class="mb-4">Payment Form</h3> <form> <div class="form-group"> <label for="paymentId" class="form-label">Payment ID</label> <input type="text" class="form-control" id="paymentId" placeholder="Enter Payment ID"> </div> <div class="form-group"> <label for="orderId" class="form-label">Order ID</label> <input type="text" class="form-control" id="orderId" placeholder="Enter Order ID"> </div> <div class="form-group"> <label for="paymentMethod" class="form-label">Payment Method</label> <select class="form-control" id="paymentMethod"> <option value="Credit Card">Credit Card</option> <option value="Bank Transfer">Bank Transfer</option> <option value="Paypal">Paypal</option> </select> </div> <div class="form-group"> <label for="paymentDate" class="form-label">Payment Date</label> <input type="date" class="form-control" id="paymentDate"> </div> <div class="form-group"> <label for="paymentStatus" class="form-label">Payment Status</label> <select class="form-control" id="paymentStatus"> <option value="Pending">Pending</option> <option value="Completed">Completed</option> <option value="Failed">Failed</option> </select> </div> <div class="form-group"> <label for="transaction" class="form-label">Transaction</label> <input type="text" class="form-control" id="transaction" placeholder="Enter Transaction Details"> </div> <div class="form-group"> <label for="createdAt" class="form-label">Created At</label> <input type="datetime-local" class="form-control" id="createdAt"> </div> <div class="form-group"> <label for="updatedAt" class="form-label">Updated At</label> <input type="datetime-local" class="form-control" id="updatedAt"> </div> <button type="submit" class="btn btn-primary">Submit Payment</button> </form> </div> </div> </div> </div> </div> </section>





<?php
include 'footer.php';
?>