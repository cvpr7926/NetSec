<?php

if($_SERVER["REQUEST_METHOD"]=="POST")
{
        $username = $_POST["username"];
        $pwd = $_POST["password"];
        $email = $_POST["email"];
        try
        { 
          require_once 'db.inc.php';
          require_once 'signup_model.inc.php';
          require_once 'signup_contr.inc.php';
        
          $errors = [];
        //Error handling
        if(is_input_empty($username,$pwd,$email))
        {
          $errors["empty_input"] = "Fill in all the fields";
        }
        if(is_email_valid($email))
        {
          $errors["invalid_email"] = "Enter a valid email address";
        }
        // if(is_username_taken($pdo,$username))
        // { 
        //    $error["username_exists"] = "This username is taken";
        // }
        
        if($errors)
        {      
               require_once 'config_session.inc.php'; //to start session
               $_SESSION["errors_signup"] = $errors;
               //echo "came here";
             
               header("Location: ../index.php");
               exit();
        }
           create_user($pdo,$username,$pwd,$email);
           header("Location: ../index.php?signup=success");
           exit();

        } catch(PDOException $e)
        {
             die("Query failed: ".$e->getMessage());
        }
} else 
{
    header("Location: ../index.php");
    die();
}

