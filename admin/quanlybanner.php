<?php 
include 'header.php'; 
$bannerModel = new Banner();
$banners = $bannerModel->getAllBanner();


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
               
                <a href="../controller/add_banner.php" class="btn btn-success mb-3">
                    <i class="fas fa-plus"></i> ADD BANNER
                </a>

                <!-- Tìm kiếm sản phẩm -->
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="search">
                </div>
                
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Thứ tự</th>
                            <th>Show/Hiden</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                    <?php if (empty($banners)) : ?>
                        <tr>
                            <td colspan="9" class="text-center">Chưa có sản phẩm nào.</td>
                        </tr>
                        <?php else : ?>
                        <?php foreach ($banners as $banner) : ?>
                        <?php $encoded_banner = encryptProductId($banner['banner_id']) ?>
                        <tr class="text-center">
                            <td><?php echo htmlspecialchars($banner['banner_id']); ?></td>
                            <td>
                                <img src="../images/banner/<?php echo htmlspecialchars($banner['image_url'])?>" style="max-width: 100px;">
                            </td>
                            <td><?php echo htmlspecialchars($banner['order']); ?></td>
                            <td><?php echo htmlspecialchars($banner['action']); ?></td>
                            <td class="action-icons">
                                        <a href="../controller/edit_banner.php?banner_id=<?php echo urlencode($encoded_banner); ?>" title="Chỉnh sửa sản phẩm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../controller/delete_banner.php?banner_id=<?php echo urlencode($encoded_banner); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa banner này không?');" title="Xóa sản phẩm">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                        </tr>   
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
                <!-- Phân trang -->


            </div>
        </div>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>