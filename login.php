<?php 
	include_once(__DIR__ . "/classes/User.php");
	include_once(__DIR__ . "/classes/IpCheck.php");
	$user = new User();

	$failedLogin = new IpCheck();
	$ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
	$t=time(); //Storing time in variable
	$diff = (time()-60); // Here 60 means 1 minutes 1*60 seconds

	$failedLogin->setIp($ip);
	$failedLogin->setT($t);
	$failedLogin->setDiff($diff);

	$count = $failedLogin->failedLoginAmount();
	if( $count["COUNT(*)"] > 3) {
		$error = $count["COUNT(*)"] . " foutieve login pogingen, probeer binnen enkele minuten opnieuw";
	}else {
		if(!empty($_POST)) {
			$email = htmlspecialchars($_POST['email']);
			$password = htmlspecialchars($_POST['password']);
			$count = $failedLogin->failedLoginAmount();
			if(!empty($email) && !empty($password)){
				if($user->checkLogin($email, $password)){
					$user->setEmail($email);
					$idArray = $user->idFromSession($email);
					$id = $idArray['id'];
					$user->setId($id);

					// later aanpassen -> if checkbox is ticked use cookie 
					session_start();
					$_SESSION["user"] = $email; 
					$_SESSION["id"] = $id;

					//redirect to index.php
					$failedLogin->deleteAllFailedLogin();
					header("Location: index.php");
				}else{
					$num = 3 - $count["COUNT(*)"];
					if($num > 0) {
						$error = "Wachtwoord en email komen niet overeen, let op je hebt " . $num . " pogingen over";
					}else {
						$error = $count["COUNT(*)"] . " foutieve login pogingen, probeer binnen enkele minuten opnieuw";
					}
					
					$failedLogin->failedLogin();	
				}
			}else {
				$error = "email en wachtwoord zijn verplicht";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>buddy app</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
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
                    <input type="text" id="email" name="email" placeholder="Email">
				</div>

                <div class="form__field">
					<label for="password">Passwoord</label>
                    <input type="password" id="password" name="password" placeholder="Passwoord">
                </div>
				
				<div class="form__field">
					<input type="submit" value="login" class="btn btn--primary">	
				</div>
			</form>
		</div>
	</div>
</body>
</html>