<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require 'dbh.inc.php';
        require 'login_model.inc.php';
        require 'login_contr.inc.php';

        // Error handler
        $errors = [];
        if (is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $username);

        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        if (!is_username_wrong($result) && is_password_wrong($pwd, $result["pwd"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }
       
        require_once 'config_session.inc.php';
        
        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            header("Location: ../admin.login.php");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["last_regeneration"] = time();

        header("Location: ../index.php");
        $pdo = null;
        $statement = null;

        die();

    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }

} else {
    header("Location: ../admin.login.php");
    die();
}
