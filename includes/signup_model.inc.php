<?php 

declare(strict_types=1);

function get_username(object $pdo, string $username) 
{
    $query = "SELECT username FROM users WHERE username = :username; ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $firstname, string $lastname, string $email, string $username, string $pwd) {
    $query = "INSERT INTO users (firstname, lastname, email, username, pwd) VALUES (:firstname, :lastname, :email, :username, :pwd)";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];

    $hashedpwd = password_hash($pwd, PASSWORD_BCRYPT, $options); 

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedpwd);
    $stmt->execute();

}