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

    //used to check if you are looking for a buddy or are a buddy
    $user->setClass($userData['class']);
    $matches = $user->searchMatch();  

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
    <h1>temp buddy request page</h1>
    <h1>temp buddy request page</h1>
    <h1>temp buddy request page</h1>
    <?php include_once('footer.inc.php'); ?>
</body>
</html>