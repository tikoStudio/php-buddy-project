<?php 
	include_once(__DIR__ . "/classes/User.php");
	$user = new User();

	if(!empty($_POST)) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		if(!empty($email) && !empty($password)){
			if($user->checkLogin($email, $password)){
				session_start();
				$_SESSION["user"] = $email; // later aanpassen -> if checkbox is ticked use cookie 
				//redirect to index.php
				header("Location: index.php");
			}else{
				$error = "Wachtwoord en email komen niet overeen";
			}
		}else {
			$error = "email en wachtwoord zijn verplicht";
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
<div class="login">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Login</h2>

				<?php if(isset($error)) : ?>
				<div class="form__error">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>

                <div class="form__field">
					<label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="email">
				</div>

                <div class="form__field">
					<label for="password">Passwoord</label>
                    <input type="text" id="password" name="password" placeholder="Passwoord">
                </div>

				<div class="form__field">
					<input type="submit" value="vervolledig profiel" class="btn btn--primary">	
				</div>
			</form>
		</div>
	</div>
</body>
</html>