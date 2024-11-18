<?php
require_once '../model/product_db.php';
require_once '../model/encryption_helpers.php';

$product_db = new Product_db();

// Logic phân trang
$total_products = $product_db->getTotalProductCount(); // Lấy tổng số sản phẩm
$items_per_page = 2; // Số sản phẩm trên mỗi trang
$total_pages = ceil($total_products / $items_per_page); // Tính tổng số trang

// Lấy số trang hiện tại từ tham số query, mặc định là trang 1 nếu không có
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1; // Đảm bảo số trang không nhỏ hơn 1

// Lấy sản phẩm cho trang hiện tại
$products = $product_db->getAllProductWithDetails($page, $items_per_page);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Quản lý sản phẩm</title>
  <!-- Thêm Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style_admin.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>
<style>
  /* Cải thiện giao diện bảng sản phẩm */
  .table {
    width: 100%;
    border-collapse: collapse;
  }


  .table th,
  .table td {
    padding: 12px 15px;
  }
.table th, .table td {
    /* padding: 12px 15px; */

    text-align: center;
    border: 1px solid #dee2e6;
    vertical-align: middle;
  }

  .table th {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
  }

  .table img {
    max-width: 80px;
    border-radius: 5px;
  }

  /* Phân trang */
  .pagination {
    display: flex;
    gap: 10px;
    margin-top: 20px;
  }

  .pagination a {
    padding: 8px 12px;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
  }

  .pagination a:hover {
    background-color: #0056b3;
  }

  .pagination .active {
    background-color: #0056b3;
  }

  .pagination .disabled {
    background-color: #ddd;
    cursor: not-allowed;
  }

  /* Cải thiện form tìm kiếm */
  #search {
    width: 100%;
    padding: 8px 12px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 5px;
  }

  #search:focus {
    outline: none;
    border-color: #007bff;
  }

  /* Nút thêm sản phẩm */
  .btn-primary {
    background-color: #007bff;
    border: none;
    padding: 10px 15px;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .btn-primary i {
    margin-right: 5px;
  }

  /* Thêm khoảng cách cho container */
  .container {
    margin-top: 30px;
    background: #fff;
    padding: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }

  /* Cải thiện phần thao tác trong bảng */
  .action-icons a {
    margin-right: 10px;
  }

  .action-icons a i {
    font-size: 18px;
    color: #007bff;
    transition: color 0.3s;
  }

  .action-icons a i:hover {
    color: #0056b3;
  }

  /* Cải thiện phần hiển thị thông báo không có sản phẩm */
  .table td[colspan="9"] {
    text-align: center;
    font-style: italic;
    color: #888;
  }

  /* Đảm bảo mô tả tự động xuống dòng */
  .table td.description {
    white-space: normal;
    /* Cho phép xuống dòng */
    word-break: break-word;
    /* Đảm bảo xuống dòng cho từ dài */
    max-width: 250px;
    /* Giới hạn chiều rộng tối đa */
    overflow-wrap: anywhere;
    /* Xuống dòng khi cần */
    text-align: left;
    /* Canh trái để mô tả dễ đọc hơn */
    font-size: 14px;
    /* Giảm kích thước chữ cho phù hợp */
    padding: 10px 15px;
    /* Tăng khoảng cách padding cho dễ đọc */
    line-height: 1.5;
    /* Tăng khoảng cách giữa các dòng cho dễ nhìn */
    border-radius: 4px;
    /* Bo góc nhẹ để tạo cảm giác mượt mà */
  }
</style>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href=""><img src="../images/logo.svg" class="mr-2" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href=""><img src="../images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <i class="fas fa-bars"></i> <!-- Sử dụng biểu tượng menu từ Font Awesome -->
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <i class="fas fa-bars"></i> <!-- Sử dụng biểu tượng menu từ Font Awesome -->
        </button>
      </div>
    </nav>
    <!-- partial -->
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
          

          </li>  
           <li class="nav-item">
                <a class="nav-link" href="quanlybanner.php">
                    <i class="fas fa-image menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
                    <span class="menu-title">Quản lý banner</span>
                </a>
            </li>   
            <li class="nav-item">
                <a class="nav-link" href="quanlyuser.php">
                    <i class="fas fa-user menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
                    <span class="menu-title">Quản lý user</span>
                </a>
            </li>      
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            
            <a href="../controller/add_product.php" class="btn btn-primary mb-3">
              <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>

            <!-- Tìm kiếm sản phẩm -->
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="search">
            </div>

            <table class="table table-bordered table-hover">
              <thead class="text-center">
                <tr>
                  <th>Mã SP</th>
                  <th>Tên SP</th>
                  <th>Mô tả</th>
                  <th>Giá SP</th>
                  <th>Kiểu Giày</th>
                  <th>Hãng</th>
                  <th>Màu</th>
                  <th>Kích thước</th>
                  <th>Hình ảnh</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody id="product-list">
                <?php if (empty($products)) : ?>
                  <tr>
                    <td colspan="9" class="text-center">Chưa có sản phẩm nào.</td>
                  </tr>
                <?php else : ?>
                  <!-- Hiển thị thông tin sản phẩm -->
                  <?php foreach ($products as $product) : ?>
                    <tr class="text-center">
                      <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                      <td><?php echo htmlspecialchars($product['name']); ?></td>
                      <td class="description"><?php echo htmlspecialchars($product['description']); ?></td>
                      <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
                      <td><?php echo htmlspecialchars($product['type']); ?></td>
                      <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                      <td><?php echo htmlspecialchars($product['color_names']); ?></td> <!-- Hiển thị tên màu -->
                      <td><?php echo htmlspecialchars($product['sizes']); ?></td> <!-- Hiển thị kích thước -->
                      <td>
                        <?php
                        // Lấy hình ảnh chính từ cơ sở dữ liệu
                        $main_image = $product_db->getMainImage($product['product_id']);
                        if ($main_image) {
                          $image_url = '../images/product/' . htmlspecialchars($main_image['image_url']);  // Tạo đường dẫn ảnh
                          echo '<img src="' . $image_url . '" alt="Hình ảnh sản phẩm chính" style="max-width: 100px;">';
                        } else {
                          echo 'Chưa có hình ảnh chính';
                        }

                        ?>
                    <td class="action-icons">
    <?php
    // Mã hóa product_id
    $encoded_product_id = encryptProductId($product['product_id']);
    ?>
    <a href="../controller/edit_product.php?product_id=<?php echo urlencode($encoded_product_id); ?>" title="Chỉnh sửa sản phẩm">
        <i class="fas fa-edit"></i>
    </a>
    <a href="../controller/delete_product.php?product_id=<?php echo urlencode($encoded_product_id); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');" title="Xóa sản phẩm">
        <i class="fas fa-trash-alt"></i>
    </a>
</td>

                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
            <!-- Phân trang -->
            <div class="pagination">
              <!-- Previous Button -->
              <a href="?page=<?php echo max(1, $page - 1); ?>" class="btn btn-secondary <?php echo $page == 1 ? 'disabled' : ''; ?>">Previous</a>

              <!-- Page Number Links -->
              <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="?page=<?php echo $i; ?>" class="btn btn-secondary <?php echo $i == $page ? 'active' : ''; ?>">
                  <?php echo $i; ?>
                </a>
              <?php endfor; ?>

              <!-- Next Button -->
              <a href="?page=<?php echo min($total_pages, $page + 1); ?>" class="btn btn-secondary <?php echo $page == $total_pages ? 'disabled' : ''; ?>">Next</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- plugins:js -->
  <script src="../js/vendor.bundle.base.js"></script>
  <!-- inject:js -->
  <script src="../js/sidebar-menu.js"></script>

</body>

</html>