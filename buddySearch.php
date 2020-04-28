<?php
    namespace src\Buddy;

    spl_autoload_register();

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