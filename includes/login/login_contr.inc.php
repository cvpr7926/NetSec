<?php

declare(strict_types=1);

function is_input_empty(string $username,string $pwd)
{
        if(empty($username) || empty($pwd))
        {
            return true;
        }
        else
        {
            return false;
        }
}



function is_username_invalid($result): bool
{
   if(!$result)
   {
    return true;
   }
   return false;
   
}
function is_pwd_correct(string $pwd,string $hashed_pwd): bool
{

    if (password_verify($pwd, $hashed_pwd)) {
        return true;
    }
    return false;
}




