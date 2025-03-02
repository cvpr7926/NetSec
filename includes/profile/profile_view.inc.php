<?php

declare(strict_types=1);

function display_profile(string $username, string $name, string $email, string $bio, ?string $profile_image)
{
    echo "<div class='profile-card'>";
    echo "<div class='profile-header'>";
    echo $profile_image ? "<img class='profile-pic' src='" . htmlspecialchars($profile_image) . "' alt='Profile Image'>" : "<div class='profile-pic default-pic'>?</div>";
    echo "<h2>" . htmlspecialchars($name ?: $username) . "</h2>";
    echo "<p class='email'>" . htmlspecialchars($email) . "</p>";
    echo "</div>";
    
    echo "<div class='profile-content'>";
    echo "<p class='bio'>" . nl2br(htmlspecialchars($bio ?: "No bio available")) . "</p>";
    echo "</div>";
    echo "</div>";
}
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
        <?php display_profile($username, $name, $email, $bio, $profile_image); ?>

        <div class="form-container">
            <h3>Update Profile</h3>
            <form action="profile_update.inc.php" method="post" enctype="multipart/form-data">
                <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Full Name">
                <textarea name="bio" placeholder="Enter your biography"><?= htmlspecialchars($bio) ?></textarea>
                <input type="file" name="profile_image" accept="image/*">
                <button type="submit">Update Profile</button>
            </form>

            <h3>Change Password</h3>
            <form action="profile_update.inc.php" method="post">
                <input type="password" name="current_password" placeholder="Current Password" required>
                <input type="password" name="new_password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                <button type="submit">Change Password</button>
            </form>

            <p><a href="../home/logout.inc.php">Logout</a></p>
        </div>
    </div>
</body>
</html>
