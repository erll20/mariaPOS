<?php
include 'includes/dbh.inc.php';

$otp = $_POST['otp'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    die('Passwords do not match.');
}

$current_time = time();

// Check if the OTP is valid and not expired
$query = "SELECT * FROM users WHERE otp = :otp AND otp_expiry > :current_time";
$stmt = $pdo->prepare($query);
$stmt->execute(['otp' => $otp, 'current_time' => $current_time]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Hash the new password
    $hashed_pwd = password_hash($new_password, PASSWORD_BCRYPT);
    
    // Update the user's password and clear the OTP fields
    $update_query = "UPDATE users SET pwd = :password, otp = NULL, otp_expiry = NULL WHERE id = :id";
    $update_stmt = $pdo->prepare($update_query);
    
    if ($update_stmt->execute(['password' => $hashed_pwd, 'id' => $user['id']])) {
        header('Location: admin.login.php');
        exit();
    } else {
        echo 'Failed to reset password.';
    }
} else {
    echo "<script>
            alert('Invalid or expired OTP.');
            window.location.href = 'forgot_password.php';
          </script>";
}
?>
