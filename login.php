<?php
    namespace src\Buddy;

    spl_autoload_register();
    $user = new User();

    $failedLogin = new IpCheck();
    $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
    $t=time(); //Storing time in variable
    $diff = (time()-120); // Here 120 means 2 minutes 1*1200 seconds

    $failedLogin->setIp($ip);
    $failedLogin->setT($t);
    $failedLogin->setDiff($diff);

    $count = $failedLogin->failedLoginAmount();
    if ($count["COUNT(*)"] >= 3) {
        $error = $count["COUNT(*)"] . " foutieve login pogingen, probeer binnen enkele minuten opnieuw";
    } else {
        if (!empty($_POST)) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $count = $failedLogin->failedLoginAmount();
            if (!empty($email) && !empty($password)) {
                if ($user->checkLogin($email, $password)) {
                    if ($user->getActive() == 1) {
                        session_start();
                        if ($_POST['captcha'] == $_SESSION['digit']) {
                            $user->setEmail($email);
                            $idArray = $user->idFromSession($email);
                            $id = $idArray['id'];
                            $user->setId($id);

                            // later aanpassen -> if checkbox is ticked use cookie
                            $_SESSION["user"] = $email;
                            $_SESSION["id"] = $id;

                            //redirect to index.php
                            $failedLogin->deleteAllFailedLogin();
                            header("Location: index.php");
                        } else {
                            session_destroy();
                            $t=time();
                            $failedLogin->setT($t);
                            $failedLogin->failedLogin();
                            $count = $failedLogin->failedLoginAmount();
                            $num = 3 - $count["COUNT(*)"];
                            if ($num > 0) {
                                $error = "captcha niet correct uitgevoerd, let op je hebt " . $num . " pogingen over";
                            } else {
                                $error = $count["COUNT(*)"] . " foutieve login pogingen, probeer binnen enkele minuten opnieuw";
                            }
                        }
                    } else {
                        $error = "deze account werd nog niet geactiveerd";
                    }
                } else {
                    $failedLogin->failedLogin();
                    $count = $failedLogin->failedLoginAmount();
                    $num = 3 - $count["COUNT(*)"];
                    if ($num > 0) {
                        $error = "Wachtwoord en email komen niet overeen, let op je hebt " . $num . " pogingen over";
                    } else {
                        $error = $count["COUNT(*)"] . " foutieve login pogingen, probeer binnen enkele minuten opnieuw";
                    }
                }
            } else {
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
    <title>buddy app login</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="form form--login">
            <form action="" method="post">
                <h2 form__title>Login</h2>

                <?php if (isset($error)) : ?>
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
                    <label for="captcha">Captcha</label>
                    <img src="captcha.php">
                    <input type="text" name="captcha" placeholder="captcha">
                </div>



                <div class="form__field">
                    <input type="submit" value="Login" class="btn btn--primary">
                </div>
            </form>
            <a class="a__activate a__right" href="register.php">Geen account? Maak er één!</a>
        </div>
    </div>
</body>

</html>