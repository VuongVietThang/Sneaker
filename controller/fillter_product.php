<?php
require_once '../model/db.php';
require_once '../model/product.php';
$productModel = new Product();
if (isset($_GET['brand_id']) && isset($_GET['color_name'])) { 
    $brand_id = $_GET['brand_id']; $color_name = $_GET['color_name']; 
    $product = new Product(); 
    $filteredProducts = $product->fillterProduct($brand_id, $color_name); 
    echo json_encode($filteredProducts); 
}