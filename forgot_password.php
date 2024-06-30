<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" style="border-radius: 50%;" type="image/x-icon" href="assets/images/webicon.png">
    <title>MARIA's | FORGOT PASSWORD </title>
    <link rel="stylesheet" href="assets/login style.css">
</head>
<body>
<div class="wrapper">
            <form id="forgot-password-form" action="send_otp.php" method="POST">
            <center>
            <h2>Forgot Password</h2>
            <div class="input-group">
                <span class="icon">
                <label for="email"><ion-icon name="mail-outline"></ion-icon></label>
                </span>
                <input type="email" id="email" name="email" placeholder="E-Mail" required>
            </div>
            <button type="submit" class="btn4">Send OTP</button>
            </center>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
