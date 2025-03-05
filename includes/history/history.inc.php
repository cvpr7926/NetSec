<?php

declare(strict_types=1);
require_once '../config_session.inc.php';
require_once 'history_view.inc.php'; //
require_once 'history_contr.inc.php'; //
$user_id = $_SESSION['user_id'] ?? null;
require_once '../Navbar/navbar.php';


if(!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    die();
} 


// ✅ Get transaction history from Controller
$transactions = get_user_transactions();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Transfer</title>
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>

    <!-- <h1>Transfer Money</h1> -->
    <?php  display_transaction_history($transactions, $_SESSION["user_id"]) ?> ;

</body>
</html>
