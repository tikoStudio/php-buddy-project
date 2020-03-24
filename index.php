<?php  
     include_once(__DIR__ . "/classes/User.php"); 

     $user = new User();
     $user->setId(1); //change to session or cookie instead of hard coded -> $_SESSION['id']; when login is done
     $userData = $user->allUserData();

     if(empty($userData[0]['class']) || empty($userData[0]['interests']) || empty($userData[0]['hobbies']) || empty($userData[0]['beverage']) || empty($userData[0]['pet'])) {
        header('location: profileCompletion.php');
     }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>temp index</h1>
    <a href="profileCompletion.php">complete profile link temp</a>
</body>
</html>