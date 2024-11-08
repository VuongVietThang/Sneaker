<?php
require_once '../model/product_db.php';

// Lấy danh sách màu sắc và kích thước
$colors = $banhang->getAllColors(); // Gọi phương thức lấy màu sắc
$sizes = $banhang->getAllSizes(); // Gọi phương thức lấy kích thước
$brands = $banhang->getAllBrands(); // Gọi phương thức lấy danh sách hãng

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu và bảo vệ đầu vào
    $brand_id = htmlspecialchars($_POST['brand_id']);
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $type = htmlspecialchars($_POST['type']);
    $color_ids = $_POST['color_ids'] ?? []; // Màu sắc (nhiều giá trị)
    $size_ids = $_POST['size_ids'] ?? []; // Kích thước (nhiều giá trị)

    // Khởi tạo đối tượng Product_db
    $product_db = new Product_db();

    // Thêm sản phẩm mới vào cơ sở dữ liệu
    $product_db->addProduct($brand_id, $name, $description, $price, $type);

    // Lấy product_id tự động tạo ra
    $product_id = $product_db->getLastProductId();

    // Thêm màu sắc cho sản phẩm
    foreach ($color_ids as $color_id) {
        $product_db->addProductColor($product_id, $color_id);
    }

    // Thêm kích thước cho sản phẩm
    foreach ($size_ids as $size_id) {
        $product_db->addProductSize($product_id, $size_id);
    }

    // Xử lý tải lên hình ảnh chính
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        // Di chuyển hình ảnh chính
        $main_image_url = '../admin/uploads/' . basename($_FILES['main_image']['name']);
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $main_image_url)) {
            // Thêm hình ảnh chính vào cơ sở dữ liệu
            $product_db->addProductImage($product_id, $main_image_url, 1); // 1 là is_main
        } else {
            echo "Có lỗi xảy ra khi tải lên hình chính.";
        }
    }

    // Xử lý tải lên hình ảnh phụ (tối đa 3 hình)
    if (!empty($_FILES['additional_images']['name'][0])) {
        $uploaded_count = 0;

        foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['additional_images']['error'][$key] == 0) {
                // Giới hạn tối đa 3 hình phụ
                if ($uploaded_count >= 3) {
                    echo "Đã vượt quá số lượng hình phụ cho phép.";
                    break;
                }

                $additional_image_url = '../admin/uploads/' . basename($_FILES['additional_images']['name'][$key]);
                if (move_uploaded_file($tmp_name, $additional_image_url)) {
                    // Thêm hình ảnh phụ vào cơ sở dữ liệu
                    $product_db->addProductImage($product_id, $additional_image_url, 0); // 0 là is_main
                    $uploaded_count++;
                } else {
                    echo "Có lỗi xảy ra khi tải lên hình phụ: " . $_FILES['additional_images']['name'][$key];
                }
            }
        }
    }

    // Chuyển hướng sau khi thêm sản phẩm thành công
    header("Location: ../admin/quanlysanpham.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm</title>
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

        .custom-file-input:lang(en) ~ .custom-file-label::after {
            content: "Browse";
        }

        .custom-file-label {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Thêm Sản Phẩm</h2>
        <form action="" method="POST" enctype="multipart/form-data">          
            <div class="form-group">
                <label for="name">Tên Sản Phẩm</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Mô Tả</label>
                <input type="text" id="description" name="description" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Giá Sản Phẩm</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Kiểu Giày</label>
                <input type="text" id="type" name="type" class="form-control" required>
            </div>
            <div class="form-group">
    <label for="brand_id">Hãng</label>
    <select id="brand_id" name="brand_id" class="form-control" required>
        <option value="">Vui lòng chọn hãng</option>
        <?php foreach ($brands as $brand): ?>
            <option value="<?php echo $brand['brand_id']; ?>"><?php echo $brand['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

            <div class="form-group">
                <label for="color_ids">Màu Sắc</label>
                <select id="color_ids" name="color_ids[]" class="form-control" multiple required>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?php echo $color['color_id']; ?>"><?php echo $color['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <small>Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều màu sắc.</small>
            </div>

            <div class="form-group">
                <label for="size_ids">Kích Thước</label>
                <select id="size_ids" name="size_ids[]" class="form-control" multiple required>
                    <?php foreach ($sizes as $size): ?>
                        <option value="<?php echo $size['size_id']; ?>"><?php echo $size['value']; ?></option>
                    <?php endforeach; ?>
                </select>
                <small>Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều kích thước.</small>
            </div>

            <div class="form-group">
                <label for="main_image">Hình Chính</label>
                <input type="file" id="main_image" name="main_image" class="form-control-file" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="additional_images">Hình Phụ (Tối đa 3 hình)</label>
                <input type="file" id="additional_images" name="additional_images[]" class="form-control-file" accept="image/*" multiple required>
                <small>Giữ Ctrl để chọn nhiều hình (tối đa 3 hình).</small>
            </div>

            <button type="submit">Thêm Sản Phẩm</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

