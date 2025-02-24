<?php

if($_SERVER["REQUEST_METHOD"]=="POST")
{
        $username = $_POST["username"];
        $pwd = $_POST["password"];

        try
        { 
          require_once '../db.inc.php';
          require_once 'login_model.inc.php';
          require_once 'login_contr.inc.php';
        
          $errors = [];
        //Error handling
        if(is_input_empty($username,$pwd))
        {
          $errors["empty_input"] = "Fill in all the fields";
        }

        $result = get_user($pdo,$username);

        if(is_username_valid($result))
        { 
           $errors["username_invalid"] = "This username doesn't exist";
          
        }
        if(is_pwd_correct($pwd,$result["password_hash"]))
        { 
           $errors["wrong_password"] = "The password is wrong";
        }
        
        require_once '../config_session.inc.php'; //to start session

        if($errors)
        {      
              
               $_SESSION["errors_login"] = $errors;


               header("Location: ../../index.php"); //redirect to login/signup page
               exit();
        }
           $newSessionId = session_create_id();
           $sessionId = $newSessionId ."_". $result["id"]; //make this more secure, unguessabel
           session_id($sessionId);

           $_SESSION["user_id"] = $result["id"];
           $_SESSION["username"] = htmlspecialchars($result["username"]); //XSS attack
           $_SESSION["last_regeneration"] = time();
           error_log("kya hua");
           header("Location: ../home/home.inc.php");
           die();

        } catch(PDOException $e)
        {
             die("Query failed: ".$e->getMessage());
        }
} else 
{
    header("Location: ../../index.php");
    die();
}

