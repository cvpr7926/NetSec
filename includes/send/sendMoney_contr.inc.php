<?php

declare(strict_types=1);

require_once '../db.inc.php';
require_once 'sendMoney_model.inc.php';
require_once '../config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["transfer"])) 
{
    if (!isset($_SESSION["user_id"])) 
    {
        $_SESSION["errors_transfer"] = "You must be logged in.";
        header("Location: ../../index.inc.php");
        exit();
    }    

    $receiverUsername = trim($_POST["username"]);
    $amount = (float)$_POST["amount"];
    $comment = $_POST["comment"] ?? "";

    if (empty($receiverUsername) || $amount <= 0) 
    {
        $_SESSION["errors_transfer"] = "Please enter a valid username and amount.";
        header("Location: sendMoney.inc.php");
        exit();
    }

    $senderId = $_SESSION["user_id"];
    
    if (transfer_money($pdo, $senderId, $receiverUsername, $amount, $comment)) {
        $_SESSION["transfer_success"] = "Transfer successful!";
        
    } else {
        $_SESSION["errors_transfer"] = "Transfer failed: " . ($_SESSION["errors_transfer"] ?? "Unknown error.");
    }

    header("Location: sendMoney.inc.php");
    exit();
}
else 
{
    header("Location: ../../index.php");
    die();
}
