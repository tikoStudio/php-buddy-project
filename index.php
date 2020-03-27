<?php 
    include_once(__DIR__ . "/classes/User.php");

    session_start();
    $email = $_SESSION["user"];
    if(!isset($_SESSION['user']) ) {
      header("Location: login.php");
    }
    $user = new User();
    $user->setId($_SESSION["id"]);
    $userData = $user->allUserData();

    if(empty($userData['class']) || empty($userData['interests']) || empty($userData['hobbies']) || empty($userData['beverage']) || empty($userData['pet'])) {
    header('location: profileCompletion.php');
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepagina</title>
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a href="logout.php">log out!</a>
</body>
</html>