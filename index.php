<?php
    include_once(__DIR__ . "/classes/Buddy.php");

    session_start();
    $email = $_SESSION["user"];
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    $user = new Buddy();
    $user->setId($_SESSION["id"]);
    $userData = $user->allUserData();
    $pendingMatch = $user->pendingMatch();
    $countUsers = $user->countUsers();
    $countBuddies = $user->countBuddies();

    if (empty($userData['class']) || empty($userData['interests']) || empty($userData['hobbies']) || empty($userData['beverage']) || empty($userData['pet'])) {
        header('location: profileCompletion.php');
    } elseif ($userData['buddySearching']) {
        header('location: buddySearch.php');
    } elseif (!empty($pendingMatch) && $pendingMatch['userId2'] == $user->getId()) {
        header('location: buddyRequest.php');
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepagina</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include_once('nav.inc.php'); ?>
    <div class="index__data">
        <?php foreach ($countUsers as $countUser): ?>
        <h2>Er zijn <span class="blue"> <?php echo $countUser['COUNT(*)']; ?>
                student(en)</span> geregistreerd</h2>
        <?php endforeach; ?>
        <?php foreach ($countBuddies as $countBuddy): ?>
        <h2>Er zijn al <span class="blue"> <?php echo $countBuddy['COUNT(*)']; ?>
                buddymatch(es)</span> gebeurd</h2>
        <?php endforeach; ?>
    </div>

    <?php include_once('footer.inc.php'); ?>
</body>

</html>