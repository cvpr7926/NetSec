<?php

declare(strict_types=1);

require_once 'sendMoney_view.inc.php';
require_once '../../config_session.inc.php';

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
