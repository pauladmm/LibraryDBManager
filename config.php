<?php
// config.php
$host = 'localhost';
$dbname = 'library';
$username = 'root'; // user phpMyAdmin (XAMPP)
$password = 'root'; // passwd phpMyAdmin (XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
