<?php
include 'header.php';
$colorModel = new Color();  // Sửa từ Brand thành Color
$colors = $colorModel->getAllColor();  // Sửa từ getAllBrand thành getAllColor
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">

<?php include 'sidebar.php' ?>

  
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container">

                <a href="../controller/add_color.php" class="btn btn-success mb-3">  <!-- Thay đổi link đến add_color.php -->
                    <i class="fas fa-plus"></i> ADD COLOR  <!-- Sửa từ ADD BRAND thành ADD COLOR -->
                </a>

                <!-- Tìm kiếm sản phẩm -->
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Tìm kiếm màu sắc..." id="search"> <!-- Thay đổi placeholder -->
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
                        <?php if (empty($colors)) : ?>  <!-- Thay đổi từ $brands sang $colors -->
                            <tr>
                                <td colspan="9" class="text-center">Chưa có màu sắc nào.</td> <!-- Thay đổi thông báo -->
                            </tr>
                        <?php else : ?>
                            <?php foreach ($colors as $color) : ?> <!-- Thay đổi từ $brands sang $colors -->
                                <?php $encoded_color = encryptProductId($color['color_id']) ?>  <!-- Sửa từ brand_id thành color_id -->
                                <tr class="text-center">
                                    <td><?php echo htmlspecialchars($color['color_id']); ?></td> <!-- Sửa từ brand_id thành color_id -->
                                    <td><?php echo htmlspecialchars($color['name']); ?></td>  <!-- Sửa từ name brand thành name color -->
                                                                        
                                    <td class="action-icons">
                                        <a href="../controller/edit_color.php?color_id=<?php echo urlencode($encoded_color); ?>" title="Chỉnh sửa màu sắc"> <!-- Sửa từ edit_brand.php thành edit_color.php -->
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../controller/delete_color.php?color_id=<?php echo urlencode($encoded_color); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa màu sắc này không?');" title="Xóa màu sắc"> <!-- Sửa từ delete_brand.php thành delete_color.php -->
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
