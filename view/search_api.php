<?php
require_once '../config/database.php';
require_once '../model/db.php';
require_once '../model/product.php';

header('Content-Type: application/json');

$productModel = new Product();

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $results = $productModel->searchProducts($query);

    // Return JSON data instead of HTML
    echo json_encode($results);
} elseif (isset($_GET['all'])) {
    $results = $productModel->getAllProducts();
    echo json_encode($results);
}
