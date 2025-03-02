<?php

declare(strict_types=1);

require_once '../../config_session.inc.php';

if(!isset($_SESSION["user_id"])) {
    header("Location: ../../../index.php");
    die();
} 

require_once 'sendMoney_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Transfer</title>
</head>
<body>

    <h1>Transfer Money</h1>
    <?php display_money_transfer_form(); ?>

</body>
</html>
