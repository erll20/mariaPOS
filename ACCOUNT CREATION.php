<?php
require 'includes/signup_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" style="border-radius: 50%;" type="image/x-icon" href="images/webicon.png">
    <title>MARIA's | Creating Account </title>
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
<body onload="myFunction4()">
    <div id="loading"></div>
    <center>
    <div class="wrapper">
        <form id="createAccountForm" action="includes/signup.inc.php" method="post" onsubmit="return validateCreateAccount()" onsubmit="return isusernameAvailable()">
            <h2>Create your Account</h2>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="person-circle-outline"></ion-icon>
                </span>
                <input type="text" id="firstname" placeholder="First Name" name="firstname" required>
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="person-circle-outline"></ion-icon>
                </span>
                <input type="text" id="lastname" placeholder="Last Name" name="lastname" required>
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="person-add-outline"></ion-icon>
                </span>
                <input type="text" id="username" placeholder="Create a Username" name="username" required>
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="mail-outline"></ion-icon>
                </span>
                <input type="email" id="email" name="email" placeholder="E-Mail" required>
                <small id="emailError" style="color: red; display: none;">Please enter a valid email address.</small>
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" id="createApassword" placeholder="Create a Password" name="pwd" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('createApassword', this)">
                    <ion-icon name="eye-outline"></ion-icon>
                </span>
            </div>
            <div class="input-group">
                <span class="icon">
                    <ion-icon name="bag-check-outline"></ion-icon>
                </span>
                <input type="password" id="confirmPassword" placeholder="Confirm Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('confirmPassword', this)">
                    <ion-icon name="eye-outline"></ion-icon>
                </span>
            </div>
            <button type="submit" class="btn5">Submit</button>
        </form>

        <?php 
        check_signup_errors();
        ?>

    </center>
    </div>
    <script>
		var preloader = document.getElementById('loading');

        function myFunction4() {
            // Delay hiding the loading overlay (adjust the time as needed)
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 3000); // Hide after 4 seconds
        }

        window.onbeforeunload = function(event) {
            // Check if the submit button was clicked
            if (event.target.activeElement.tagName !== 'BUTTON') {
                return "Data will be lost if you leave the page. Are you sure?";
            }
        };
        
        function validateCreateAccount() {
            var username = document.getElementById('username').value;
            var firstname = document.getElementById('firstname').value;
            var lastname = document.getElementById('lastname').value;
            var email = document.getElementById('email').value;
            var createApassword = document.getElementById('createApassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            if (createApassword !== confirmPassword) {
                alert("The new passwords do not match. Please try again.");
                return false; // Prevent form submission
            }

            if (createApassword.length < 8) {
                alert("Password must be at least 8 characters.");
                return false; // Prevent form submission
            }
            
            return true; // Allow form submission
        }

        function checkusernameAvailability(username) {
            // Replace this with your logic to check if the username is available
            // For demonstration purposes, assume it's available
            return true;
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

        function validateForm() {
            var emailInput = document.getElementById('email');
            var emailError = document.getElementById('emailError');

            // Check if email contains '@'
            if (!emailInput.value.includes('@')) {
                emailError.style.display = 'block';
                return false;
            } else {
                emailError.style.display = 'none';
                return true;
            }
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
