<?php

declare(strict_types=1);

require_once '../../db.inc.php';

// Get user ID by username
function get_user_id_by_username(PDO $pdo, string $username)
{
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? (int)$result["id"] : null;
}

// Get user's balance
function get_user_balance(PDO $pdo, int $userId)
{
    $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result ? (float)$result["balance"] : null;
}

// Transfer money by username
function transfer_money(PDO $pdo, int $senderId, string $receiverUsername, float $amount, ?string $comment)
{
    try {
        $pdo->beginTransaction();

        // Get receiver ID
        $receiverId = get_user_id_by_username($pdo, $receiverUsername);
        if (!$receiverId) {
            throw new Exception("Recipient not found.");
        }

        // Check sender's balance
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = :senderId");
        $stmt->execute([':senderId' => $senderId]);
        $sender = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$sender || $sender["balance"] < $amount) {
            throw new Exception("Insufficient funds.");
        }

        // Deduct from sender
        $stmt = $pdo->prepare("UPDATE users SET balance = balance - :amount WHERE id = :senderId");
        $stmt->execute([':amount' => $amount, ':senderId' => $senderId]);

        // Add to receiver
        $stmt = $pdo->prepare("UPDATE users SET balance = balance + :amount WHERE id = :receiverId");
        $stmt->execute([':amount' => $amount, ':receiverId' => $receiverId]);

        // Insert transaction record
        $stmt = $pdo->prepare("INSERT INTO transactions (sender_id, receiver_id, amount, comment) 
                              VALUES (:senderId, :receiverId, :amount, :comment)");
        $stmt->execute([
            ':senderId' => $senderId,
            ':receiverId' => $receiverId,
            ':amount' => $amount,
            ':comment' => htmlspecialchars($comment) // Prevent XSS
        ]);

        $pdo->commit();
        return true;
    } 
    catch (Exception $e) 
    {
        $pdo->rollBack();
        $_SESSION["errors_transfer"] = $e->getMessage();
        return false;
    }
}
