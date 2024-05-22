<?php

session_start();

$host = '127.0.0.1';
$db = 'casino_db';
$user = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$pdo = new PDO($dsn, $user);

if (isset($_SESSION['loggedInUser'])) {
    $loggedInUserId = $_SESSION['loggedInUser'];
}

$usersQuery = "SELECT * FROM users WHERE id = :id;";
$usersStmt = $pdo->prepare($usersQuery);
$usersStmt->bindParam(':id', $loggedInUserId, PDO::PARAM_INT);

try {
    $usersStmt->execute();
    $user = $usersStmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
