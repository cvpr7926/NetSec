<?php

declare(strict_types=1);


require_once '../config_session.inc.php';
require_once 'history_model.inc.php';

// ✅ Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit();
}

// ✅ Fetch transaction history from Model
function get_user_transactions(): array 
{
    global $pdo; // Database connection
    $userId = $_SESSION["user_id"];
    return get_transaction_history($pdo, $userId);
}
