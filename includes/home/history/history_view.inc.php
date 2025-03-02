<?php

declare(strict_types=1);

function display_transaction_history(array $transactions, int $userId): void 
{
    echo "<h2>Transaction History</h2>";
    
    if (empty($transactions)) {
        echo "<p>No transactions found.</p>";
        return;
    }

    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>Transaction ID</th>
            <th>Sender</th>
            <th>Receiver</th>
            <th>Amount</th>
            <th>Comment</th>
            <th>Date</th>
            <th>Status</th>
          </tr>";

    foreach ($transactions as $transaction) {
        
        $isSender = $transaction["sender_id"] == $userId;
        $status = $isSender ? "<span style='color: red;'>Sent</span>" : "<span style='color: green;'>Received</span>";
        
        echo "<tr>
                <td>{$transaction['id']}</td>
                <td>{$transaction['sender_name']}</td>
                <td>{$transaction['receiver_name']}</td>
                <td>\${$transaction['amount']}</td>
                <td>" . htmlspecialchars($transaction['comment']) . "</td>
                <td>{$transaction['created_at']}</td>
                <td>$status</td>
              </tr>";
    }

    echo "</table>";
}
