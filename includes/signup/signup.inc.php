<?php

require_once '../../logs/logger.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];

    // Always log as "'Guest'" until signup succeeds
    $logUsername = "'Guest'";

    try {
        require_once '../db.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        $errors = [];

        // Error handling
        if (strlen($username) > 30) { 
            $errors["username_length"] = "Username should be less than 30 characters";
        }

       if (strlen($pwd) > 100) { 
            $errors["password_length"] = "Password length should be less than 20 characters";
        }

        if (strlen($email) > 320) { 
            $errors["email_length"] = "Email length should be less than 320 characters";
        }

        if ($errors) {
            require_once '../config_session.inc.php';
            $_SESSION["errors_signup"] = $errors;

            logUserActivity($logUsername, "Signup failed due to validation errors.");
            header("Location: ../../index.php");
            exit();
        }

        if (is_input_empty($username, $pwd, $email)) {
            $errors["empty_input"] = "Fill in all the fields";
        }

        if (is_email_valid($email)) {
            $errors["invalid_email"] = "Enter a valid email address";
        }

        if (is_username_taken($pdo, $username)) { 
            $errors["username_exists"] = "This username is taken";
        }

        if (is_email_taken($pdo, $email)) { 
            $errors["email_exists"] = "This email is already registered";
        }

        if ($errors) {      
            require_once '../config_session.inc.php';
            $_SESSION["errors_signup"] = $errors;

            $signup_data = [
                "username" => $username,
                "email" => $email
            ];
            $_SESSION["signup_data"] = $signup_data;

            logUserActivity($logUsername, "Signup failed: " . implode(", ", array_keys($errors)));
            header("Location: ../../index.php");
            exit();
        }
          
        // should sanitise usernname, before storing, email is already sannitise? doubt
        require_once '../contr_utils.inc.php';
        $username =  sanitize_input($username);
        create_user($pdo,$username,$pwd,$email);
        logUserActivity(htmlspecialchars($username), "Successfully signed up");

        header("Location: ../../index.php?signup=success");
        exit();

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        logUserActivity($logUsername, "Signup attempt failed due to database error.");
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../index.php");
    die();
}
