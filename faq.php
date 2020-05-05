<?php
include_once(__DIR__ . "/classes/Post.php");

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = new Post();
$pins = $user->showPins();


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include_once('nav.inc.php'); ?>

    <div class="forum-vh">
    <?php foreach($pins as $p): ?>
    <div class="forum-text">
    <h2 class="forum-naam2"><?php echo htmlspecialchars($p['firstname']) . " " . htmlspecialchars($p['lastname']); ?></h2>
    <p class="forum-post"><?php echo htmlspecialchars($p['post']); ?></p>
    </div>
    <?php endforeach; ?>
    </div>
    <?php include_once('footer.inc.php'); ?>
</body>
</html>