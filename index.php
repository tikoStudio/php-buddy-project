<?php
    namespace src\Buddy;

    spl_autoload_register();

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
    if (!empty($_POST)) {
        $user->setClass($_POST['class']);
        $user->setInterests($_POST['interests']);
        $user->setHobbies($_POST['hobbies']);
        $user->setBeverage($_POST['beverage']);
        $user->setPet($_POST['pet']);
        $userFilter = $user->filterUser();
    
        if ($userFilter == null) {
            $error = "Geen buddy gevonden met deze interesses";
        }
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

    <div class="container">
        <div class="form form--login">
            <form action="" method="post">
                <div class="form__field">
                    <label for="class">Klas</label>
                    <select name="class" id="class">
                        <option value="1IMD">1IMD</option>
                        <option value="2IMD">2IMD</option>
                        <option value="3IMD">3IMD</option>
                    </select>
                </div>

                <div class="form__field">
                    <label for="interests">Interesses</label>
                    <select name="interests" id="interests">
                        <option value="Designing">Designen</option>
                        <option value="Developing">Developen</option>
                        <option value="Both">Beide</option>
                    </select>
                </div>

                <div class="form__field">
                    <label for="hobbies">Hobbies</label>
                    <select name="hobbies" id="hobbies">
                        <option value="Party">party like it's 1969 🥳</option>
                        <option value="Sleeping">slapen 😴</option>
                        <option value="Tv">Tv-series en filmen kijken 📺</option>
                    </select>
                </div>

                <div class="form__field">
                    <label for="beverage">Favoriete drankje tijdens het developen/designen</label>
                    <select name="beverage" id="beverage">
                        <option value="Beer">Bier 🍺</option>
                        <option value="Coffee">Koffie ☕</option>
                        <option value="Soda">Frisdrank 🥤</option>
                        <option value="Tea">Thee 🍵</option>
                    </select>
                </div>

                <div class="form__field">
                    <label for="pet">Favoriete huisdier</label>
                    <select name="pet" id="pet">
                        <option value="Bunny">Konijn 🐇</option>
                        <option value="Cat">Kat 🐈</option>
                        <option value="Dog">Hond 🐕</option>
                        <option value="Horse">Paard 🐎</option>
                        <option value="All">ik hou van ze allemaal even veel 💓</option>
                    </select>
                </div>

                <div>
                    <input type="submit" value="Filteren" class="btn btn--primary">
                </div>
            </form>

            <?php if (isset($error)) {
    echo $error;
} ?>
            <?php if (!empty($_POST)): ?>
            <?php foreach ($userFilter as $u): ?>
            <h2><?php echo htmlspecialchars($u['firstname']) . " " . htmlspecialchars($u['lastname']); ?>
            </h2>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once('footer.inc.php'); ?>
</body>

</html>