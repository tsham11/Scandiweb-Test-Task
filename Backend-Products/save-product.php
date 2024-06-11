<?php
include 'database.php'; 

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Fields mapping for product types
$productFields = [
    'DVD' => [
        'columns' => ['size'],
        'preprocess' => function ($attributes) {
            return $attributes;
        }
    ],
    'Book' => [
        'columns' => ['weight'],
        'preprocess' => function ($attributes) {
            return $attributes;
        }
    ],
    'Furniture' => [
        'columns' => ['height', 'width', 'length'],
        'preprocess' => function ($attributes) {
            $attributes['dimensions'] = $attributes['height'] . 'x' . $attributes['width'] . 'x' . $attributes['length'];
            unset($attributes['height'], $attributes['width'], $attributes['length']);
            return $attributes;
        }
    ]
];

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input) {
    $sku = $input['sku'];
    $name = $input['name'];
    $price = $input['price'];
    $productType = $input['productType'];
    $attributes = [];

    // Collect product type specific fields
    $productTypeFields = $productFields[$productType]['columns'] ?? [];
    foreach ($productTypeFields as $field) {
        $attributes[$field] = $input[$field] ?? null;
    }

    // Preprocess attributes if needed
    $attributes = $productFields[$productType]['preprocess']($attributes);

    // Insert product into database
    $query = "INSERT INTO products (sku, name, price, type, size, weight, dimensions) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);

    $size = $attributes['size'] ?? null;
    $weight = $attributes['weight'] ?? null;
    $dimensions = $attributes['dimensions'] ?? null;

    mysqli_stmt_bind_param($stmt, 'ssdssss', $sku, $name, $price, $productType, $size, $weight, $dimensions);
    $executeResult = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($executeResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error saving product.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}

mysqli_close($connection);
