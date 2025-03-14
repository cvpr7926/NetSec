<?php

require_once '../../logs/logger.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    $logUsername = "'Guest'";

    try {
        require_once '../db.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        $errors = [];

        if (strlen($username) > 50) { 
            $errors["username_length"] = "Username should be less than 50 characters";
        }

        if (strlen($pwd) > 100) { 
            $errors["password_length"] = "Password length should be less than 100 characters";
        }

        require_once '../config_session.inc.php';
        if ($errors) {      
            $_SESSION["errors_login"] = $errors;
            logUserActivity($logUsername, "Login failed due to validation errors.");
            header("Location: ../../index.php");
            exit();
        }

        if (is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all the fields";
        }

        //sanitise username because the sanitized version was stored
        require_once '../contr_utils.inc.php';
        $username =  sanitize_input($username);
        $result = get_user($pdo, $username);


        if (is_username_invalid($result)) { 
            $errors["username_invalid"] = "This username doesn't exist";
        } else {
            $logUsername = htmlspecialchars($result["username"]);
        }

        if (!is_username_invalid($result) && !is_pwd_correct($pwd, $result["passwordhash"])) { 
            $errors["wrong_password"] = "The password is wrong";
        }

        require_once '../config_session.inc.php'; // To start session

        if ($errors) {      
            $_SESSION["errors_login"] = $errors;
            logUserActivity($logUsername, "Login failed: " . implode(", ", array_keys($errors)));
            header("Location: ../../index.php");
            exit();
        }

        // Successful login
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"]; // Make this more secure
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["username"] = $logUsername; // Already sanitized
        $_SESSION["last_regeneration"] = time();

        logUserActivity($logUsername, "Successfully logged in");

        header("Location: ../profile/profile.inc.php");
        die();
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        logUserActivity($logUsername, "Login attempt failed due to database error.");
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../index.php");
    die();
}
