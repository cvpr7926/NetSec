<?php

declare(strict_types=1);

function display_money_transfer_form(): void
{
    ?>
    <form method="POST" action="sendMoney_contr.inc.php">

        <label for="username">Recipient Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="amount">Amount:</label>
        <input type="number" step="0.01" name="amount" id="amount" required>
        
        <label for="comment">Comment (Optional):</label>
        <textarea name="comment" id="comment"></textarea>
        
        <button type="submit" name="transfer">Send Money</button>
        
    </form>

    <?php
    if (isset($_SESSION["errors_transfer"])) {
        echo '<p style="color: red;">' . htmlspecialchars($_SESSION["errors_transfer"]) . '</p>';
        unset($_SESSION["errors_transfer"]);
    }
    if (isset($_SESSION["transfer_success"])) {
        echo '<p style="color: green;">' . htmlspecialchars($_SESSION["transfer_success"]) . '</p>';
        unset($_SESSION["transfer_success"]);
    }
}
?>
