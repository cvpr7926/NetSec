<?php

declare(strict_types=1);
require_once '../config_session.inc.php';
require_once '../db.inc.php';
require_once 'profile_model.inc.php';

$user_id = $_SESSION["user_id"];
$user = get_user_profile($pdo, $user_id);

$username = $user["username"] ?? "";
$email = $user["email"] ?? "";
$bio = $user["biography"] ?? "";
$profile_image = $user["profileimagepath"] ?? null;

?>

<div class="profile-container">
    <div class="profile-card">
        <?php if ($profile_image): ?>
            <img class="profile-pic" src="<?= htmlspecialchars($profile_image); ?>" alt="Profile Image">
        <?php else: ?>
            <div class="profile-pic default-pic">?</div>
        <?php endif; ?>

        <h2><?= htmlspecialchars($username); ?></h2>
        <p><?= htmlspecialchars($email); ?></p>

        <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($bio ?: "No bio available")); ?></p>
    </div>
</div>



