<?php

session_start();

if(isset($_SESSION["user_id"]))
{
    if(!isset($_SESSION["last_regeneration"]))
    {
        regenerate_session_id_loggedin();
    } else 
    {
        $interval = 60*30;
        if(time()- $_SESSION["last_regeneration"] >= $interval)
        {
            regenerate_session_id_loggedin();
        }
    }

} else {
        if(!isset($_SESSION["last_regeneration"]))
        {
            regenerate_session_id();
        } else 
        {
            $interval = 60*30;
            if(time()- $_SESSION["last_regeneration"] >= $interval)
            {
                regenerate_session_id();
            }
        }
}


function regenerate_session_id()
{
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id_loggedin()
{
    $newSessionId = session_create_id();
    $sessionId = $newSessionId ."_". $_SESSION["user_id"]; //make this more secure, unguessabel
    session_id($sessionId);
    $_SESSION["last_regeneration"] = time();
}