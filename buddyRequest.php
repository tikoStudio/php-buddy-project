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
            <?php  
                $counter = 0;
                if($match['interests1'] == $match['interests2']) {
                    $counter++;
                    $interests = $match['interests1'];
                }
                if($match['hobbies1'] == $match['hobbies2']) {
                    $counter++;
                    $hobbies = $match['hobbies1'];
                }
                if($match['beverage1'] == $match['beverage2']) {
                    $counter++;
                    $beverage = $match['beverage1'];
                }
                if($match['pet1'] == $match['pet2']) {
                    $counter++;
                    $pet = $match['pet1'];
                }
            ?>
            <div class="container buddyCard priority<?php echo $counter; ?>">
                <h3><?php echo $match['firstname1'] . " " . $match['lastname1'] . " wil buddies worden" ?></h3>
                <img class="avatar" src="uploads/<?php echo $match["avatar1"] ?>" alt="profile picture">
                <?php if(isset($interests)): ?>
                    <?php if($interests == "Both"): ?>
                        <h4><?php echo "Jullie hebben beide interesse in design en development"; ?></h4>
                    <?php else: ?>
                        <h4><?php echo "Jullie hebben beide interesse in " . $interests; ?></h4>
                <?php endif; endif; ?>

                <?php if(isset($hobbies)): ?>
                    <?php if($hobbies == "Tv"): ?>
                        <h4><?php echo "Jullie hebben beide de hobby tv kijken 📺"; ?></h4>
                    <?php elseif($hobbies == "Party"): ?>
                        <h4><?php echo "Jullie houden beide van een feestje 🥳"; ?></h4>
                    <?php else: ?>
                        <h4><?php echo "Jullie houden beide van lang uit te slapen 😴"; ?></h4>
                <?php endif; endif; ?>

                <?php if(isset($beverage)): ?>
                    <?php if($beverage == "Beer"): ?>
                        <h4><?php echo "Jullie houden er beide van om een frisse pint te drinken 🍺"; ?></h4>
                    <?php elseif($beverage == "Coffee"): ?>
                        <h4><?php echo "Jullie houden er beide van een in de ochtend een lekkere kop koffie te drinken ☕"; ?></h4>
                    <?php elseif($beverage == "Soda"): ?>
                        <h4><?php echo "Jullie houden er beide van om een lekker glas frisdrank te drinken 🥤"; ?></h4>
                    <?php else: ?>
                        <h4><?php echo "Jullie houden er beide van om thee te drinken 🍵"; ?></h4>
                <?php endif; endif; ?>
                    
                <?php if(isset($pet)): ?>
                    <?php if($pet == "Bunny"): ?>
                        <h4><?php echo "Jullie houden beide van konijnen 🐇"; ?></h4>
                    <?php elseif($pet == "Cat"): ?>
                        <h4><?php echo "Jullie houden beide van katten 🐈"; ?></h4>
                    <?php elseif($pet == "Dog"): ?>
                        <h4><?php echo "Jullie houden beide van honden 🐕"; ?></h4>
                    <?php elseif($pet == "Horse"): ?>
                        <h4><?php echo "Jullie houden beide van paarden 🐎"; ?></h4>
                    <?php else: ?>
                        <h4><?php echo "Jullie houden beide evenveel van alle dieren 💓"; ?></h4>
                <?php endif; endif; ?>   
                
                <div class="form__field">
                    <input type="submit" value="accepteer buddy!" class="btn btn--primary" id="buddyMatching" data-userId2= <?php echo $match['id2']; ?> data-userId1= <?php echo $match['id1']; ?> onclick="acceptMatch(this);" >	
                </div>
                    
                <div class="form__field">
                    <input type="submit" value="weiger buddy!" class="btn btn--primary">	
                </div>
            </div>
    </div>
    </div>    
    <?php include_once('footer.inc.php'); ?>
    <script src="js/accept.js"></script>
</body>
</html>