<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! <a href='logout.inc.php'>Logout</a>";
?>
