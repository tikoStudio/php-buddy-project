<?php 
    include_once(__DIR__ . "/classes/User.php");

    session_start();
    $email = $_SESSION["user"];
    $user = new User();
    $idArray = $user->idFromSession($email);
    $id = $idArray[0]['id'];
    $user->setId($id);

    $userData = $user->allUserData();

    if(empty($userData[0]['class']) || empty($userData[0]['interests']) || empty($userData[0]['hobbies']) || empty($userData[0]['beverage']) || empty($userData[0]['pet'])) {
    header('location: profileCompletion.php');
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepagina</title>
</head>
<body>
</body>
</html>