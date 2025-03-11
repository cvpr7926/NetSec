<?php

declare(strict_types=1);
require_once '../db.inc.php'; // Database connection
require_once 'sendMoney_model.inc.php'; // Contains search_users function

header("Content-Type: application/json");
session_start(); // Ensure session is started

// Implement basic rate-limiting to prevent brute-force
if (!isset($_SESSION['search_attempts'])) {
    $_SESSION['search_attempts'] = 0;
}

$_SESSION['search_attempts']++;

if ($_SESSION['search_attempts'] > 10) {
    header("HTTP/1.1 429 Too Many Requests");
    echo json_encode(["error" => "Too many requests. Please try again later."]);
    exit();
}

if (!isset($_GET["query"]) || empty(trim($_GET["query"]))) {
    echo json_encode(["No results found"]); // Generic message to prevent enumeration
    exit();
}

$searchTerm = trim($_GET["query"]);

if (mb_strlen($searchTerm, 'UTF-8') > $maxLength) {
    echo json_encode(["error" => "Input too long."]);
    exit();
}

// Allow only alphanumeric characters and spaces (adjust regex if needed)
$searchTerm = preg_replace('/[^a-zA-Z0-9\s]/', '', $searchTerm);

// Ensure it's still not empty after sanitization
if (empty($searchTerm)) {
    echo json_encode(["No results found"]);
    exit();
}

try {
    $results = search_users($pdo, $searchTerm);
    
    if (empty($results)) {
        echo json_encode(["No results found"]); // Generic message
    } else {
        echo json_encode($results);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "An error occurred."]); // Prevent exposing detailed errors
}
?>
