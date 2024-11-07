<?php
// Kết nối đến cơ sở dữ liệu (đảm bảo bạn đã bao gồm file db.php hoặc tương tự)
include '../config/database.php';
require '../model/db.php';
require '../model/user.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = $_POST['username'] ?? '';
	$password = $_POST['password'] ?? '';
	$isAdmin = isset($_POST['admin']) ? $_POST['admin'] : '';
	if($isAdmin){
		// Kiểm tra trường username
		if (empty($username)) {
			$errors['username'] = 'Tên đăng nhập không được để trống.';
		} else {
			// Kiểm tra xem username có tồn tại trong DB không
			$userModel = new User();
			if (!$userModel->isAdminExists($username)) {
				$errors['username'] = 'Tên đăng nhập không tồn tại hoặc không phải tài khoản admin!.';
			}
		}
		// Kiểm tra trường password
		if (empty($password)) {
			$errors['password'] = 'Mật khẩu không được để trống.';
			
		} else {
			// Kiểm tra mật khẩu có đúng không
			$user = $userModel->adminLogin($username, $password);
			if (is_string($user)) {
				$errors['password'] = $user; // Lỗi trả về từ hàm login
			}
		}
		if (empty($errors)) {
			$_SESSION['user'] = $user; // Lưu thông tin người dùng vào session
			header('Location: ../admin/index.php'); // Chuyển hướng đến trang dashboard
			exit();
		}
	}
	$errors = [];

	// Kiểm tra trường username
	if (empty($username)) {
		$errors['username'] = 'Tên đăng nhập không được để trống.';
	} else {
		// Kiểm tra xem username có tồn tại trong DB không
		$userModel = new User();
		if (!$userModel->isUsernameExists($username)) {
			$errors['username'] = 'Tên đăng nhập không tồn tại.';
		}
	}

	// Kiểm tra trường password
	if (empty($password)) {
		$errors['password'] = 'Mật khẩu không được để trống.';
	} else {
		// Kiểm tra mật khẩu có đúng không
		$user = $userModel->login($username, $password);
		if (is_string($user)) {
			$errors['password'] = $user; // Lỗi trả về từ hàm login
		}
	}

	// Nếu không có lỗi, đăng nhập thành công
	if (empty($errors)) {
		$_SESSION['user'] = $user; // Lưu thông tin người dùng vào session
		header('Location: index.php'); // Chuyển hướng đến trang dashboard
		exit();
	}
}

?>


<!doctype html>
<html lang="en">

<head>
	<title>Login 07</title>
	<meta charset="utf-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<link rel="stylesheet" href="../css/login.css">

</head>


<body>
	<section class="ftco-section">
		<div class="container">

			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div
							class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
								<h2>Welcome to login</h2>
								<p>Don't have an account?</p>
								<a href="register.php" class="btn btn-white btn-outline-white">Sign Up</a>
							</div>
						</div>
						<div class="login-wrap p-4 p-lg-5">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-4">Sign In</h3>
								</div>

							</div>
							<form action="login.php" method="POST" class="signin-form">
								<div class="form-group mb-3">
									<label class="label" for="username">Username</label>
									<input type="text" name="username" class="form-control" placeholder="Username" >
									<?php if (!empty($errors['username'])): ?>
										<span class="text-danger"><?php echo $errors['username']; ?></span>
									<?php endif; ?>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="password">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Password" >
									<?php if (!empty($errors['password'])): ?>
										<span class="text-danger"><?php echo $errors['password']; ?></span>
									<?php endif; ?>
								</div>
								<div class="radio-container">
									<input type="radio" name="admin" id="admin" class="styled-radio">
									<label for="admin" class="radio-label">Admin</label>
								</div>
								<div class="form-group">
									<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="../js/jquery.min.js"></script>
	<script src="../js/popper.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>

</body>

</html>