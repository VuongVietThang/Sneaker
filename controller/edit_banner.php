<?php
require_once '../model/banner.php';
require '../model/encryption_helpers.php';


if (isset($_GET['banner_id'])) {
    $bannerIdDecrypted = decryptProductId($_GET['banner_id']);

    if (is_numeric($bannerIdDecrypted)) {
        $bannerModel = new Banner();

        // Kiểm tra xem banner có tồn tại hay không
        if (!$bannerModel->bannerExists($bannerIdDecrypted)) {
            header("Location: ../admin/404.php");
            exit();
        }

        $banners = $bannerModel->getBannerById($bannerIdDecrypted);

        // Xử lý cập nhật nếu nhận được yêu cầu POST
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $order = $_POST['order'];
            $action = $_POST['action'];
            $image_url = $banners['image_url']; // Mặc định là ảnh hiện tại

            // Kiểm tra và xử lý ảnh mới nếu có tải lên
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
                $targetDir = "../images/banner/";
                $imageFileType = strtolower(pathinfo($_FILES["image_url"]["name"], PATHINFO_EXTENSION));
                $newFileName = uniqid() . '.' . $imageFileType;
                $targetFile = $targetDir . $newFileName;

                if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $targetFile)) {
                        $image_url = $newFileName;
                    } else {
                        echo "Lỗi: Không thể tải ảnh lên.";
                    }
                } else {
                    echo "Lỗi: Chỉ chấp nhận các định dạng JPG, JPEG, PNG, GIF.";
                }
            }

            // Cập nhật thông tin banner
            $updateSuccess = $bannerModel->editBanner($bannerIdDecrypted, $image_url, $order, $action);

            if ($updateSuccess) {
                header("Location: ../admin/quanlybanner.php");
                exit();
            } else {
                echo "Lỗi: Không thể cập nhật banner.";
            }
        }
    } else {
        header("Location: ../admin/404.php");
        exit();
    }
} else {
    header("Location: ../admin/404.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT BANNER</title>
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
        <h2>EDIT BANNER</h2>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="image_url">Chọn ảnh Banner:</label>
                <input type="file" id="image_url" name="image_url" class="form-control-file" accept="image/*" onchange="previewImage(event)">

                <!-- Phần xem trước ảnh, hiển thị ảnh hiện tại hoặc ảnh vừa chọn -->
                <img id="preview" style="max-width: 150px; margin-top: 10px"
                    src="../images/banner/<?php echo htmlspecialchars($banners['image_url']) ?>" alt="Banner Image">
            </div>

            <div class="form-group">
                <label for="order">Thứ tự</label>
                <input type="number" id="order" value="<?php echo htmlspecialchars($banners['order']) ?>" name="order" class="form-control" required min="1" oninput="validateOrderInput(this)">
            </div>
            <div class="form-group" style="padding-bottom: 20px;">
                <label for="action">Show/Hiden</label>
                <?php
               

                $action = isset($banners['action']) ? $banners['action'] : 'Show';
                

                // Kiểm tra lại trong form
                ?>
                <select id="action" name="action" class="form-control" required>
                    <option value="Show" <?php echo ($action === 'Show') ? 'selected' : ''; ?>>Show</option>
                    <option value="Hiden" <?php echo ($action === 'Hiden') ? 'selected' : ''; ?>>Hiden</option>
                </select>




            </div>
            <button class="btn btn-primary mb-3" style="margin-bottom: 15px" type="submit" name="submit">EDIT BANNER</button>
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
            value = value.replace(/[^0-9]/g, ''); // Chỉ cho phép số

            // Loại bỏ dấu chấm (.) nếu có
            value = value.replace(/[.]/g, ''); // Loại bỏ dấu chấm

            // Kiểm tra và loại bỏ số đầu là "0" (ví dụ: "0001", "00020")
            if (value.startsWith('0') && value.length > 1) {
                input.value = value.replace(/^0+/, ''); // Loại bỏ tất cả "0" đầu
            }

            // Nếu giá trị nhập vào nhỏ hơn 1, không cho nhập, giữ nguyên giá trị trước đó
            if (parseInt(value) < 1) {
                input.value = ''; // Đặt lại giá trị trống nếu nhỏ hơn 1
            } else {
                input.value = value; // Cập nhật giá trị vào input
            }
        }
    </script>

    <script>
        function previewImage(event) {
            var output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // Giải phóng bộ nhớ
            }
        }
    </script>

</body>

</html>