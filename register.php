<?php
    include_once(__DIR__ . "/classes/Buddy.php");

    if (!empty($_POST)) {
        try {
            $user = new Buddy();
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);

            if ($_POST['password'] != $_POST['passwordconfirmation']) {
                $error = "Wachtwoord klopt niet!";
            }

            if ($user->availableEmail($user->getEmail())) { //still needed to actually give out error
                // Email ready to use
                if ($user->validEmail()) {
                    // valid email
                } else {
                    $error = "Ongeldig email!";
                }
            } else {
                $error = "Email is al in gebruik!";
            }

            if ($user->endsWith("@student.thomasmore.be")) {
            } else {
                $error = "Gebruik email van Thomasmore!";
            }
        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }


        if (!isset($error)) {
            // methode
            try {
                $user->save(); //safe in database as not activated user
                $user->sendActivationMail(); //send email with activation link
                session_start();
                $_SESSION["registeredUser"] = $_POST['email'];
                $id = $user->tokenFromSession($_SESSION['registeredUser']);
                header("Location: activateMessage.php?u=" . $id['activationToken']);
            } catch (\Throwable $th) {
                $error = $th->getMessage();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Registeer</title>
</head>

<body>
    <div class="container">
        <div class="form form--login">
            <h2 form__title>Registreer</h2>
            <form action="" method="POST">


                <div class="form__error"><?php if (isset($error)): ?><?php echo $error; ?><?php endif; ?>
                </div>

                <div class="form__success"></div>


                <div class="form__field">
                    <label for="firstname">Voornaam</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Voornaam">
                </div>

                <div class="form__field">
                    <label for="lastname">Achternaam</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Achternaam">
                </div>

                <div class="form__field">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email"
                        placeholder="Email@student.thomasmore.be">
                </div>

                <div class="form__field">
                    <label for="password">Wachtwoord</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Wachtwoord">
                </div>

                <div class="form__field">
                    <label for="passwordconfirmation">Password confirmatie</label>
                    <input type="password" class="form-control" name="passwordconfirmation" id="passwordconfirmation"
                        placeholder="Wachtwoord confirmatie">
                </div>

                <div class="form__field">
                    <input type="submit" value="Registreren" class="btn btn--primary">
                </div>
            </form>
            <a class="a__activate a__right" href="login.php">Al een account? Login!</a>
        </div>
    </div>
    <script src="js/email.js"></script>
</body>

</html>