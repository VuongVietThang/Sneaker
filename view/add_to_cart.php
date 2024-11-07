<?php
session_start();

header('Content-Type: application/json');

// Get the raw POST data
$json = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($json, true);

if ($data && isset($data['brand_id']) && isset($data['product_id']) && isset($data['product_name']) && isset($data['price'])) {
    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $productId = $data['product_id'];

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$productId])) {
        // If the product is already in the cart, increase the quantity
        $_SESSION['cart'][$productId]['quantity']++;
    } else {
        // If it's a new product, add it to the cart
        $_SESSION['cart'][$productId] = [
            'brand_id' => $data['brand_id'],
            'product_id' => $data['product_id'],
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'quantity' => 1
        ];
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
