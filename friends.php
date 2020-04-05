<?php
    include_once(__DIR__ . "/classes/Buddy.php"); 

    session_start();
    if(!isset($_SESSION['user']) ) {
        header("Location: login.php");
    }
    $user = new Buddy();
    $userFriends = $user->searchFriends();

    

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <title>Friends</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?> 

    <div class="form form--login friends__list">
        <h1 class="center">Vriendenlijst</h1>

        <?php if(isset($error)) { echo $error;} ?>
        <?php foreach($userFriends as $u): ?>
            <h2><?php echo $u['firstname1'] . " " . $u['lastname1'] . " is bevriend met "  . $u['firstname2'] . " " . $u['lastname2'];?></h2>
        <?php endforeach; ?>
    </div>
    
    <?php include_once('footer.inc.php'); ?>
</body>
</html>