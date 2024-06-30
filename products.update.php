<?php
session_start();
require 'includes/dbh.inc.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $originalPrice = $_POST['ogprice'];
    $sellingPrice = $_POST['price'];

    if ($id && $name && $description && $originalPrice && $sellingPrice) {
        $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, original_price = :original_price, selling_price = :selling_price WHERE id = :id");
        $result = $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':original_price' => $originalPrice,
            ':selling_price' => $sellingPrice,
            ':id' => $id
        ]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update product in the database.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}