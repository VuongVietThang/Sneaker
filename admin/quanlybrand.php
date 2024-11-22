<?php
include 'header.php';
$brandModel = new Brand();
$brands = $brandModel->getAllBrand();

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
            <li class="nav-item">
                <a class="nav-link" href="quanlybrand.php">
                    <i class="fas fa-list menu-icon"></i> <!-- Biểu tượng giỏ hàng cho đơn hàng -->
                    <span class="menu-title">Quản lý brand</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container">

                <a href="../controller/add_brand.php" class="btn btn-success mb-3">
                    <i class="fas fa-plus"></i> ADD BRAND
                </a>

                <!-- Tìm kiếm sản phẩm -->
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="search">
                </div>

                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <?php if (empty($brands)) : ?>
                            <tr>
                                <td colspan="9" class="text-center">Chưa có brand nào.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($brands as $brand) : ?>
                                <?php $encoded_banner = encryptProductId($brand['brand_id']) ?>
                                <tr class="text-center">
                                    <td><?php echo htmlspecialchars($brand['brand_id']); ?></td>
                                    <td><?php echo htmlspecialchars($brand['name']); ?></td>
                                                                        
                                    <td class="action-icons">
                                        <a href="../controller/edit_brand.php?brand_id=<?php echo urlencode($encoded_banner); ?>" title="Chỉnh sửa user">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../controller/delete_brand.php?brand_id=<?php echo urlencode($encoded_banner); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');" title="Xóa sản phẩm">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
                <!-- Phân trang -->


            </div>
        </div>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>