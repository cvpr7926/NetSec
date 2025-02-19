<?php
require_once "includes/config_session.inc.php";
require_once "includes/signup_view.inc.php";
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
    <div class="signup-container">
        <h3>Signup</h3>
        
        <form action="includes/signup.inc.php" method="post">
            <input type="text" name="username" placeholder="Username" >
            <input type="password" name="password" placeholder="Password" >
            <input type="email" name="email" placeholder="E-Mail" >
            <button type="submit">Signup</button>
        </form>

        <?php check_signup_errors(); ?>
    </div>
</body>
</html>

