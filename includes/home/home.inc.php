<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo print_r($_SESSION);
   header("Location: ../../index.php");
   exit();
}

echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! <a href='logout.inc.php'>Logout</a>";
?>
