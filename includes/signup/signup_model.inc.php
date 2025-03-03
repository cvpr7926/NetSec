<?php


function get_username(object $pdo,string $username)
{
    $query = "SELECT Username FROM Profile WHERE Username= :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username",$username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result; //send only username  return $result ? $result['username'] : null;
}

function get_email(object $pdo,string $email)
{
    $query = "SELECT email FROM Profile WHERE Email= :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email",$email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result; //send only username  return $result ? $result['username'] : null;
}

function set_user(object $pdo,string $username,string $pwd,string $email){

    $query = "INSERT INTO Profile (Username,PasswordHash,Email) VALUES (:username,:password,:email);";
    $stmt = $pdo->prepare($query);
    
    $options = [
        'cost' => 12,
    ];
    $hashedPwd = password_hash($pwd,PASSWORD_BCRYPT,$options);
    $stmt->bindParam(":username",$username);$stmt->bindParam(":password",$hashedPwd);$stmt->bindParam(":email",$email);
    $stmt->execute();


}