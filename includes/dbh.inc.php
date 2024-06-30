<?php 

/* $user = 'root';
$pass = '';
$db = 'accounts';

$db = new mysqli('localhost', $user, $pass, $db) or die ("Unable to connect");

$serverName = "localhost";
$username = "root";
$password = "" ;
$dbname = "test";

$con = mysqli_connect ($serverName, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    echo "failed to connect.";
    exit();
}*/



$host = 'localhost';
$dbname = 'mariaspos'; // Ensure this is the correct database name
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
