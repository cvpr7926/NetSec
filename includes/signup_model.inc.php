<?php


function get_username(object $pdo,string $username)
{
    $query = "SELECT username FROM users WHERE username= :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username",$username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo,string $username,string $pwd,string $email){

    $query = "INSERT INTO users (username,password_hash,email) VALUES (:username,:password,:email);";
    $stmt = $pdo->prepare($query);
    
    $options = [
        'cost' => 12,
    ];
    $hashedPwd = password_hash($pwd,PASSWORD_BCRYPT,$options);
    $stmt->bindParam(":username",$username);$stmt->bindParam(":password",$hashedPwd);$stmt->bindParam(":email",$email);
    $stmt->execute();


}