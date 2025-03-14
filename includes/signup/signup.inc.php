<?php

if($_SERVER["REQUEST_METHOD"]=="POST")
{
        $username = $_POST["username"];
        $pwd = $_POST["password"];
        $email = $_POST["email"];
        try
        { 
          require_once '../db.inc.php';
          require_once 'signup_model.inc.php';
          require_once 'signup_contr.inc.php';
        
          $errors = [];
        //Error handling
        if (strlen($username) > 30) { 
          $errors["username_length"] = "Username should be less than 30 characters";
       }

       if (strlen($pwd) > 20) { 
            $errors["password_length"] = "Password length should be less than 20 characters";
        }

        if (strlen($email) > 30) { 
          $errors["Email_length"] = "Email length should be less than 30 characters";
        }
        if($errors)
        {      
               require_once '../config_session.inc.php'; //to start session
               $_SESSION["errors_signup"] = $errors;
               //echo "came here";

               header("Location: ../../index.php"); //redirect to signup page
               exit();
        }
        if(is_input_empty($username,$pwd,$email))
        {
          $errors["empty_input"] = "Fill in all the fields";
        }
        if(is_email_valid($email))
        {
          $errors["invalid_email"] = "Enter a valid email address";
        }
        if(is_username_taken($pdo,$username))
        { 
           $errors["username_exists"] = "This username is taken";
          
        }
        if(is_email_taken($pdo,$email))
        { 
           $errors["email_exists"] = "This email is already registered";
        }
        
        if($errors)
        {      
               require_once '../config_session.inc.php'; //to start session
               $_SESSION["errors_signup"] = $errors;
               //echo "came here";
               
               $signup_data = [
                "username"=>$username,
                "email"=> $email
               ];
               $_SESSION["signup_data"] = $signup_data;

               header("Location: ../../index.php"); //redirect to signup page
               exit();
        }
          
        // should sanitise usernname, before storing, email is already sannitise? doubt
        require_once '../contr_utils.inc.php';
        $username =  sanitize_input($username);
        create_user($pdo,$username,$pwd,$email);
        header("Location: ../../index.php?signup=success");
        exit();

        } catch(PDOException $e)
        {
             die("Query failed: ".$e->getMessage());
        }
} else 
{
    header("Location: ../../index.php");
    die();
}

