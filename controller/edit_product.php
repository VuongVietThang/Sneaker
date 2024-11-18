<?php
include_once('../model/product_db.php');
// hàm giải mã Hex product_id
function decryptProductId($encrypted_product_id) {
    $key = 'secret_key';
    $iv = '1234567890123456';
    $encrypted_data = hex2bin($encrypted_product_id); // Chuyển từ hex về dạng nhị phân
    return openssl_decrypt($encrypted_data, 'aes-128-cbc', $key, 0, $iv);
}

// Giải mã product_id từ GET request
if (isset($_GET['product_id'])) {
    $decoded_product_id = decryptProductId($_GET['product_id']); // Giải mã
    $thongtinsanpham = $banhang->timSanPham($decoded_product_id); // Lấy thông tin sản phẩm
    $selected_colors = $banhang->getSelectedColors($decoded_product_id); // Lấy màu đã chọn
    $selected_sizes = $banhang->getSelectedSizes($decoded_product_id);   // Lấy kích thước đã chọn
    $selected_brand = $banhang->getSelectedBrand($decoded_product_id);   // Lấy thương hiệu đã chọn
    $colors = $banhang->getAllColors(); // Lấy tất cả màu
    $sizes = $banhang->getAllSizes();   // Lấy tất cả kích thước
    $brands = $banhang->getAllBrands(); // Lấy tất cả thương hiệu
}

// Cập nhật sản phẩm
if (isset($_POST['name'], $_POST['price'], $_POST['description'], $_POST['type'], $_POST['color_ids'], $_POST['size_ids'], $_POST['brand_id'])) {
    $product_id = $decoded_product_id; // Sử dụng decoded product_id
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $color_ids = $_POST['color_ids'];
    $size_ids = $_POST['size_ids'];
    $brand_id = $_POST['brand_id']; // Lấy thương hiệu
    $main_image = null;
    $additional_images = [];

    // Xử lý ảnh chính
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == UPLOAD_ERR_OK) {
        // Lấy ảnh chính cũ và xóa nếu có
        $old_main_image = $banhang->getMainImage($product_id);
        if ($old_main_image) {
            $file_path = '../images/product/' . basename($old_main_image['image_url']);
            if (file_exists($file_path)) {
                unlink($file_path); // Xóa ảnh cũ
            }
            // Xóa ảnh chính cũ khỏi cơ sở dữ liệu
            $banhang->deleteProductImages($product_id, 1); // is_main = 1 là ảnh chính
        }

        // Xử lý thêm ảnh chính mới
        $main_image_name = basename($_FILES['main_image']['name']);
        $main_image_path = '../images/product/' . $main_image_name;
        move_uploaded_file($_FILES['main_image']['tmp_name'], $main_image_path);
        $banhang->addProductImage($product_id, $main_image_name, 1); // is_main = 1 là ảnh chính
    }

    // Xử lý ảnh phụ
    if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'])) {
        // Lấy các ảnh phụ cần xóa từ mảng `remove_images`
        $images_to_remove = isset($_POST['remove_images']) ? $_POST['remove_images'] : [];

        // Xóa ảnh phụ cũ đã được chọn để xóa
        foreach ($images_to_remove as $image_to_remove) {
            // Kiểm tra nếu ảnh này là ảnh chính, bỏ qua không xóa
            $is_main_image = $banhang->isMainImage($product_id, $image_to_remove);
            if (!$is_main_image) {
                $file_path = '../images/product/' . basename($image_to_remove);
                if (file_exists($file_path)) {
                    unlink($file_path); // Xóa ảnh khỏi thư mục
                }
                $banhang->deleteProductImageById($product_id, basename($image_to_remove)); // Xóa ảnh khỏi CSDL
            }
        }

        // Thêm ảnh phụ mới vào thư mục và CSDL, nhưng tránh thêm ảnh chính làm ảnh phụ
        foreach ($_FILES['additional_images']['name'] as $key => $filename) {
            if ($filename != '') {
                $additional_image_name = basename($filename);
                $additional_image_path = '../images/product/' . $additional_image_name;

                // Kiểm tra nếu ảnh này trùng với ảnh chính, thì bỏ qua việc thêm ảnh phụ
                if ($additional_image_name !== $main_image_name) {
                    move_uploaded_file($_FILES['additional_images']['tmp_name'][$key], $additional_image_path);
                    $banhang->addProductImage($product_id, $additional_image_name, 0); // is_main = 0 là ảnh phụ
                }
            }
        }
    }

    // Cập nhật thông tin sản phẩm
    $banhang->editSanPham($product_id, $brand_id, $name, $description, $price, $type);

    // Cập nhật màu sắc và kích thước
    $banhang->deleteProductColors($product_id);
    foreach ($color_ids as $color_id) {
        $banhang->addProductColor($product_id, $color_id);
    }

    $banhang->deleteProductSizes($product_id);
    foreach ($size_ids as $size_id) {
        $banhang->addProductSize($product_id, $size_id);
    }

    // Cập nhật thương hiệu
    $banhang->editProductBrand($product_id, $brand_id); // Cập nhật thương hiệu vào CSDL

    header('location: ../admin/quanlysanpham.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sản Phẩm</title>
    <link rel="shortcut icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #343a40;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus,
        select:focus {
            border: 1px solid #007bff;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .note {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin-top: 10px;
        }

        .current-images {
            margin-bottom: 15px;
        }

        .current-images img {
            width: 100px;
            height: auto;
            margin: 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .highlighted-option {
            background-color: #d1e7ff;
            font-weight: bold;
        }

        small {
            display: block;
            color: #6c757d;
            margin-top: 5px;
        }

        .current-images {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            /* Khoảng cách giữa các hình ảnh */
        }

        .image-container {
            position: relative;
            margin-right: 10px;
            border-radius: 8px;
            /* Bo góc cho ảnh */
            overflow: hidden;
            /* Ẩn phần ngoài viền ảnh */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Bóng đổ nhẹ */
        }

        .image-container img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
            /* Hiệu ứng zoom khi hover */
        }

        .image-container:hover img {
            transform: scale(1.05);
            /* Phóng to ảnh khi hover */
        }

        .remove-image {
            position: absolute;
            top: 2px;
            right: -1px;
            background-color: rgba(255, 0, 0, 0.8);
            /* Nền đỏ với độ trong suốt */
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 8px;
            border-radius: 50%;
            /* Bo tròn nút */
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            /* Hiệu ứng hover và phóng to */
        }

        .remove-image:hover {
            background-color: red;
            /* Màu nền đỏ khi hover */
            transform: scale(1.2);
            /* Phóng to nút khi hover */
        }

        .remove-image:focus {
            outline: none;
            /* Loại bỏ viền khi nút được chọn */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fas fa-edit"></i> Edit Sản Phẩm</h2>
        <form action="edit_product.php?product_id=<?php echo $_GET['product_id']; ?>" method="post" enctype="multipart/form-data">
            <?php foreach ($thongtinsanpham as $value) { ?>
                <div class="form-group">
                    <label for="name">Tên Sản Phẩm</label>
                    <input type="text" name="name" value="<?php echo $value['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Giá Sản Phẩm</label>
                    <input type="number" name="price" value="<?php echo $value['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Mô Tả Sản Phẩm</label>
                    <input type="text" name="description" value="<?php echo $value['description']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="type">Kiểu Giày</label>
                    <input type="text" name="type" value="<?php echo $value['type']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="brand_id">Thương Hiệu</label>
                    <select name="brand_id" required>
                        <option value="">Chọn Thương Hiệu</option>
                        <?php foreach ($brands as $brand) { ?>
                            <option value="<?php echo htmlspecialchars($brand['brand_id']); ?>"
                                <?php echo (isset($selected_brand) && $brand['brand_id'] == $selected_brand) ? 'class="highlighted-option" selected' : ''; ?>>
                                <?php echo htmlspecialchars($brand['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color_ids">Màu Sắc</label>
                    <select id="color_ids" name="color_ids[]" multiple required>
                        <?php foreach ($colors as $color): ?>
                            <option value="<?php echo $color['color_id']; ?>"
                                <?php echo in_array($color['color_id'], $selected_colors) ? 'class="highlighted-option" selected' : ''; ?>>
                                <?php echo $color['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small>Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều màu sắc.</small>
                </div>

                <div class="form-group">
                    <label for="size_ids">Kích Thước</label>
                    <select id="size_ids" name="size_ids[]" multiple required>
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?php echo $size['size_id']; ?>"
                                <?php echo in_array($size['size_id'], $selected_sizes) ? 'class="highlighted-option" selected' : ''; ?>>
                                <?php echo $size['value']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small>Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều kích thước.</small>
                </div>

                <div class="form-group">
                    <label for="main_image">Hình Ảnh Chính</label>
                    <input type="file" name="main_image" accept="image/*">
                    <div class="current-images">
                        <p>Hình Ảnh Chính Hiện Tại:</p>
                        <?php
                        // Lấy hình ảnh chính từ cơ sở dữ liệu
                        $main_image = $banhang->getMainImage($value['product_id']);
                        if ($main_image):
                            $image_url = '../images/product/' . htmlspecialchars($main_image['image_url']);  // Đường dẫn đến ảnh chính
                        ?>
                            <img src="<?php echo $image_url; ?>" alt="Main Image" style="max-width: 100px;">
                        <?php else: ?>
                            <p>Không có hình ảnh chính.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="additional_images">Hình Ảnh Phụ (Tối Đa 3 Hình)</label>
                    <input type="file" name="additional_images[]" accept="image/*" multiple>
                    <div class="current-images">
                        <p>Hình Ảnh Phụ Hiện Tại:</p>
                        <?php
                        // Lấy danh sách hình ảnh phụ từ cơ sở dữ liệu
                        $additional_images = $banhang->getAdditionalImages($value['product_id']);
                        foreach ($additional_images as $image):
                            $image_url = '../images/product/' . htmlspecialchars($image);  // Đường dẫn ảnh phụ
                        ?>
                            <div class="image-container">
                                <img src="<?php echo $image_url; ?>" alt="Additional Image" style="max-width: 100px;">
                                <button type="button" class="remove-image" data-image="<?php echo $image; ?>">X</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <input type="submit" value="Cập Nhật">
                <div class="note">*Lưu ý: Nếu không muốn thay đổi hình ảnh, hãy để trống.</div>
            <?php } ?>
        </form>
    </div>
    <script>
        document.querySelectorAll('.remove-image').forEach(button => {
            button.addEventListener('click', function() {
                const imagePath = this.getAttribute('data-image'); // Lấy tên ảnh từ thuộc tính data-image
                this.parentElement.style.display = 'none';

                // Lưu thông tin ảnh bị xóa (nếu cần gửi lên server)
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_images[]';
                hiddenInput.value = imagePath; // Chỉ lưu tên ảnh bị xóa
                document.querySelector('form').appendChild(hiddenInput);
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>