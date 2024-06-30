<?php
session_start();
require 'includes/dbh.inc.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete product from the database.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product ID is required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}