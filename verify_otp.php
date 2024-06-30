<?php
include 'includes/dbh.inc.php';

$otp = $_POST['otp'];
$current_time = time();

// Check if the OTP is valid and not expired
$query = "SELECT * FROM users WHERE otp = :otp AND otp_expiry > :current_time";
$stmt = $pdo->prepare($query);
$stmt->execute(['otp' => $otp, 'current_time' => $current_time]);

if ($stmt->rowCount() > 0) {
    // Redirect to change_password.php with the OTP as a query parameter
    header("Location: change_password.php?otp=" . urlencode($otp));
    exit();
} else {
    echo "<script>
            alert('Invalid or expired OTP.');
            window.location.href = 'forgot_password.php';
          </script>";
}
?>
