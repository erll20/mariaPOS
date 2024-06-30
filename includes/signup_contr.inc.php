<?php 

declare(strict_types=1);

function is_input_empty(string $firstname, string $lastname, string $email, string $username, string $pwd) {
    if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function is_username_taken(object $pdo, string $username) {
    if (get_username ($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo, string $firstname, string $lastname, string $email, string $username, string $pwd) {
    set_user($pdo, $firstname, $lastname, $email, $username, $pwd);
}