<?php
session_start();
require 'dbh.inc.php'; // Adjust path as needed

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['user_id'];
$newEmail = $data['email'];
$newPassword = $data['pwd'];
$newUsername = $data['username'];

if ($userId && ($newEmail || $newPassword || $newUsername)) {
    $updateFields = [];
    $params = ['id' => $userId];

    if ($newEmail) {
        // Validate and sanitize email if necessary
        $updateFields[] = 'email = :email';
        $params['email'] = $newEmail;
    }

    if ($newPassword) {
        // Hash the new password securely
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateFields[] = 'pwd = :pwd';
        $params['pwd'] = $hashedPassword;
    }
    
    if ($newUsername) {
        // Validate and sanitize username if necessary
        $updateFields[] = 'username = :username';
        $params['username'] = $newUsername;
    }

    $updateFieldsStr = implode(', ', $updateFields);

    $stmt = $pdo->prepare("UPDATE users SET $updateFieldsStr WHERE id = :id");
    $success = $stmt->execute($params);

    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false]);
}
?>