<?php
    namespace src\Buddy;

    spl_autoload_register();

    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    $user = new Buddy();
    $userFriends = $user->searchFriends();

    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Vriendenlijst</title>
</head>

<body>
    <?php include_once('nav.inc.php'); ?>

    <div class="form form--login friends__list">
        <h1 class="center">Alle IMD Buddies!</h1>

        <?php if (isset($error)) {
    echo $error;
} ?>
        <div class="friends">
        <?php foreach ($userFriends as $u): ?>
        <div class="card-friend1">
        <h2><span class="blue"><?php echo " " . htmlspecialchars($u['firstname1']) . " " . htmlspecialchars($u['lastname1'])?></h2>
        <img class="friend-image" src="uploads/<?php echo $u['avatar1']; ?>"></span>
        </div>
        <h2 class="friend-with">+</h2>
        <div class="card-friend2">
        <h2><span class="blue"><?php echo " " . htmlspecialchars($u['firstname2']) . " " . htmlspecialchars($u['lastname2']);?></span></h2>
        <img class="friend-image" src="uploads/<?php echo $u['avatar2']; ?>">
        </div>
        <?php endforeach; ?>
        </div>
    </div>

    <?php include_once('footer.inc.php'); ?>
</body>

</html>