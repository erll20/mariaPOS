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
    <title>MARIA's | LOGIN </title>
    <link rel="stylesheet" href="assets/login style.css">
    <style>
        .input-group .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: white;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <form id="reset-password-form" action="reset_password.php" method="POST" onsubmit="return validateForm()">
        <center>
        <h2>Reset Password</h2>
        <input type="hidden" id="otp-hidden" name="otp" value="<?php echo $_GET['otp']; ?>">
        <div class="input-group">
            <span class="icon">
                <ion-icon name="lock-closed"></ion-icon>
            </span>
            <input type="password" id="new-password" name="new_password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('new-password', this)">
                <ion-icon name="eye-outline"></ion-icon>
            </span>
        </div>
        <div class="input-group">
            <span class="icon">
                <ion-icon name="lock-closed"></ion-icon>
            </span>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password', this)">
                <ion-icon name="eye-outline"></ion-icon>
            </span>
        </div>
        <button type="submit" class="btn4">Reset Password</button>
        </center>
    </form>
</div>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script>
    function togglePasswordVisibility(passwordFieldId, icon) {
        var passwordInput = document.getElementById(passwordFieldId);
        var iconElement = icon.querySelector('ion-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconElement.name = 'eye-off-outline'; // Change icon to eye-off
        } else {
            passwordInput.type = 'password';
            iconElement.name = 'eye-outline'; // Change icon to eye
        }
    }

    function validateForm() {
        var newPassword = document.getElementById('new-password').value;
        var confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword.length < 8) {
            alert('Password must be at least 8 characters.');
            return false;
        }

        if (newPassword !== confirmPassword) {
            alert('Passwords do not match.');
            return false;
        }

        return true;
    }
</script>
</body>
</html>
