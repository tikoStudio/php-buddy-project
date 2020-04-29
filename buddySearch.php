<?php
     include_once(__DIR__ . "/classes/Buddy.php");

    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }
    $user = new Buddy();
    $user->setId($_SESSION["id"]);
    $userData = $user->allUserData();

    if ($userData['buddySearching'] == false) { // if you somehow got on page while not searching for buddies you get redirected
        header('location: index.php');
    }

    //used to check if you are looking for a buddy or are a buddy
    $user->setClass($userData['class']);
    $matches = $user->searchMatch();

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
    <title>buddysearch</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include_once('nav.inc.php'); ?>

    <div class="container filter">
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
            <div class="buddyConfirm">
                <h1>request verzonden!</h1>
                <a href="index.php" class="a__activate">home</a>
            </div>
            <h2><?php echo htmlspecialchars($u['firstname']) . " " . htmlspecialchars($u['lastname']); ?></h2>
            <img class="avatar" src="uploads/<?php echo $u['avatar']; ?>">
            <div class="form__field">
                    <input type="submit" value="stuur buddy verzoek!" class="btn btn--primary" id="buddyMatching"
                        data-userId2=<?php echo $u['id']; ?>
                    data-userId1 = <?php echo $_SESSION['id'] ?>
                    onclick="request(this)">
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="form form--login">
        <div class="container__buddyCard">
            <?php foreach ($matches as $match) :?>
            <?php
                $counter = 0;
                if ($userData['interests'] == $match['interests']) {
                    $counter++;
                    $interests = htmlspecialchars($userData['interests']);
                }
                if ($userData['hobbies'] == $match['hobbies']) {
                    $counter++;
                    $hobbies = htmlspecialchars($userData['hobbies']);
                }
                if ($userData['beverage'] == $match['beverage']) {
                    $counter++;
                    $beverage = htmlspecialchars($userData['beverage']);
                }
                if ($userData['pet'] == $match['pet']) {
                    $counter++;
                    $pet = htmlspecialchars($userData['pet']);
                }
            ?>
            <div
                class="container buddyCard priority<?php echo $counter; ?>">
                <h3><?php echo htmlspecialchars($match['firstname']) . " " . htmlspecialchars($match['lastname']) ?>
                </h3>
                <img class="avatar"
                    src="uploads/<?php echo htmlspecialchars($match["avatar"]) ?>"
                    alt="">
                <?php if (isset($interests)): ?>
                <?php if ($interests == "Both"): ?>
                <h4><?php echo "Jullie hebben beide interesse in design en development"; ?>
                </h4>
                <?php else: ?>
                <h4><?php echo "Jullie hebben beide interesse in " . $interests; ?>
                </h4>
                <?php endif; endif; ?>

                <?php if (isset($hobbies)): ?>
                <?php if ($hobbies == "Tv"): ?>
                <h4><?php echo "Jullie hebben beide de hobby tv kijken 📺"; ?>
                </h4>
                <?php elseif ($hobbies == "Party"): ?>
                <h4><?php echo "Jullie houden beide van een feestje 🥳"; ?>
                </h4>
                <?php else: ?>
                <h4><?php echo "Jullie houden beide van lang uit te slapen 😴"; ?>
                </h4>
                <?php endif; endif; ?>

                <?php if (isset($beverage)): ?>
                <?php if ($beverage == "Beer"): ?>
                <h4><?php echo "Jullie houden er beide van om een frisse pint te drinken 🍺"; ?>
                </h4>
                <?php elseif ($beverage == "Coffee"): ?>
                <h4><?php echo "Jullie houden er beide van een in de ochtend een lekkere kop koffie te drinken ☕"; ?>
                </h4>
                <?php elseif ($beverage == "Soda"): ?>
                <h4><?php echo "Jullie houden er beide van om een lekker glas frisdrank te drinken 🥤"; ?>
                </h4>
                <?php else: ?>
                <h4><?php echo "Jullie houden er beide van om thee te drinken 🍵"; ?>
                </h4>
                <?php endif; endif; ?>

                <?php if (isset($pet)): ?>
                <?php if ($pet == "Bunny"): ?>
                <h4><?php echo "Jullie houden beide van konijnen 🐇"; ?>
                </h4>
                <?php elseif ($pet == "Cat"): ?>
                <h4><?php echo "Jullie houden beide van katten 🐈"; ?>
                </h4>
                <?php elseif ($pet == "Dog"): ?>
                <h4><?php echo "Jullie houden beide van honden 🐕"; ?>
                </h4>
                <?php elseif ($pet == "Horse"): ?>
                <h4><?php echo "Jullie houden beide van paarden 🐎"; ?>
                </h4>
                <?php else: ?>
                <h4><?php echo "Jullie houden beide evenveel van alle dieren 💓"; ?>
                </h4>
                <?php endif; endif; ?>

                <div class="form__field">
                    <input type="submit" value="stuur buddy verzoek!" class="btn btn--primary" id="buddyMatching"
                        data-userId2=<?php echo $match['id']; ?>
                    data-userId1 = <?php echo $_SESSION['id'] ?>
                    onclick="request(this)">
                </div>

                <div class="form__field">
                    <input type="submit" value="zoek andere buddy!" class="btn btn--primary" onclick="dismiss(this);">
                </div>
            </div>
            <?php
                unset($interests);
                unset($hobbies);
                unset($beverage);
                unset($pet);
            ?>
            <?php endforeach; ?>
            <div class="buddyConfirm">
                <h1>request verzonden!</h1>
                <a href="index.php" class="a__activate">home</a>
            </div>
        </div>
    </div>
    <?php include_once('footer.inc.php'); ?>
    <script src="js/request.js"></script>
    <script src="js/dismiss.js"></script>
</body>

</html>