<?php
include 'header.php'; 
require_once '../model/product_db.php';

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
          <li class="nav-item">
                <a class="nav-link" href="quanlybanner.php">
                    <i class="fas fa-shopping-cart menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
                    <span class="menu-title">Quản lý banner</span>
                </a>
            </li>         
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">     
        <div class="content-wrapper">
          <div class="container">
            <h2 class="text-center mb-4">Quản lý sản phẩm</h2>
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
                                            echo '<img src="' . htmlspecialchars($main_image['image_url']) . '" alt="Hình ảnh sản phẩm chính" style="max-width: 100px;">';
                                        } else {
                                            echo 'Chưa có hình ảnh chính';
                                        }
                                        ?>
                                    </td>
                                    <td class="action-icons">
                                        <a href="../controller/edit_product.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" title="Chỉnh sửa sản phẩm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../controller/delete_product.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');" title="Xóa sản phẩm">
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
  <<?php include 'footer.php'; ?>
