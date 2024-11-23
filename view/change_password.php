<?php
include 'header.php';
$error = null;
$success = null;

if (isset($_SESSION['user']['user_id'])) {
    $user_id = $_SESSION['user']['user_id']; // Lấy user_id từ session
    $userModel = new User();
    $profile = $userModel->getProfileUser($user_id);
} else {
    include('404.php');
    exit();
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem dữ liệu có được gửi đúng không
    error_log("Form submitted");

    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New Password and Confirm Password do not match.";
    } else {
        // Gọi hàm thay đổi mật khẩu
        if ($userModel->change_password($user_id, $currentPassword, $newPassword)) {
            $success = "Password updated successfully.";
        } else {
            $error = "Failed to update password. Please check your current password.";
        }
    }
}
?>

<div class="container mt-5">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                            <div class="mt-3">
                                <h4>John Doe</h4>
                                <p class="text-secondary mb-1">Customer</p>
                                <p class="text-muted font-size-sm"><?php echo htmlspecialchars($profile['address']); ?></p>
								<button class="btn btn-outline-primary" onclick="window.history.back();">Back</button>
                            </div>
                        </div>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
            <?php if (!empty($profile)): ?>
                <div class="col-lg-8">
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <div class="card mt-2" id="changePassForm">
                                <div class="card-body">
                                    <h5 class="card-title">Change Password</h5>
                                    <!-- Hiển thị thông báo -->
                                    <?php if ($error): ?>
                                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                                    <?php endif; ?>

                                    <?php if ($success): ?>
                                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                                    <?php endif; ?>

                                    <!-- Form đổi mật khẩu -->
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label for="currentPassword" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="newPassword" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
