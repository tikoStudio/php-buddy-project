<?php  
    include_once(__DIR__ . "/classes/Buddy.php");

    session_start();
    $email = $_SESSION["user"];
    if(!isset($_SESSION['user']) ) {
      header("Location: login.php");
    }
    $user = new Buddy();
    $user->setId($_SESSION["id"]);
    $userData = $user->allUserData();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <title>Profiel</title>
</head>
<body>
    <?php include_once('nav.inc.php'); ?>   

    <div class="container">
		<div class="form form--login">
                <h2 form__title><?php echo htmlspecialchars($userData['firstname']) . " " . htmlspecialchars($userData['lastname']) ; ?></h2>
                <a class="a__activate a__right" href="profileEdit.php">Wijzig je profiel</a>

				<div class="form__field">
                    <div class="avatar__img">
                        <img class="avatar" src="<?php if(!empty($userData['avatar'])){ 
                        echo "uploads/" . htmlspecialchars($userData['avatar']);
                    }else { 
                       echo "https://via.placeholder.com/150";
                    }  ?>
                    " alt="profielfoto"></div>
                </div>

                <div class="form__field">
					<label for="description">profieltekst:</label>
                    <p> <?php echo htmlspecialchars($userData['description']); ?></p>
                </div>
		</div>
    </div>

    <?php include_once('footer.inc.php'); ?>
</body>
</html>