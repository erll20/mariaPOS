<?php
session_start();
require 'includes/dbh.inc.php';

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$firstName = 'Guest';
$lastName = '';
$email = '';
$username = '';

if ($userId) {
    $stmt = $pdo->prepare("SELECT firstname, lastname, email, username FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $firstName = $user['firstname'];
        $lastName = $user['lastname'];
        $email = $user['email'];
        $username = $user['username'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/pos style.css">
    <link rel="stylesheet" href="assets/settings.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqb0M7pG8RfF88/04it6jqhB" crossorigin="anonymous">
    <link rel="icon" style="border-radius: 50%;" type="image/x-icon" href="assets/images/webicon.png">
    <title>Maria's | Settings</title>
</head>
<body class="body-fixed" onload="myFunction()">
    <div id="loading"></div>

    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxl-magento bx-burst' style='color: var(--dark)'></i>
            <span class="text">MARIA's POS</span>
        </a>
        <ul class="side-menu top">
            <li><a href="index.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="sales.php"><i class='bx bx-shopping-bag'></i><span class="text">Sales</span></a></li>
            <li><a href="products.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Products</span></a></li>
            <li><a href="Sales Reports.php"><i class='bx bxs-report'></i><span class="text">Sales Reports</span></a></li>
        </ul>
        <ul class="side-menu">
            <li class="active"><a href="settings.php"><i class='bx bxs-cog bx-spin' style='color:orange'></i><span class="text">Settings</span></a></li>
            <li><a href="admin.login.php" class="logout" onclick="logout()"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <h1>Welcome!</h1>
            <div style="font-size: smaller;" class="user-info">
                <span style="border-style: solid; border-top: 10px; border-bottom: 10px; border-color: orange; padding: 6px;" id="date-time"></span>
            </div>
        </nav>

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Settings</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="settings.php">Account Information</a></li>
                    </ul>
                </div>
            </div>
        </main>

        <div class="container2">
            <h2>Personal Information</h2>
            <br>
            <div class="container">
                <div class="info"><i class='bx bxs-user-detail' style="color: orange;"></i><strong>First Name:</strong> <span><?php echo htmlspecialchars($firstName); ?></span></div>
                <div class="info"><i class='bx bxs-user-detail' style="color: orange;"></i><strong>Last Name:</strong> <span><?php echo htmlspecialchars($lastName); ?></span></div>
                <div class="info">
                    <i class='bx bx-envelope' style="color: orange;"></i><strong>Username:</strong>
                    <span id="usernameText"><?php echo htmlspecialchars($username); ?></span>
                    <input type="text" id="newUsername" style="display:none;">
                    <button id="changeUsernameBtn" onclick="editInfo('username')">Change</button> <!-- Change button for Username -->
                    <button id="cancelUsernameBtn" style="display:none;" onclick="cancelEdit('username')">Cancel</button> <!-- Cancel button for Username -->
                </div>
                <div class="info">
                    <i class='bx bx-envelope' style="color: orange;"></i><strong>Email:</strong>
                    <span id="emailText"><?php echo htmlspecialchars($email); ?></span>
                    <input type="email" id="newEmail" style="display:none;">
                    <button id="changeEmailBtn" onclick="editInfo('email')">Change</button> <!-- Change button for Email -->
                    <button id="cancelEmailBtn" style="display:none;" onclick="cancelEdit('email')">Cancel</button> <!-- Cancel button for Email -->
                </div>
                <div class="info">
                    <i class='bx bxs-lock' style="color: orange;"></i><strong>Password:</strong>
                    <span id="passwordText">******** </span>
                    <input type="password" id="newPassword" style="display:none;">
                    <ion-icon id="passwordEye" name="eye-off-outline" class="eye-icon" style="display: none;"></ion-icon>
                    <button id="changePasswordBtn" onclick="editInfo('password')">Change</button> <!-- Change button for Password -->
                    <button id="cancelPasswordBtn" style="display:none;" onclick="cancelEdit('password')">Cancel</button> <!-- Cancel button for Password -->
                </div>
                <br>
                <button id="saveChangesBtn" style="display:none;" onclick="saveInfo('<?php echo htmlspecialchars($userId); ?>')">Save Changes</button> <!-- Initially hidden -->
                <a href="admin.login.php"><button id="logoutBtn" onclick="logout()">Log-Out</button></a>
            </div>
        </div>
    </section>
    <script src="assets/js/main.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>