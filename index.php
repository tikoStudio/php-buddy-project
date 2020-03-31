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
    $user->setClass($class);
    $userFilter = $user->filterUser();

    if(empty($userData['class']) || empty($userData['interests']) || empty($userData['hobbies']) || empty($userData['beverage']) || empty($userData['pet'])) {
    header('location: profileCompletion.php');
    }

    if($_POST['class'] == '2IMD') {
        $user->filterUser();
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
        <option <?php if(isset($interests) && $interests === "Designing") { echo "selected";}?> value="Designing">Designen</option>
        <option <?php if(isset($interests) && $interests === "Developing") { echo "selected";}?> value="Developing">Developen</option>
        <option <?php if(isset($interests) && $interests === "Both") { echo "selected";}?> value="Both">Beide</option>
    </select>
    </div>

    <div class="form__field">
	<label for="hobbies">Hobbies</label>
    <select name="hobbies" id="hobbies">
        <option <?php if(isset($hobbies) && $hobbies === "Party") { echo "selected";}?> value="Party">party like it's 1969 🥳</option>
        <option <?php if(isset($hobbies) && $hobbies === "Sleeping") { echo "selected";}?> value="Sleeping">slapen 😴</option>
        <option <?php if(isset($hobbies) && $hobbies === "Tv") { echo "selected";}?> value="Tv">Tv-series en filmen kijken 📺</option>
    </select>
    </div>

    <div class="form__field">
	<label for="beverage">Favoriete drankje tijdens het developen/designen</label>
    <select name="beverage" id="beverage">
        <option <?php if(isset($beverage) && $beverage === "Beer") { echo "selected";}?> value="Beer">Bier 🍺</option>
        <option <?php if(isset($beverage) && $beverage === "Coffee") { echo "selected";}?> value="Coffee">Koffie ☕</option>
        <option <?php if(isset($beverage) && $beverage === "Soda") { echo "selected";}?> value="Soda">Frisdrank 🥤</option>
        <option <?php if(isset($beverage) && $beverage === "Tea") { echo "selected";}?> value="Tea">Thee 🍵</option>
    </select>
    </div>

    <div class="form__field">
	<label for="pet">Favoriete huisdier</label>
    <select name="pet" id="pet">
        <option <?php if(isset($pet) && $pet === "Bunny") { echo "selected";}?> value="Bunny">Konijn 🐇</option>
        <option <?php if(isset($pet) && $pet === "Cat") { echo "selected";}?> value="Cat">Kat 🐈</option>
        <option <?php if(isset($pet) && $pet === "Dog") { echo "selected";}?> value="Dog">Hond 🐕</option>
        <option <?php if(isset($pet) && $pet === "Horse") { echo "selected";}?> value="Horse">Paard 🐎</option>
        <option <?php if(isset($pet) && $pet === "All") { echo "selected";}?> value="All">ik hou van ze allemaal even veel 💓</option>
    </select>
    </div>

    <div>
		<input type="submit" value="Filteren" class="btn btn--primary">	
	</div>
    </form>

    <?php foreach($userFilter as $u): ?>
        <h2><?php echo $u['firstname'] . " " . $u['lastname']; ?></h2>
    <?php endforeach; ?>
</body>
</html>