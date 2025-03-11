<?php
declare(strict_types=1);
require_once '../config_session.inc.php';
require_once '../db.inc.php';
require_once 'profile_model.inc.php';
require_once 'profile_contr.inc.php';
require_once '../Navbar/navbar.php';

if (!isset($_GET["user_id"]) || !is_numeric($_GET["user_id"])) {
    die("Invalid user ID.");
}

$user_id = (int) $_GET["user_id"];
$user = get_user_profile($pdo, $user_id);

if (!$user) {
    die("User not found.");
}
$username = htmlspecialchars($user["username"], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user["email"], ENT_QUOTES, 'UTF-8');
$bio = htmlspecialchars($user["biography"] ?? "No bio available", ENT_QUOTES, 'UTF-8');
$profile_image = $user["profileimagepath"] ? htmlspecialchars($user["profileimagepath"]) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $username ?>'s Profile</title>
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <div class="profile-card">
                <?php if ($profile_image): ?>
                    <img class="profile-pic" src="<?= $profile_image; ?>" alt="Profile Image">
                <?php else: ?>
                    <div class="profile-pic default-pic">?</div>
                <?php endif; ?>

                <h2><?= $username; ?></h2>
                <p><?= $email; ?></p>
                <p><strong>Bio:</strong> <?= nl2br($bio); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
