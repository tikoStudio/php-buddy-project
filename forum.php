<?php

include_once(__DIR__ . "/classes/User.php");

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = new User();
$posts = $user->printPost();

if(!empty($_POST)) {
    try {
        $user->setPost($_POST['question']);
        $user->setId($_SESSION["id"]);
    }
    catch (\Throwable $th) {
        $error = $th->getMessage();
    }
}

if(!isset($error)) {
    try {
        $user->savePost();
    }
    catch (\Throwable $th) {
        $error = $th->getMessage();
    }
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
    <!--
<?php include_once('nav.inc.php'); ?>
-->
<div class="form__error forums"><?php if (isset($error)): ?><?php echo $error; ?><?php endif; ?></div>

<form action="" method="POST">
<div class="form_field forum">
    <textarea name="question" id="question" cols="30" rows="10" placeholder="Stel hier je vraag"></textarea>
</div>

<div class="form__field">
    <input type="submit" value="Verzenden" class="btn btn--primary">
</div>
</form>

<div class="forum-posts">
<?php foreach ($posts as $p): ?>
<h2 class="forum-naam"><?php echo htmlspecialchars($p['firstname']) . " " . htmlspecialchars($p['lastname']); ?></h2>
<p class="forum-post"><?php echo htmlspecialchars($p['post']); ?></p>
<div class="form_field forum">
    <textarea name="answer" id="question" cols="30" rows="10" placeholder="Geef hier je antwoord"></textarea>
</div>
<div class="form__field">
    <input type="submit" value="Verzenden" class="btn btn--primary">
</div>
<?php endforeach; ?>
</div>
<?php include_once('footer.inc.php'); ?>
</body>
</html>