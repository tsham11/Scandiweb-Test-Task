<?php
include 'database.php'; 

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Read the input JSON data
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['products']) && is_array($data['products'])) {
        // Get the list of product SKUs to delete
        $skusToDelete = $data['products'];

        // Prepare the SQL statement with placeholders
        $placeholders = implode(',', array_fill(0, count($skusToDelete), '?'));

        // Create the SQL query
        $query = "DELETE FROM products WHERE sku IN ($placeholders)";

        // Initialize the prepared statement
        if ($stmt = mysqli_prepare($connection, $query)) {
            // Bind the parameters
            mysqli_stmt_bind_param($stmt, str_repeat('s', count($skusToDelete)), ...$skusToDelete);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No products selected for deletion.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

// Close the database connection
mysqli_close($connection);
