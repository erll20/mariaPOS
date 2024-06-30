<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require 'dbh.inc.php';
        require 'signup_model.inc.php';
        require 'signup_contr.inc.php';

        $errors = [];

        if (is_input_empty($firstname, $lastname, $email, $username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used!";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken!";
        }

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            header("Location: ../ACCOUNT CREATION.php");
            die();
        }

        create_user($pdo, $firstname, $lastname, $email, $username, $pwd);
        header("Location: ../admin.login.php?signup=success");

        $pdo = null;
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../ACCOUNT_CREATION.php");
    die();
}
