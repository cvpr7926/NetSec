<?php

function get_user_profile(object $pdo, int $user_id)
{
    $query = "SELECT ID, Username, Email, Biography, ProfileImagePath FROM Profile WHERE ID = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_user_profile(object $pdo, int $user_id, ?string $email, ?string $bio)
{
    $query = "UPDATE Profile SET ";
    $params = [];

    if (!empty($email)) {
        $query .= "Email = :email, ";
        $params[':email'] = $email;
    }
    if (!empty($bio)) {
        $query .= "Biography = :bio, ";
        $params[':bio'] = $bio;
    }

    if (empty($params)) {
        return false; 
    }

    $query = rtrim($query, ", ") . " WHERE ID = :user_id";
    $params[':user_id'] = $user_id;

    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}

function update_user_password(object $pdo, int $user_id, string $new_password)
{
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    $query = "UPDATE Profile SET PasswordHash = :password WHERE ID = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function update_profile_image(object $pdo, int $user_id, string $file_path)
{
    $query = "UPDATE Profile SET ProfileImagePath = :file_path WHERE ID = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":file_path", $file_path, PDO::PARAM_STR);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>
