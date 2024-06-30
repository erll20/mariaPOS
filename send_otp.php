<?php
include 'includes/dbh.inc.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'];

// Check if email exists in the database
$query = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($query);
$stmt->execute(['email' => $email]);

if ($stmt->rowCount() > 0) {
    // Email exists, proceed with OTP generation and sending
    $otp = rand(100000, 999999);
    $expiry_time = time() + 300; // OTP expires in 5 minutes

    $update_query = "UPDATE users SET otp = :otp, otp_expiry = :otp_expiry WHERE email = :email";
    $stmt = $pdo->prepare($update_query);
    if ($stmt->execute(['otp' => $otp, 'otp_expiry' => $expiry_time, 'email' => $email])) {
        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mariaspos711@gmail.com';
            $mail->Password = 'jull zbsi qhzu oiyk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('mariaspos711@gmail.com', 'Marias POS');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code For MariasPOS Account Reset Password';
            $mail->Body    = "Your OTP code is <b>$otp</b>. It will expire in 5 minutes.";

            $mail->send();
            
            // Redirect to verify_otp.php
            header('Location: verification.php');
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to send OTP.";
    }
} else {
    // Email does not exist, return an error
    echo "<script>
            alert('The email address is not registered.');
            window.location.href = 'forgot_password.php';
          </script>";
}
?>
