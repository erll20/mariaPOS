<?php
session_start();
require 'includes/dbh.inc.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $originalPrice = $_POST['ogprice'];
    $sellingPrice = $_POST['price'];

    if ($name && $description && $originalPrice && $sellingPrice) {
        // Check if a product with the same name already exists
        $stmt = $pdo->prepare("SELECT id FROM products WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingProduct) {
            // Update the existing product
            $stmt = $pdo->prepare("UPDATE products SET description = :description, original_price = :original_price, selling_price = :selling_price WHERE id = :id");
            $result = $stmt->execute([
                ':description' => $description,
                ':original_price' => $originalPrice,
                ':selling_price' => $sellingPrice,
                ':id' => $existingProduct['id']
            ]);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update product in the database.']);
            }
        } else {
            // Insert the new product
            $stmt = $pdo->prepare("INSERT INTO products (name, description, original_price, selling_price) VALUES (:name, :description, :original_price, :selling_price)");
            $result = $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':original_price' => $originalPrice,
                ':selling_price' => $sellingPrice
            ]);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Product added successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add product to the database.']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
