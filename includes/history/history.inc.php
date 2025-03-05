<?php

declare(strict_types=1);
require_once '../config_session.inc.php';
require_once 'history_view.inc.php'; //
require_once '../Navbar/navbar.php';


if(!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    die();
} 

require_once 'history_contr.inc.php'; // 

// ✅ Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit();
}

// ✅ Get transaction history from Controller
$transactions = get_user_transactions();

// ✅ Load View to display transactions
display_transaction_history($transactions, $_SESSION["user_id"]);

?>
