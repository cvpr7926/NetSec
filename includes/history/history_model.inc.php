<?php

declare(strict_types=1);
require_once '../db.inc.php';

// ✅ Get transaction history for a user
function get_transaction_history(PDO $pdo, int $userId): array 
{
    $stmt = $pdo->prepare("
        SELECT t.id, 
               t.sender_id, 
               t.receiver_id, 
               t.amount, 
               t.comment, 
               t.created_at, 
               u1.username AS sender_name, 
               u2.username AS receiver_name
        FROM transactions t
        JOIN users u1 ON t.sender_id = u1.id
        JOIN users u2 ON t.receiver_id = u2.id
        WHERE t.sender_id = :userId OR t.receiver_id = :userId
        ORDER BY t.created_at DESC
    ");

    $stmt->execute([':userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
