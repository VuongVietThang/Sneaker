<?php
require_once '../model/banner.php';


if (isset($_POST['submit'])) {
   
   $order = $_POST['order'];
   $action = $_POST['action'];

    // Kiểm tra và xử lý file hình ảnh
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $target_dir = "../images/banner/";  // Thư mục lưu ảnh
        $target_file = $target_dir . basename($_FILES['image_url']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là ảnh không (có thể kiểm tra thêm kích thước, loại ảnh)
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Di chuyển file từ tạm thời đến thư mục uploads
            if (move_uploaded_file($_FILES['image_url']['tmp_name'], $target_file)) {
                echo "Ảnh đã được tải lên thành công.";

                // Lấy URL của ảnh đã tải lên
                $image_url = $_FILES['image_url']['name'];

                // Khởi tạo đối tượng BannerModel và gọi hàm addBanner
                $bannerModel = new Banner();  // Khởi tạo đối tượng

                // Gọi hàm để thêm banner vào cơ sở dữ liệu
                if ($bannerModel->addBanner($image_url, $order, $action)) {
                    header("Location: ../admin/quanlybanner.php");
                    exit();
                } else {
                    echo "Có lỗi khi thêm banner.";
                }
            } else {
                echo "Lỗi khi tải ảnh lên.";
            }
        } else {
            echo "Chỉ hỗ trợ file ảnh JPG, JPEG, PNG, GIF.";
        }
    } else {
        echo "Vui lòng chọn một ảnh để tải lên.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD BANNER</title>
    <link rel="shortcut icon" href="images/favicon.png" />
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
        input[type="number"],
        select {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
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
        <h2>ADD BANNER</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image_url">Chọn ảnh Banner:</label>
                <input type="file" id="image_url" name="image_url" class="form-control-file" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="order">Thứ tự</label>
                <input type="number" id="order" value="1" name="order" class="form-control" required min="1"  oninput="validateOrderInput(this)">
            </div>
            <div class="form-group" style="padding-bottom: 20px">
                <label for="action">Show/Hiden</label>
                <select id="action" name="action" class="form-control" required>
                    <option value="Show">Show</option>
                    <option value="Hiden">Hiden</option>
                </select>
            </div>
            <button class="btn btn-success mb-3" style="margin-bottom: 15px" type="submit" name="submit">ADD BANNER</button>
            <button class="btn btn-secondary" type="button" onclick="window.location.href='../admin/quanlybanner.php';">CLOSE</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Hàm kiểm tra và xử lý giá trị nhập vào
    function validateOrderInput(input) {
        let value = input.value;

        // Loại bỏ tất cả các ký tự không phải số
        value = value.replace(/[^0-9]/g, '');  // Chỉ cho phép số

        // Loại bỏ dấu chấm (.) nếu có
        value = value.replace(/[.]/g, '');  // Loại bỏ dấu chấm

        // Kiểm tra và loại bỏ số đầu là "0" (ví dụ: "0001", "00020")
        if (value.startsWith('0') && value.length > 1) {
            input.value = value.replace(/^0+/, '');  // Loại bỏ tất cả "0" đầu
        }

        // Nếu giá trị nhập vào nhỏ hơn 1, không cho nhập, giữ nguyên giá trị trước đó
        if (parseInt(value) < 1) {
            input.value = '';  // Đặt lại giá trị trống nếu nhỏ hơn 1
        } else {
            input.value = value;  // Cập nhật giá trị vào input
        }
    }
</script>
</body>

</html>