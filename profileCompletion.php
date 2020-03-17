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
				<h2 form__title>Complete your profile!</h2>

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
					<label for="firstname">first name</label>
                    <input type="text" id="firstname" name="firstname"
                    <?php if(!empty($firstname)){ ?>
                        value="<?php echo $firstname; ?>"
                    <?php } else { ?>
                        placeholder="first name"
                    <?php } ?>
                    >
				</div>

                <div class="form__field">
					<label for="lastname">last name</label>
                    <input type="text" id="lastname" name="lastname"
                    <?php if(!empty($lastname)){ ?>
                        value="<?php echo $lastname; ?>"
                    <?php } else { ?>
                        placeholder="lastname"
                    <?php } ?>
                    >
                </div>
                
                <div class="form__field">
					<label for="class">class</label>
                    <select name="class" id="class">
                        <option <?php if(isset($class) && $class === "1IMD") { echo "selected";}?> value="1IMD">1IMD</option>
                        <option <?php if(isset($class) && $class === "2IMD") { echo "selected";}?> value="2IMD">2IMD</option>
                        <option <?php if(isset($class) && $class === "3IMD") { echo "selected";}?> value="3IMD">3IMD</option>
                    </select>
				</div>

                <div class="form__field">
					<label for="interests">interests</label>
                    <select name="interests" id="interests">
                        <option <?php if(isset($interests) && $interests === "Designing") { echo "selected";}?> value="Designing">Designing</option>
                        <option <?php if(isset($interests) && $interests === "Developing") { echo "selected";}?> value="Developing">Developing</option>
                        <option <?php if(isset($interests) && $interests === "Both") { echo "selected";}?> value="Both">Both</option>
                    </select>
                </div>
                
                <div class="form__field">
					<label for="interests">hobbies</label>
                    <select name="hobbies" id="hobbies">
                        <option <?php if(isset($hobbies) && $hobbies === "Party") { echo "selected";}?> value="Party">party like it's 1969 🥳</option>
                        <option <?php if(isset($hobbies) && $hobbies === "Sleeping") { echo "selected";}?> value="Sleeping">sleeping 😴</option>
                        <option <?php if(isset($hobbies) && $hobbies === "Tv") { echo "selected";}?> value="Tv">watching movies or tv shows 📺</option>
                    </select>
                </div>

                <div class="form__field">
					<label for="interests">best beverage while developing/designing</label>
                    <select name="beverage" id="beverage">
                        <option <?php if(isset($beverage) && $beverage === "Beer") { echo "selected";}?> value="Beer">Beer 🍺</option>
                        <option <?php if(isset($beverage) && $beverage === "Coffee") { echo "selected";}?> value="Coffee">Coffee ☕</option>
                        <option <?php if(isset($beverage) && $beverage === "Soda") { echo "selected";}?> value="Soda">Soda 🥤</option>
                        <option <?php if(isset($beverage) && $beverage === "Tea") { echo "selected";}?> value="Tea">Tea 🍵</option>
                    </select>
                </div>

                <div class="form__field">
					<label for="interests">favourite pet</label>
                    <select name="pet" id="pet">
                        <option <?php if(isset($pet) && $pet === "Bunny") { echo "selected";}?> value="Bunny">Bunny 🐇</option>
                        <option <?php if(isset($pet) && $pet === "Cat") { echo "selected";}?> value="Cat">Cat 🐈</option>
                        <option <?php if(isset($pet) && $pet === "Dog") { echo "selected";}?> value="Dog">Dog 🐕</option>
                        <option <?php if(isset($pet) && $pet === "Horse") { echo "selected";}?> value="Horse">Horse 🐎</option>
                        <option <?php if(isset($pet) && $pet === "All") { echo "selected";}?> value="All">I love all animals equally 💓</option>
                    </select>
                </div>

				<div class="form__field">
					<input type="submit" value="complete profile" class="btn btn--primary">	
				</div>
			</form>
		</div>
	</div>
</body>
</html>