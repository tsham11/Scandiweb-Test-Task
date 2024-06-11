<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include 'database.php'; 
include 'ProductType.php'; 

header('Content-Type: application/json');

// Fetch products from the database, sorted by primary key
$query = "SELECT * FROM products ORDER BY id";
$result = mysqli_query($connection, $query);

// Check if query was successful
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed.']);
    exit;
}

// Array to store products
$products = [];

// Loop through products and create product objects
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = ProductType::createProduct($row);
}

// Convert product objects to an array for JSON response
$productArray = array_map(function($product) {
    return [
        'sku' => $product->getSKU(),
        'name' => $product->getName(),
        'price' => $product->getPrice(),
        'attribute' => $product->displayAttribute()
    ];
}, $products);

echo json_encode($productArray);