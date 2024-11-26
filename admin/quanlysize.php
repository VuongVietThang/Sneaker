<?php
include 'header.php';
$sizeModel = new Size();  
$sizes = $sizeModel->getAllSize();  // Lấy tất cả kích thước từ bảng size
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">

<?php include 'sidebar.php' ?>

  
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container">

                <a href="../controller/add_size.php" class="btn btn-success mb-3">
                    <i class="fas fa-plus"></i> ADD SIZE
                </a>

                <!-- Tìm kiếm sản phẩm -->
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Tìm kiếm kích thước..." id="search">
                </div>

                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Size</th> <!-- Thay tên cột thành "Size" -->
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="size-list">
                        <?php if (empty($sizes)) : ?>
                            <tr>
                                <td colspan="3" class="text-center">Chưa có kích thước nào.</td> <!-- Cập nhật thông báo khi không có kích thước -->
                            </tr>
                        <?php else : ?>
                            <?php foreach ($sizes as $size) : ?>
                                <?php $encoded_size = encryptProductId($size['size_id']) ?> <!-- Mã hóa ID size -->
                                <tr class="text-center">
                                    <td><?php echo htmlspecialchars($size['size_id']); ?></td> <!-- Hiển thị size_id -->
                                    <td><?php echo htmlspecialchars($size['value']); ?></td> <!-- Hiển thị giá trị size -->
                                                                        
                                    <td class="action-icons">
                                        <a href="../controller/edit_size.php?size_id=<?php echo urlencode($encoded_size); ?>" title="Chỉnh sửa kích thước">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../controller/delete_size.php?size_id=<?php echo urlencode($encoded_size); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa kích thước này không?');" title="Xóa kích thước">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Phân trang -->

            </div>
        </div>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>
