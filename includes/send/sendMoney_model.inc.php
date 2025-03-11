<?php

declare(strict_types=1);
require_once '../db.inc.php';

// Get user ID by username
function get_user_id_by_username(PDO $pdo, string $Username): ?int
{
    $stmt = $pdo->prepare("SELECT ID FROM Profile WHERE Username = :Username");
    $stmt->execute([':Username' => $Username]);

    return ($id = $stmt->fetchColumn()) ? (int) $id : null;
}

// Search users by username (case-insensitive search)
function search_users(PDO $pdo, string $searchTerm): array
{

    if (strlen($searchTerm) < 2) {
        return []; // Return empty array instead of top 5 users
    }

    $stmt = $pdo->prepare("SELECT Username FROM Profile WHERE LOWER(Username) LIKE LOWER(:searchTerm) LIMIT 5");
    $searchTerm = $searchTerm . '%'; // Append '%' before binding to parameter
    $stmt->execute([':searchTerm' => $searchTerm]);
    
    
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}


// Transfer money between users
function transfer_money(PDO $pdo, int $senderId, string $receiverUsername, float $amount, ?string $comment): bool
{
    try {
        $pdo->beginTransaction();

        // Get receiver ID
        $receiverId = get_user_id_by_username($pdo, $receiverUsername);
        if (!$receiverId) {
            throw new Exception("Recipient not found.");
        }

        // Get sender's balance
        $stmt = $pdo->prepare("SELECT Balance FROM Balance WHERE ID = :senderId");
        $stmt->execute([':senderId' => $senderId]);
        $sender = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sender || $sender["balance"] < $amount) {
            throw new Exception("Insufficient funds. " . $sender ); 
        }

        // Deduct from sender
        $stmt = $pdo->prepare("UPDATE Balance SET Balance = Balance - :amount WHERE ID = :senderId");
        $stmt->execute([':amount' => $amount, ':senderId' => $senderId]);

        // Add to receiver
        $stmt = $pdo->prepare("UPDATE Balance SET Balance = Balance + :amount WHERE ID = :receiverId");
        $stmt->execute([':amount' => $amount, ':receiverId' => $receiverId]);

        // Insert transaction record
        $stmt = $pdo->prepare("INSERT INTO Transactions (SenderID, ReceiverID, Amount, Comment) 
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
