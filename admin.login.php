<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" style="border-radius: 50%;" type="image/x-icon" href="images/webicon.png">
    <title>MARIA's | LOGIN</title>
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
<body onload="myFunction2()">
    <div id="loading"></div>
    <div class="wrapper">
        <form id="loginForm" action="includes/login.inc.php" method="POST">
            <center>
            <h2>Welcome <br>Back!</h2>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <input type="text" id="username" placeholder="Username" name="username" required>
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" id="password" placeholder="Password" name="pwd" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                    <ion-icon name="eye-outline"></ion-icon>
                </span>
            </div>
            <div class="forgot-pass">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>
            <button type="submit" class="btn3">Login</button>
            <button type="button" onclick="validateClick()" class="btn4">Create Account</button>
            </center>
        </form>

        <?php
        if (isset($_SESSION["errors_login"])) {
            echo '<script>';
            foreach ($_SESSION["errors_login"] as $error) {
                echo 'alert("' . htmlspecialchars($error) . '");';
            }
            echo '</script>';
            unset($_SESSION["errors_login"]); // Clear the errors after displaying
        }
        ?>
    </div>
    <script>
        var preloader = document.getElementById('loading');
        function myFunction2() {
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 2000); // Hide after 2 seconds
        }

        function togglePasswordVisibility(passwordFieldId, icon) {
            var passwordInput = document.getElementById(passwordFieldId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.innerHTML = '<ion-icon name="eye-off-outline"></ion-icon>'; // Change icon to eye-off
            } else {
                passwordInput.type = 'password';
                icon.innerHTML = '<ion-icon name="eye-outline"></ion-icon>'; // Change icon to eye
            }
        }

        function validateClick() {
            window.location.href = "ACCOUNT CREATION.php"; // Corrected the filename format
        }

        window.addEventListener('beforeunload', function (event) {
            event.preventDefault();
            event.returnValue = ''; // Empty string shows a generic confirmation message
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
