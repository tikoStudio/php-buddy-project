<?php
include_once(__DIR__ . "/classes/User.php");

if(!empty($_POST)) {

    try {
        $user = new User();
        $user->setFirstname($_POST['firstname']);
        $user->setLastname($_POST['lastname']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setPasswordconfirmation($_POST['passwordconfirmation']);

        if($_POST['password'] != $_POST['passwordconfirmation']) {
            $error = "Wachtwoord klopt niet!";
        }

        if ( $user->availableEmail($user->getEmail()) ) {
            // Email ready to use
            if ( $user->validEmail($_POST['email']) === true ){
                // valid email
            } else {
                $error = "Ongeldig email!";
            }
        } 
        else {
            $error = "Email is al in gebruik!";
        }

        if($user->endsWith($_POST['email'],"@student.thomasmore.be")) {
        }
        else {
            $error = "Gebruik email van Thomasmore!";
    }


    } catch (\Throwable $th) {
        $error = $th->getMessage();
    }


    if(!isset($error)) {
        // methode
        $user->save();

        //$succes = "user saved";
        header('Location: login.php');
    }

}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Register</title>
</head>
<body>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if(isset($succes)): ?>
        <div class="succes"><?php echo $succes; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" name="firstname" id="firstname">
        </div>

        <div>
            <label for="lastname">Lastname</label>
            <input type="text" class="form-control" name="lastname" id="lastname">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <div></div>
            <label for="passwordconfirmation">Password confirmation</label>
            <input type="password" class="form-control" name="passwordconfirmation" id="passwordconfirmation">
        </div>

        <div>
            <input type="submit" class="btn btn-primary" value="Registreren">
        </div>
    </form>
</body>
</html>