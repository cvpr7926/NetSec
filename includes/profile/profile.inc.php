<?php

require_once '../config_session.inc.php';
require_once '../db.inc.php';
require_once 'profile_model.inc.php';
require_once 'profile_contr.inc.php';
require_once '../Navbar/navbar.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit();
}

$user = get_user_profile($pdo, $_SESSION["user_id"]);

if (!is_valid_user($user)) {
    die("User not found.");
}

$username = htmlspecialchars($user["username"], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user["email"], ENT_QUOTES, 'UTF-8');
$bio = htmlspecialchars($user["biography"], ENT_QUOTES, 'UTF-8');
$profile_image = $user["profileimagepath"] ? htmlspecialchars($user["profileimagepath"]) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>
    <div class="container">
        <?php include 'profile_view.inc.php'; ?>

        <div class="form-container">
            <h3>Update Profile</h3>
            <form action="profile_contr.inc.php" method="post" enctype="multipart/form-data">
                <label for="Email">Email:</label>
                <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Enter your name">
                
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" placeholder="Enter your biography"><?= htmlspecialchars($bio) ?></textarea>
                
                <label for="profile_image">Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*">
                
                <button type="submit">Update Profile</button>
            </form>

            <h3>Change Password</h3>
            <form action="profile_contr.inc.php" method="post">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
                
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
                
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                
                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>
</body>
</html>
