<?php

declare(strict_types=1);

function display_transaction_history(array $transactions, int $userId): void 
{
    if (empty($transactions)) {
        echo "<p>No transactions found.</p>";
        return;
    }

    echo "<table border='1' cellpadding='10'>" ;

    echo "<tr>
            <th>Sender</th>
            <th>Receiver</th>
            <th>Amount</th>
            <th>Comment</th>
            <th>Date</th>
            <th>Status</th>
          </tr>";

    foreach ($transactions as $transaction) 
    {
        $isSender = $transaction["senderid"] == $userId;
        $status = $isSender ? "<span style='color: red;'>Sent</span>" : "<span style='color: green;'>Received</span>";

        echo "<tr>
                <td>{$transaction['sendername']}</td>
                <td>{$transaction['receivername']}</td>
                <td>{$transaction['amount']}</td>
                <td>" . htmlspecialchars($transaction['comment']) . "</td>
                <td>{$transaction['createdat']}</td>
                <td>$status</td>
              </tr>";
    }

    echo "</table>";
}
