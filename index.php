<?php
require_once "includes/config_session.inc.php";

if (isset($_SESSION["user_id"])) {
    header("Location: includes/profile/profile.inc.php"); 
    exit();
}

require_once "includes/signup/signup_view.inc.php";
require_once "includes/login/login_view.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container">
    <div class="login-container">
        <h3>Login</h3>
        
        <form action="includes/login/login.inc.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password" >
            <button type="submit">Login</button>
        </form>

        <?php check_login_errors(); ?>
    </div>

    <div class="signup-container">
        <h3>Signup</h3>
        
        <form action="includes/signup/signup.inc.php" method="post">
                <?php signup_inputs(); ?>
            <button type="submit">Signup</button>
        </form>

        <?php check_signup_errors(); ?>
    </div>
</div>
</body>
</html>

