<?php  
     include_once(__DIR__ . "/classes/Buddy.php"); 

    session_start();
    if(!isset($_SESSION['user']) ) {
        header("Location: login.php");
    }
    $user = new Buddy();
    $user->setId($_SESSION["id"]);
    $userData = $user->allUserData();
    $pendingMatch = $user->pendingMatch();

    if(empty($pendingMatch)) {
        header('location: index.php');
    }

    $pendingMatch = $user->pendingMatch();
    $match = $user->searchPendingMatch($pendingMatch);  
    var_dump($match);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <title>Buddy verzoek!</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>

    <div class="form form--login">
    <div class="container__buddyCard">
    <div class="container buddyCard">
        <h3><?php echo $match['firstname1'] . " " . $match['lastname1'] . " wil buddies worden!"?></h3>
    </div>
    </div>
    </div>


    <?php include_once('footer.inc.php'); ?>
</body>
</html>