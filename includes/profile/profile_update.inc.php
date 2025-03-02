<?php
require_once '../config_session.inc.php';
require_once '../db.inc.php';
require_once 'profile_model.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $bio = trim($_POST["bio"]);

    if (update_user_profile($pdo, $user_id, $name, $bio)) {
        $_SESSION["profile_update_success"] = "Profile updated successfully!";
    } else {
        $_SESSION["profile_update_error"] = "Failed to update profile.";
    }

    // Handle password update
    if (!empty($_POST["current_password"]) && !empty($_POST["new_password"]) && !empty($_POST["confirm_password"])) {
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        // Fetch current hashed password from DB
        $query = "SELECT password_hash FROM users WHERE id = :user_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current_password, $user["password_hash"])) {
            $_SESSION["profile_update_error"] = "Incorrect current password.";
            header("Location: profile.inc.php");
            exit();
        }

        if ($new_password !== $confirm_password) {
            $_SESSION["profile_update_error"] = "New passwords do not match.";
            header("Location: profile.inc.php");
            exit();
        }

        if (update_user_password($pdo, $user_id, $new_password)) {
            $_SESSION["profile_update_success"] = "Password updated successfully!";
        } else {
            $_SESSION["profile_update_error"] = "Failed to update password.";
        }
    }

    header("Location: profile.inc.php");
    exit();
}

// Handle profile image upload
if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
    $target_dir = "../uploads/";
    $file_extension = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png"];

    if (!in_array($file_extension, $allowed_types)) {
        $_SESSION["profile_update_error"] = "Invalid image type.";
        header("Location: profile.inc.php");
        exit();
    }

    $new_filename = "profile_" . $user_id . "." . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        update_profile_image($pdo, $user_id, $target_file);
        $_SESSION["profile_update_success"] = "Profile image updated!";
    } else {
        $_SESSION["profile_update_error"] = "Failed to upload image.";
    }

    header("Location: profile.inc.php");
    exit();
}
?>
