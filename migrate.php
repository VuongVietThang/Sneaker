<?php

require_once 'config/database.php';

// Kết nối MySQL mà không chọn cơ sở dữ liệu
$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, null, PORT);

// Kiểm tra kết nối
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Kiểm tra xem cơ sở dữ liệu đã tồn tại hay chưa
$sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'";

$result = $connection->query($sql);

// Nếu cơ sở dữ liệu chưa tồn tại, tạo mới
if ($result->num_rows == 0) {
    $createDbSql = "CREATE DATABASE " . DB_NAME;
    if ($connection->query($createDbSql) === TRUE) {
        echo "Database " . DB_NAME . " created successfully.\n";
    } else {
        echo "Error creating database: " . $connection->error . "\n";
    }
} else {
    echo "Database " . DB_NAME . " already exists.\n";
}

// Kết nối lại với cơ sở dữ liệu 'sneaker'
$connection->select_db(DB_NAME);

// Đóng kết nối
$connection->close();

require_once 'migrations/create_admin_table.php';
require_once 'migrations/create_banner_table.php';
require_once 'migrations/create_brand_table.php';
require_once 'migrations/create_cart_item_table.php';
require_once 'migrations/create_cart_table.php';
require_once 'migrations/create_color_table.php';
require_once 'migrations/create_favorite_table.php';
require_once 'migrations/create_order_item_table.php';
require_once 'migrations/create_orders_table.php';
require_once 'migrations/create_payment_table.php';
require_once 'migrations/create_product_table.php';
require_once 'migrations/create_product_size_table.php';
require_once 'migrations/create_product_color_table.php';
require_once 'migrations/create_product_image_table.php';
require_once 'migrations/create_review_table.php';
require_once 'migrations/create_size_table.php';
require_once 'migrations/create_user_table.php';

CreateUserTable::up();
CreateAdminTable::up();
CreateBannerTable::up();
CreateBrandTable::up();
CreateCartTable::up();
CreateColorTable::up();
CreateProductTable::up();
CreateReviewTable::up();
CreateOrdersTable::up();
CreateSizeTable::up();
CreateFavoriteTable::up();

CreateCartItemTable::up();
CreateOrderItemTable::up();
CreatePaymentTable::up();
CreateProductColorTable::up();
CreateProductImageTable::up();
CreateProductSizeTable::up();


