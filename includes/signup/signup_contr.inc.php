<?php

declare(strict_types=1);

function is_input_empty(string $username,string $pwd,string $email)
{
        if(empty($username) || empty($pwd) || empty($email))
        {
            return true;
        }
        else
        {
            return false;
        }
}

function is_email_valid(string $email)
{
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
      return true;
    }
    return false;
}

function is_username_taken(object $pdo,string $username): bool
{
   if(get_username($pdo,$username))
   {
    return true;
   } 
   return false;
}

function is_email_taken(object $pdo,string $email): bool
{
   if(get_email($pdo,$email))
   {
    return true;
   } 
   return false;
}

function create_user(object $pdo,string $usrname,string $pwd,string $email)
{
   set_user($pdo, $usrname,$pwd,$email);
}

