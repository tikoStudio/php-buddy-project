<?php 
    include_once(__DIR__ . "/classes/User.php"); 
    include_once("functions.php");
    
    session_start();
    $user = new User();
    $user->setId($_SESSION["id"]);
    $userData = $user->allUserData();

    if(!isset($_SESSION['user']) ) {
        header("Location: login.php");
    }else if(!empty($userData['class']) && !empty($userData['interests']) && !empty($userData['hobbies']) && !empty($userData['beverage']) && !empty($userData['pet'])) {
        header('location: index.php');
    }

    $email = $userData['email'];
    $firstname = $userData['firstname'];
    $lastname = $userData['lastname'];
    $description = $userData['description'];
    $class = $userData['class'];
    $interests = $userData['interests'];
    $hobbies = $userData['hobbies'];
    $beverage = $userData['beverage'];
    $pet = $userData['pet'];
    $image = $userData['avatar'];

    if(!empty($_POST)) {
        //PROFILE PICTURE
        if(!empty($_FILES['avatar']['name'])) {         
            try {
                $image = $_FILES['avatar']['name'];
                uploadImage($image);
            }catch(Exception $e) {
                $image = $userData['avatar'];
                $error = $e->getMessage();
            }
        } //no else, field not required
        
        //USERNAME
        if(!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
        }else { // else because name is required
            $error = "voornaam en achternaam zijn verplicht";
        }

        //DESCRIPTION
        if(!empty($_POST['description'])) {
            $description = $_POST['description'];
        }else if(strlen($decription > 500)) {
            $error = "profieltekst mag maximum 500 characters zijn";
        } // no else, field not required

        //KLAS
        $class = $_POST['class'];

        //INTERESSES
        $interests = $_POST['interests'];

        //HOBBIES
        $hobbies = $_POST['hobbies'];

        //FAVORIETE DRANKJE
        $beverage = $_POST['beverage'];

        //FAVORIETE HUISDIER
        $pet = $_POST['pet'];

        //all the dropdowns auto select answer so will never be empty

        //checks if everything is in order to update profile
        if(!isset($error)){
            try {
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setDescription($description);
                $user->setAvatar($image);
                $user->setClass($class);
                $user->setInterests($interests);
                $user->setHobbies($hobbies);
                $user->setBeverage($beverage);
                $user->setPet($pet);
                $user->completeProfile();
                //redirect to homepage
				header('location: index.php');
            } catch (\Throwable $th) {
                $error = $th->getMessage();
            }
        }     
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vervolledig</title>
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
		<div class="form form--login">
			<form action="" method="post" enctype="multipart/form-data">
				<h2 form__title>Maak je profiel volledig!</h2>

				<?php if(isset($error)) : ?>
				<div class="form__error">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>

				<div class="form__field">
                    <label for="avatar">Profiel foto</label>
                    <div class="avatar__img">
                        <p>Huidige profielfoto:</p>
                        <img class="avatar" src="<?php if(!empty($image)){ 
                        echo "uploads/" . htmlspecialchars($image);
                    }else { 
                       echo "https://via.placeholder.com/150";
                    }  ?>
                    " alt="profielfoto"></div>
                    <input type="file" name="avatar" id="avatar" class="fileUpload">
                    
                </div>

                <div class="form__field">
					<label for="firstname">voornaam</label>
                    <input type="text" id="firstname" name="firstname"
                    <?php if(!empty($firstname)){ ?>
                        value="<?php echo htmlspecialchars($firstname); ?>"
                    <?php } else { ?>
                        placeholder="first name"
                    <?php } ?>
                    >
				</div>

                <div class="form__field">
					<label for="lastname">achternaam</label>
                    <input type="text" id="lastname" name="lastname"
                    <?php if(!empty($lastname)){ ?>
                        value="<?php echo htmlspecialchars($lastname); ?>"
                    <?php } else { ?>
                        placeholder="lastname"
                    <?php } ?>
                    >
                </div>

                <div class="form__field">
					<label for="description">profieltekst</label>
                    <textarea type="textarea" id="description" name="description"
                    <?php if(empty($description)){ ?>
                        placeholder="korte profieltekst, max 500 characters"
                    <?php } ?>
                    ><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                
                <div class="form__field">
					<label for="class">klas</label>
                    <select name="class" id="class">
                        <option <?php if(isset($class) && $class === "1IMD") { echo "selected";}?> value="1IMD">1IMD</option>
                        <option <?php if(isset($class) && $class === "2IMD") { echo "selected";}?> value="2IMD">2IMD</option>
                        <option <?php if(isset($class) && $class === "3IMD") { echo "selected";}?> value="3IMD">3IMD</option>
                    </select>
				</div>

                <div class="form__field">
					<label for="interests">interesses</label>
                    <select name="interests" id="interests">
                        <option <?php if(isset($interests) && $interests === "Designing") { echo "selected";}?> value="Designing">Designen</option>
                        <option <?php if(isset($interests) && $interests === "Developing") { echo "selected";}?> value="Developing">Developen</option>
                        <option <?php if(isset($interests) && $interests === "Both") { echo "selected";}?> value="Both">Beide</option>
                    </select>
                </div>
                
                <div class="form__field">
					<label for="hobbies">hobbies</label>
                    <select name="hobbies" id="hobbies">
                        <option <?php if(isset($hobbies) && $hobbies === "Party") { echo "selected";}?> value="Party">party like it's 1969 🥳</option>
                        <option <?php if(isset($hobbies) && $hobbies === "Sleeping") { echo "selected";}?> value="Sleeping">slapen 😴</option>
                        <option <?php if(isset($hobbies) && $hobbies === "Tv") { echo "selected";}?> value="Tv">Tv-series en filmen kijken 📺</option>
                    </select>
                </div>

                <div class="form__field">
					<label for="beverage">favoriete drankje tijdens het developen/designen</label>
                    <select name="beverage" id="beverage">
                        <option <?php if(isset($beverage) && $beverage === "Beer") { echo "selected";}?> value="Beer">Bier 🍺</option>
                        <option <?php if(isset($beverage) && $beverage === "Coffee") { echo "selected";}?> value="Coffee">Koffie ☕</option>
                        <option <?php if(isset($beverage) && $beverage === "Soda") { echo "selected";}?> value="Soda">Frisdrank 🥤</option>
                        <option <?php if(isset($beverage) && $beverage === "Tea") { echo "selected";}?> value="Tea">Thee 🍵</option>
                    </select>
                </div>

                <div class="form__field">
					<label for="pet">favoriete huisdier</label>
                    <select name="pet" id="pet">
                        <option <?php if(isset($pet) && $pet === "Bunny") { echo "selected";}?> value="Bunny">Konijn 🐇</option>
                        <option <?php if(isset($pet) && $pet === "Cat") { echo "selected";}?> value="Cat">Kat 🐈</option>
                        <option <?php if(isset($pet) && $pet === "Dog") { echo "selected";}?> value="Dog">Hond 🐕</option>
                        <option <?php if(isset($pet) && $pet === "Horse") { echo "selected";}?> value="Horse">Paard 🐎</option>
                        <option <?php if(isset($pet) && $pet === "All") { echo "selected";}?> value="All">ik hou van ze allemaal 💓</option>
                    </select>
                </div>

				<div class="form__field">
					<input type="submit" value="vervolledig profiel" class="btn btn--primary">	
				</div>
			</form>
		</div>
    </div>
</body>
</html>