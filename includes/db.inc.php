<?php
$host = 'localhost';  
$db_name = 'netsec';
$db_username = 'postgres';
$db_password = 'postgres';

try {
    
    $pdo = new PDO("pgsql:host=$host;dbname=$db_name", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected to PostgreSQL successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}