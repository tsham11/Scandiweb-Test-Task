<?php
include 'database.php'; 

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['sku'])) {
    $sku = $input['sku'];

    $query = "SELECT * FROM products WHERE sku = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $sku);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['unique' => false]);
    } else {
        echo json_encode(['unique' => true]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['unique' => false, 'error' => 'Invalid request.']);
}

mysqli_close($connection);
