<?php
include '../config/database.php';
include '../model/db.php'; // Đảm bảo bạn đã bao gồm file kết nối DB
include '../model/user.php'; // Bao gồm file User

// Biến lưu lỗi cho từng trường
$errors = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'username' => '',
    'password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra tên
    if (empty($name)) {
        $errors['name'] = 'Tên không được để trống.';
    }

    // Kiểm tra email
    if (empty($email)) {
        $errors['email'] = 'Email không được để trống.';
    } else {
        // Kiểm tra định dạng email
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
            $errors['email'] = 'Email phải có định dạng đúng (ví dụ: user@gmail.com).';
        }
    }

    // Kiểm tra điện thoại
    if (empty($phone)) {
        $errors['phone'] = 'Số điện thoại không được để trống.';
    } elseif (!preg_match('/^\d{10}$/', $phone)) { // Kiểm tra định dạng số điện thoại (10 chữ số)
        $errors['phone'] = 'Số điện thoại phải có 10 chữ số.';
    }

    // Kiểm tra địa chỉ
    if (empty($address)) {
        $errors['address'] = 'Địa chỉ không được để trống.';
    }

    // Kiểm tra tên người dùng
    if (empty($username)) {
        $errors['username'] = 'Tên người dùng không được để trống.';
    } else {
        $userModel = new User();
        if ($userModel->isUsernameExists($username)) {
            $errors['username'] = 'Tên người dùng đã tồn tại.';
        }
    }

    // Kiểm tra mật khẩu
    if (empty($password)) {
        $errors['password'] = 'Mật khẩu không được để trống.';
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
        $errors['password'] = 'Mật khẩu phải có ít nhất 8 ký tự, một chữ hoa, một chữ thường và một số.';
    }


    // Nếu không có lỗi, tiến hành đăng ký
    if (!array_filter($errors)) { // Kiểm tra xem có lỗi nào không

        if ($userModel->register($name, $email, $phone, $address, $username, $password)) {
            header('Location: login.php');
            // Chuyển hướng hoặc thực hiện hành động khác
        } else {
            echo "<script> alert('Đã có lỗi xảy ra, vui lòng thử lại') </script>";
        }
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <title>Login 07</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <style>
        body {
            background-image: url(image/login.jpg);
            background-size: cover;
        }
    </style>
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                            <div class="text w-100">
                                <h2>Welcome to Sign Up</h2>
                                <p>You already have an account?</p>
                                <a href="login.php" class="btn btn-white btn-outline-white">Sign In</a>
                            </div>
                        </div>
                        <div class="login-wrap p-4 p-lg-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign Up</h3>
                                </div>
                            </div>
                            <?php if (isset($message)): ?>
                                <div class="alert alert-info"><?php echo $message; ?></div>
                            <?php endif; ?>
                            <form id="registerForm" method="POST" action="register.php">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name">
                                    <?php if ($errors['name']): ?>
                                        <small class="text-danger"><?php echo $errors['name']; ?></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                    <?php if ($errors['email']): ?>
                                        <small class="text-danger"><?php echo $errors['email']; ?></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Phone">
                                    <?php if ($errors['phone']): ?>
                                        <small class="text-danger"><?php echo $errors['phone']; ?></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="address">Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Address">
                                    <?php if ($errors['address']): ?>
                                        <small class="text-danger"><?php echo $errors['address']; ?></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="username">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                    <?php if ($errors['username']): ?>
                                        <small class="text-danger"><?php echo $errors['username']; ?></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <?php if ($errors['password']): ?>
                                        <small class="text-danger"><?php echo $errors['password']; ?></small>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary submit px-3">Sign Up</button>
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