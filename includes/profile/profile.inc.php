<?php

require_once '../config_session.inc.php';
require_once '../db.inc.php';
require_once 'profile_model.inc.php';
require_once 'profile_contr.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit();
}

$user = get_user_profile($pdo, $_SESSION["user_id"]);

if (!is_valid_user($user)) {
    die("User not found.");
}

$username = htmlspecialchars($user["username"], ENT_QUOTES, 'UTF-8');
$name = htmlspecialchars($user["name"], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user["email"], ENT_QUOTES, 'UTF-8');
$bio = htmlspecialchars($user["bio"], ENT_QUOTES, 'UTF-8');
$profile_image = $user["profile_image"] ? htmlspecialchars($user["profile_image"]) : null;

require_once 'profile_view.inc.php';
?>
