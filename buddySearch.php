<?php  
     include_once(__DIR__ . "/classes/Buddy.php"); 

    session_start();
    if(!isset($_SESSION['user']) ) {
        header("Location: login.php");
    }
    $user = new Buddy();
    $user->setId($_SESSION["id"]);
    $userData = $user->allUserData();

    if($userData['buddySearching'] == false) { // if you somehow got on page while not searching for buddies you get redirected
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
    <title>buddysearch</title>
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- temp while developing feature -->
    <a href="index.php">temp index link</a>
    <?php echo $user->getId(); ?>
    <?php echo $user->getClass(); ?>

    <?php foreach ($matches as $match) :?>
        <?php  
            //echo $user->getId() . " and user " . $match['id'] . " are potential matches <br>";

            $counter = 0;
            //echo $counter . "<br>";
            if($userData['interests'] == $match['interests']) {
                $counter++;
            }
            //echo $counter . "<br>";
            if($userData['hobbies'] == $match['hobbies']) {
                $counter++;
            }
            //echo $counter . "<br>";
            if($userData['beverage'] == $match['beverage']) {
                $counter++;
            }
            //echo $counter . "<br>";
            if($userData['pet'] == $match['pet']) {
                $counter++;
            }
            //echo $counter . "<br>";
        ?>
        <div class="container buddyCard priority<?php echo $counter; ?>">
            <h3><?php echo $match['firstname'] . " " . $match['lastname'] ?></h3>
            <img class="avatar" src="uploads/<?php echo $match["avatar"] ?>" alt="">
         
                <div class="form__field">
					<input type="submit" value="stuur buddy verzoek!" class="btn btn--primary">	
                </div>
                
                <div class="form__field">
					<input type="submit" value="zoek andere buddy!" class="btn btn--primary" onclick="dismiss(this);">	
				</div>
            

        </div>
        
    <?php endforeach; ?>

    <script src="js/dismiss.js"><?php echo "dit is dikke rommel"; ?></script>
</body>
</html>