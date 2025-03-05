<?php

declare(strict_types=1);
require_once '../db.inc.php'; // Database connection
require_once 'sendMoney_model.inc.php'; // Contains search_users function

header("Content-Type: application/json");

if (!isset($_GET["query"])) {
    echo json_encode([]);
    exit;
}

$searchTerm = trim($_GET["query"]);

try 
{
    $results = search_users($pdo, $searchTerm);
    echo json_encode($results);

} catch (Exception $e) 
{
    echo json_encode([]);
}
