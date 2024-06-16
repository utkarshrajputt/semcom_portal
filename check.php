<?php
$host = 'localhost';
$dbname = 'semcom_db';  // Replace with your database name
$username = 'semcom';  // Replace with your MySQL username
$password = 'semcom';  // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
