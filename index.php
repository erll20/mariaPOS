<?php
session_start();
require 'includes/dbh.inc.php';

// Assuming the user's ID is stored in the session
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$firstName = 'Guest';
$lastName = '';

if ($userId) {
    $stmt = $pdo->prepare("SELECT firstname, lastname FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $firstName = $user['firstname'];
        $lastName = $user['lastname'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="assets/pos style.css">
    <link rel="stylesheet" href="assets/cashier style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqb0M7pG8RfF88/04it6jqhB" crossorigin="anonymous">
    <link rel="icon" style="border-radius: 50%;" type="image/x-icon" href="assets/images/webicon.png">
    <title>Maria's | Dashboard</title>
</head>
<body class="body-fixed" onload="myFunction()">
    <div id="loading"></div>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxl-magento bx-burst' style='color: var(--dark)'></i>
            <span class="text">MARIA's POS</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="index.php">
                    <i class='bx bxs-dashboard bx-fade-up bx-rotate-90' style='color:orange'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="sales.php">
                    <i class='bx bx-shopping-bag'></i>
                    <span class="text">Sales</span>
                </a>
            </li>
            <li>
                <a href="products.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Products</span>
                </a>
            </li>
            <li>
                <a href="Sales Reports.php">
                    <i class='bx bxs-report'></i>
                    <span class="text">Sales Reports</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="settings.php">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="admin.login.php" class="logout" onclick="logout()">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- NAVBAR -->
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <h1>Welcome, <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>!</h1>
            <div style="font-size: smaller;" class="user-info">
                <span style="border-style: solid; border-top: 10px; border-bottom: 10px; border-color: orange; padding: 6px;" id="date-time"></span>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="index.php">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
        <!-- MAIN -->
        <div class="main-content">
            <a href="sales.php" class="button">
                <i class='bx bxs-shopping-bags bx-fade-up' style='color:#bda305'></i>Sales
            </a>
            <a href="products.php" class="button">
                <i class='bx bx-food-menu bx-tada' style='color:#bda305'></i> Products
            </a>
            <a href="Sales Reports.php" class="button">
                <i class='bx bxs-report bx-tada' style='color:orange'></i> Sales Reports
            </a>
            <a href="settings.php" class="button">
                <i class='bx bx-cog bx-spin bx-rotate-90' style='color:#bda305'></i>Settings
              </a>

            <a href="admin.login.php" class="button" onclick="logout()">
                <i class='bx bx-log-out bx-flashing' style='color:#bda305'></i> Log-Out
            </a>
          </div>          
    </section>
    <!-- CONTENT -->
    
    <script src="assets/js/main.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
