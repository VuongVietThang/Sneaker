<?php

include '../config/database.php';
require '../model/db.php';
require '../model/brand.php';
require '../model/encryption_helpers.php';


// Biến lưu lỗi cho từng trường
$errors = [
    'name' => '',
    
];
if (isset($_GET['brand_id'])) {

    $brandID = decryptProductId($_GET['brand_id']);

    $brandModel = new Brand();
    if (!$brandModel->brandExists($brandID)) {
        header("Location: ../admin/404.php");
        exit();
    }
    $brands = $brandModel->getBrandById($brandID);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form
        $name = trim($_POST['name']);    

        // Kiểm tra tên
        if (empty($name)) {
            $errors['name'] = 'Tên không được để trống.';
        }
        
        if ($brandModel->isBrandnameExists($name)) {
            $errors['name'] = 'Brand đã tồn tại.';
        }

        // Nếu không có lỗi, tiến hành đăng ký
        if (!array_filter($errors)) { // Kiểm tra xem có lỗi nào không

            if ($brandModel->editBrand($brandID, $name)) {
                header('Location: ../admin/quanlybrand.php');
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
    <title>EDIT BRAND</title>
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
        <h2>EDIT BRAND</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <?php if (isset($brands)): ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($brands['name']) ?>" maxlength="255" class="form-control-file" accept="name/*">
                    <?php if (!empty($errors['name'])): ?>
                        <span class="text-danger"><?php echo $errors['name']; ?></span>
                    <?php endif; ?>
                </div>
                
            <?php endif; ?>
            <button class="btn btn-primary mb-3" style="margin-bottom: 15px" type="submit" name="submit">EDIT BRAND</button>
            <button class="btn btn-secondary" type="button" onclick="window.location.href='../admin/quanlybrand.php';">CLOSE</button>
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