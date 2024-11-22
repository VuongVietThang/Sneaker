<?php
$month = date('m');
$year = date('Y');
$statisticalModel = new Statistical();

// Lấy thống kê của tháng này
$total_sales = $statisticalModel->getTotaSales($month, $year);
$total_users = $statisticalModel->getTotalUser($month, $year);
$total_sold = $statisticalModel->getTotalProductsSold($month, $year);
$total_orders = $statisticalModel->getTotalOrders($month, $year);

// Lấy thống kê của tháng trước
$prev_month = $month - 1;
$prev_year = $year;
if ($month == 1) {
    $prev_month = 12; // Tháng trước là tháng 12
    $prev_year = $year - 1; // Năm trước
}

$total_sales_prev = $statisticalModel->getTotaSales($prev_month, $prev_year);
$total_user_prev = $statisticalModel->getTotalUser($prev_month, $prev_year);
$total_sold_prev = $statisticalModel->getTotalProductsSold($prev_month, $prev_year);
$total_orders_prev = $statisticalModel->getTotalOrders($prev_month, $prev_year);

// Tính phần trăm thay đổi
function calculatePercentageChange($current, $previous) {
    if ($previous == 0) {
        return $current > 0 ? 100 : 0; // Tránh chia cho 0
    }
    return (($current - $previous) / $previous) * 100;
}

$sales_change = calculatePercentageChange($total_sales, $total_sales_prev);
$users_change = calculatePercentageChange($total_users, $total_user_prev);
$sold_change = calculatePercentageChange($total_sold, $total_sold_prev);
$orders_change = calculatePercentageChange($total_orders, $total_orders_prev);

$current_month = date('m');
$current_year = date('Y');

// Dữ liệu cho 6 tháng gần nhất
$salesData = [];
$userData = [];
$productData = [];
$orderData = [];
$months = []; // Lưu danh sách các tháng

for ($i = 0; $i < 6; $i++) {
    $month = $current_month - $i;
    $year = $current_year;

    // Nếu tháng < 1, chuyển về tháng 12 của năm trước
    if ($month < 1) {
        $month += 12;
        $year -= 1;
    }

    // Thêm vào danh sách tháng (theo định dạng "Tháng/YEAR")
    $months[] = "Tháng " . $month;

    // Lấy dữ liệu thống kê
    $salesData[] = $statisticalModel->getTotaSales($month, $year);
    $userData[] = $statisticalModel->getTotalUser($month, $year);
    $productData[] = $statisticalModel->getTotalProductsSold($month, $year);
    $orderData[] = $statisticalModel->getTotalOrders($month, $year);
}

// Đảo ngược thứ tự dữ liệu để hiển thị từ tháng cũ -> mới
$months = array_reverse($months);
$salesData = array_reverse($salesData);
$userData = array_reverse($userData);
$productData = array_reverse($productData);
$orderData = array_reverse($orderData);

?>