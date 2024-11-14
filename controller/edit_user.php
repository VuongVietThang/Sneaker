<?php

include '../config/database.php';
require '../model/db.php';
require '../model/user.php';

$secret_salt = "my_secret_salt";

function decryptBrandId($decryptedId, $secret_salt)
{
    $decoded = base64_decode($decryptedId);
    return str_replace($secret_salt, '', $decoded);
}

// Biến lưu lỗi cho từng trường
$errors = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'username' => '',
    'password' => ''
];
if (isset($_GET['user_id'])) {

    $userID = decryptBrandId($_GET['user_id'], $secret_salt);

    $userModel = new User();
    if (!$userModel->userExists($userID)) {
        header("Location: ../admin/404.php");
        exit();
    }
    $users = $userModel->getUserById($userID);
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
        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            $errors['username'] = 'Tên người dùng chỉ được bao gồm các chữ cái và số, không có dấu, khoảng trắng hoặc ký tự đặc biệt.';
        }
        // else {
        //     $userModel = new User();
        //     if ($userModel->isUsernameExists($username)) {
        //         $errors['username'] = 'Tên người dùng đã tồn tại.';
        //     }
        // }

        // Kiểm tra mật khẩu
        if (!empty($password)) {
            // Nếu có mật khẩu mới, kiểm tra điều kiện mạnh và mã hóa
            if (
                strlen($password) < 8
                || !preg_match('/[A-Z]/', $password) // ít nhất một chữ hoa
                || !preg_match('/[a-z]/', $password) // ít nhất một chữ thường
                || !preg_match('/\d/', $password)    // ít nhất một chữ số
                || !preg_match('/^\S*$/', $password) // không chứa khoảng trắng
            ) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 8 ký tự, một chữ hoa, một chữ thường, một số.';
            } else {
                // Mã hóa mật khẩu mới nếu đạt điều kiện
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
        } else {
            // Nếu trường mật khẩu trống, giữ lại mật khẩu cũ từ DB
            $password = $users['password']; // Cần lấy giá trị này từ cơ sở dữ liệu trước đó
        }


        // Nếu không có lỗi, tiến hành đăng ký
        if (!array_filter($errors)) { // Kiểm tra xem có lỗi nào không

            if ($userModel->editUser($userID, $name, $email, $phone, $address, $username, $password)) {
                header('Location: ../admin/quanlyuser.php');
                // Chuyển hướng hoặc thực hiện hành động khác
            } else {
                echo "<script> alert('Đã có lỗi xảy ra, vui lòng thử lại') </script>";
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT USER</title>
    <link rel="shortcut icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f5;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #007bff;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .form-group label {
            font-weight: 500;
            color: #343a40;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        select {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        input[type="file"] {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: bold;
            letter-spacing: 1px;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.2);
        }

        select option:checked {
            font-weight: bold;
            color: #007bff;
        }

        small {
            display: block;
            margin-top: 5px;
            color: #6c757d;
        }

        .custom-file-input:lang(en)~.custom-file-label::after {
            content: "Browse";
        }

        .custom-file-label {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>EDIT USER</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <?php if (isset($users)): ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($users['name']) ?>" maxlength="255" class="form-control-file" accept="name/*">
                    <?php if (!empty($errors['name'])): ?>
                        <span class="text-danger"><?php echo $errors['name']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($users['email']) ?>" maxlength="255" class="form-control-file" accept="email/*">
                    <?php if (!empty($errors['email'])): ?>
                        <span class="text-danger"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($users['phone']) ?>" maxlength="15" class="form-control-file" accept="phone/*" oninput="validateOrderInput(this)">
                    <?php if (!empty($errors['phone'])): ?>
                        <span class="text-danger"><?php echo $errors['phone']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($users['address']) ?>" class="form-control-file" accept="address/*">
                    <?php if (!empty($errors['address'])): ?>
                        <span class="text-danger"><?php echo $errors['address']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($users['username']) ?>" maxlength="255" class="form-control-file" accept="username/*">
                    <?php if (!empty($errors['username'])): ?>
                        <span class="text-danger"><?php echo $errors['username']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" maxlength="255" class="form-control-file" accept="password/*">
                    <?php if (!empty($errors['password'])): ?>
                        <span class="text-danger"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <button class="btn btn-primary mb-3" style="margin-bottom: 15px" type="submit" name="submit">EDIT USER</button>
            <button class="btn btn-secondary" type="button" onclick="window.location.href='../admin/quanlyuser.php';">CLOSE</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Hàm kiểm tra và xử lý giá trị nhập vào
        function validateOrderInput(input) {
            // Loại bỏ tất cả các ký tự không phải số
            input.value = input.value.replace(/[^0-9]/g, ''); // Chỉ cho phép số từ 0-9
        }
    </script>
</body>

</html>