<?php
    include_once(__DIR__ . "/classes/Buddy.php"); 

    session_start();
    if(!isset($_SESSION['user']) ) {
        header("Location: login.php");
    }


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
    <a href="logout.php">log out!</a>
    <a href="profileEdit.php">temp edit profile</a>
    <a href="friends.php">friends</a>
</body>
</html>