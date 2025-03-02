<?php

function get_user_profile(object $pdo, int $user_id)
{
    $query = "SELECT id, username, name, email, bio, profile_image FROM users WHERE id = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_user_profile(object $pdo, int $user_id, ?string $name, ?string $bio)
{
    $updates = [];
    $params = [':user_id' => $user_id];

    if (!empty($name)) {
        $updates[] = "name = :name";
        $params[':name'] = $name;
    }
    if (!empty($bio)) {
        $updates[] = "bio = :bio";
        $params[':bio'] = $bio;
    }

    if (empty($updates)) {
        return true; // Nothing to update, but still a success
    }

    $query = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    
    return $stmt->execute($params);
}

function update_user_password(object $pdo, int $user_id, string $new_password)
{
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    $query = "UPDATE users SET password_hash = :password WHERE id = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function update_profile_image(object $pdo, int $user_id, string $file_path)
{
    $query = "UPDATE users SET profile_image = :file_path WHERE id = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":file_path", $file_path, PDO::PARAM_STR);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>
