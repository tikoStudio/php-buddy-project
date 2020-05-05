<?php

include_once(__DIR__ . "/classes/User.php");

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = new User();
$posts = $user->printPost();

if(!empty($_POST['question'])) {
    try {
        $user->setPost($_POST['question']);
        $user->setId($_SESSION["id"]);
        $user->savePost();
    }
    catch (\Throwable $th) {
        $error = $th->getMessage();
    }
}

if(!empty($_POST['pinit'])) {
    $user->setId($_SESSION["id"]);
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
<h2 class="forum-naam"><?php echo htmlspecialchars($p['firstname']) . " " . htmlspecialchars($p['lastname']); ?></h2>
<p class="forum-post"><?php echo htmlspecialchars($p['post']); ?></p>
<form action="" method="POST">
<div class="form__field">
    <input type="submit" value="Pin it" name="pinit" class="btn btn--primary forum-btn">
</div>
</form>
</div>
<!--
<form action="" method="POST">
<div class="forum-answer">
<div class="form_field forum-input">
    <input type="text" class="form-control" name="answer" id="lastname" placeholder="Geef hier je antwoord">
</div>
<div class="form__field">
    <input type="submit" value="Verzenden" class="btn btn--primary forum-btn">
</div>
</div>
</form>
-->
<?php endforeach; ?>
</div>
<?php include_once('footer.inc.php'); ?>
</body>
</html>