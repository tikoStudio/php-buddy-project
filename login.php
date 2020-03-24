<?php 
function canLogin($email, $password) { 
	if($email ==="test@test.com" && $password ==="test"){ 
		return true; 
	} else{
		return false;
	}
}
if(!empty($_POST)) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	if(!empty($email) && !empty($password)){
		if(canLogin($email, $password)){
			$salt = "6864hfuehoHUHEQJFO8786";
			$cookieContent = $email . "," . md5($email.$salt);
			setcookie("login", $cookieContent , time()+60*60*24*30);
			header("Location: index.php");
		}else{
			$error = "Wachtwoord en gebruikersnaam komen niet overeen";
		}
	}else {
		$error = "Gebruikersnaam en wachtwoord zijn verplicht";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>buddy app</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="netflixLogin">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>log In</h2>
				<?php if(isset($error)) : ?>
				<div class="form__error">
					<p>
					<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>
				<div class="form__field">
					<label for="Email">Email</label>
					<input type="text" id="Email" name="email">
				</div>
				<div class="form__field">
					<label for="Password">Wachtwoord</label>
					<input type="password" id="Password" name="password">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign in" class="btn btn--primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Onthoud mij</label>
				</div>
			</form>
		</div>
	</div>
</body>
</html>