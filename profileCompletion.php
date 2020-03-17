<?php 
    $email = "test@gmail.com";
    $firstname = "testfirstname";
    $lastname = "testlastname";
    $class = "2IMD";
    $interests = "Designing";
    $hobbies = "Sleeping";
    $beverage = "Tea";
    $pet = "All";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>complete profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Maak je profiel volledig!</h2>

				<?php if(isset($error)) : ?>
				<div class="form__error">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>

				<div class="form__field">
					<label for="email">Email</label>
                    <input type="text" id="email" name="email" 
                    <?php if(!empty($email)){ ?>
                        value="<?php echo $email; ?>"
                    <?php } else { ?>
                        placeholder="email"
                    <?php } ?>
                    >
				</div>

                <div class="form__field">
					<label for="firstname">voornaam</label>
                    <input type="text" id="firstname" name="firstname"
                    <?php if(!empty($firstname)){ ?>
                        value="<?php echo $firstname; ?>"
                    <?php } else { ?>
                        placeholder="first name"
                    <?php } ?>
                    >
				</div>

                <div class="form__field">
					<label for="lastname">achternaam</label>
                    <input type="text" id="lastname" name="lastname"
                    <?php if(!empty($lastname)){ ?>
                        value="<?php echo $lastname; ?>"
                    <?php } else { ?>
                        placeholder="lastname"
                    <?php } ?>
                    >
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
					<label for="interests">hobbies</label>
                    <select name="hobbies" id="hobbies">
                        <option <?php if(isset($hobbies) && $hobbies === "Party") { echo "selected";}?> value="Party">party like it's 1969 🥳</option>
                        <option <?php if(isset($hobbies) && $hobbies === "Sleeping") { echo "selected";}?> value="Sleeping">slapen 😴</option>
                        <option <?php if(isset($hobbies) && $hobbies === "Tv") { echo "selected";}?> value="Tv">Tv-series en filmen kijken 📺</option>
                    </select>
                </div>

                <div class="form__field">
					<label for="interests">favoriete drankje tijdens het developen/designen</label>
                    <select name="beverage" id="beverage">
                        <option <?php if(isset($beverage) && $beverage === "Beer") { echo "selected";}?> value="Beer">Bier 🍺</option>
                        <option <?php if(isset($beverage) && $beverage === "Coffee") { echo "selected";}?> value="Coffee">Koffie ☕</option>
                        <option <?php if(isset($beverage) && $beverage === "Soda") { echo "selected";}?> value="Soda">Frisdrank 🥤</option>
                        <option <?php if(isset($beverage) && $beverage === "Tea") { echo "selected";}?> value="Tea">Thee 🍵</option>
                    </select>
                </div>

                <div class="form__field">
					<label for="interests">favoriete huisdier</label>
                    <select name="pet" id="pet">
                        <option <?php if(isset($pet) && $pet === "Bunny") { echo "selected";}?> value="Bunny">Konijn 🐇</option>
                        <option <?php if(isset($pet) && $pet === "Cat") { echo "selected";}?> value="Cat">Kat 🐈</option>
                        <option <?php if(isset($pet) && $pet === "Dog") { echo "selected";}?> value="Dog">Hond 🐕</option>
                        <option <?php if(isset($pet) && $pet === "Horse") { echo "selected";}?> value="Horse">Paard 🐎</option>
                        <option <?php if(isset($pet) && $pet === "All") { echo "selected";}?> value="All">ik hou van ze allemaal even veel 💓</option>
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