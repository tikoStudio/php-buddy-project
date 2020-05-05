<?php
    include_once(__DIR__ . "/classes/Buddy.php");

    if (!empty($_GET['u'])) {
        $user = new Buddy();
        $user->setActivationToken($_GET['u']);
        $result = $user->activateAccount();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Account activatie</title>
</head>

<body>
    <div class="container">
        <div class="form form--login center">
            <?php if ($_GET['u'] == $result['activationToken']): ?>
            <h1>
                <?php echo "Account geactiveerd:"; ?>
            </h1>
            <p><a href="login.php" class="a__activate">klik hier</a> om in te loggen!</p>
            <?php else: ?>
            <h1>
                <?php echo "Account niet gevonden"; ?>
            </h1>
            <p><a href="register.php" class="a__activate">klik hier</a> om een account aan te maken!</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>