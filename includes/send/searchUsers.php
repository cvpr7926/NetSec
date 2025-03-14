<?php

declare(strict_types=1);
require_once '../db.inc.php'; // Database connection
require_once 'sendMoney_model.inc.php'; // Contains search_users function
require_once '../../logs/logger.inc.php';

header("Content-Type: application/json");
session_start(); // Ensure session is started

$username = $_SESSION["username"] ?? "'Guest'";

if (!isset($_SESSION['search_attempts']) || time() - $_SESSION['search_attempts']['time'] > 60) {
    $_SESSION['search_attempts'] = ['count' => 0, 'time' => time()];
}

$_SESSION['search_attempts']['count']++;

if ($_SESSION['search_attempts']['count'] > 10) {
    logUserActivity($username, "Rate limited after excessive search attempts");
    header("HTTP/1.1 429 Too Many Requests");
    echo json_encode(["error" => "Too many requests. Please try again later."]);
    exit();
}


if (!isset($_GET["query"]) || empty(trim($_GET["query"]))) {
    logUserActivity($username, "Performed a search with an empty query");
    echo json_encode(["message" => "No results found"]);
    exit();
}

$searchTerm = trim($_GET["query"]);

// Sanitize input to prevent XSS and potential PHP execution
$searchTerm = htmlspecialchars(strip_tags($searchTerm), ENT_QUOTES, 'UTF-8');

try {
    $results = search_users($pdo, $searchTerm);
    
    if (empty($results)) {
        logUserActivity($username, "Searched for '$searchTerm' but found no results");
        echo json_encode(["message" => "No results found"]);
    } else {
        $safe_results = array_map(fn($name) => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'), $results);
        logUserActivity($username, "Searched for '$searchTerm' and found " . count($safe_results) . " results");
        echo json_encode($safe_results);

    }
} catch (Exception $e) {
    echo json_encode(["error" => "An error occurred."]); // Prevent exposing detailed errors
}
?>