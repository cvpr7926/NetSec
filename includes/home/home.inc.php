<?php
session_start();
require_once '../../logs/logger.inc.php';
if (!isset($_SESSION['user_id'])) {
    logUserActivity("'Guest'", "Unauthorized access attempt to Home Page");
    echo print_r($_SESSION);
   header("Location: ../../index.php");
   exit();
}

echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! <a href='logout.inc.php'>Logout</a>" . "! <a href='send/sendMoney.inc.php'>sendMoney</a>" ;
echo "! <a href='history/history.inc.php'>View History</a>"
?>
