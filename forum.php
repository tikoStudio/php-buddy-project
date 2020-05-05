<?php

include_once(__DIR__ . "/classes/Post.php");
include_once(__DIR__ . "/classes/User.php");

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = new Post();
$posts = $user->printPost();

if(!empty($_POST['question'])) {
    try {
        $user->setPost($_POST['question']);
        $user->setUserId($_SESSION["id"]);
        $user->savePost();
        $posts = $user->printPost();
    }
    catch (\Throwable $th) {
        $error = $th->getMessage();
    }
}

if(!empty($_GET['id'])) {
        $id = $_GET['id'];
        $user->savePin();
        
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include_once('nav.inc.php'); ?>

<div class="form__error forums"><?php if (isset($error)): ?><?php echo $error; ?><?php endif; ?></div>

<form action="" method="POST">
<div class="form_field forum-input">
    <textarea name="question" id="question" cols="30" rows="10" placeholder="Stel hier je vraag"></textarea>
</div>

<div class="form__field">
    <input type="submit" value="Verzenden" class="btn btn--primary forum-btn">
</div>
</form>

<div class="forum-posts">
<?php foreach ($posts as $p): ?>
<div class="forum-text">
<!--nieuw object aanmaken van User-->
<?php $person = new User(); ?>
<!--verandert userId naar id van die persoon-->
<?php $person->setId($p['userId']); ?>
<!--functie die alle data ophaalt van user met bepaalde id-->
<?php $name = $person->allUserData(); ?>

<h2 class="forum-naam"><?php echo htmlspecialchars($name['firstname']) . " " . htmlspecialchars($name['lastname']); ?></h2>
<p class="forum-post"><?php echo htmlspecialchars($p['post']); ?></p>
<a href="forum.php?id=<?php echo $p['id']; ?> " class="pin">Pin it</a>
</div>
<?php endforeach; ?>
</div>
<?php include_once('footer.inc.php'); ?>
</body>
</html>