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



function is_username_valid(bool|string $result): bool
{
   if(!$result)
   {
    return true;
   }
   return false;
   
}
function is_pwd_correct(string $pwd,string $hashed_pwd): bool
{
    $options = [
        'cost' => 12,
    ];
    $hashedPwd = password_hash($pwd,PASSWORD_BCRYPT,$options);

    if($hashedPwd==$hashed_pwd) return true;
    return false;
}




