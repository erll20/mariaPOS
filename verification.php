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
    <title>MARIA's | VERIFY OTP PASSWORD</title>
    <link rel="stylesheet" href="assets/login style.css">
</head>
<body>
<div class="wrapper">
    <form id="otp-form" action="verify_otp.php" method="POST">
        <h2>Enter OTP</h2>
        <center>
        <div class="input-group">
            <span class="icon">
                <label for="otp"><ion-icon name="mail-unread-outline"></ion-icon></label>
            </span>
            <input type="text" id="otp" name="otp" placeholder="OTP" required>
        </div>
        <button type="submit" class="btn4">Verify OTP</button>
        </center>
    </form>
</div>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
