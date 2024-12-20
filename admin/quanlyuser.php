<?php
include 'header.php';
$userModel = new User();
$users = $userModel->getAllUser();

?>


<!-- partial -->
<div class="container-fluid page-body-wrapper">

<?php include 'sidebar.php' ?>

    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container">

                <a href="../controller/add_user.php" class="btn btn-success mb-3">
                    <i class="fas fa-plus"></i> ADD USER
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
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <?php if (empty($users)) : ?>
                            <tr>
                                <td colspan="9" class="text-center">Chưa có user nào.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($users as $user) : ?>
                                <?php $encoded_banner = encryptProductId($user['user_id']) ?>
                                <tr class="text-center">
                                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($user['phone']) ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['password']); ?></td>
                                    
                                    <td class="action-icons">
                                        <a href="../controller/edit_user.php?user_id=<?php echo urlencode($encoded_banner); ?>" title="Chỉnh sửa user">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../controller/delete_user.php?user_id=<?php echo urlencode($encoded_banner); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');" title="Xóa sản phẩm">
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