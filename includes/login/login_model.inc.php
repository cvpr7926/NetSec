<?php


function get_user(object $pdo,string $username)
{
    $query = "SELECT id,username,password_hash FROM users WHERE username= :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username",$username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result; //send only username  return $result ? $result['username'] : null;
}

