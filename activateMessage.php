<?php
    include_once(__DIR__ . "/classes/Buddy.php");

    if (!empty($_GET['u'])) {
        $param = $_GET['u'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Account activatie</title>
</head>

<body>
    <div class="container">
        <div class="form form--login center">
            <h1>Account activatie:</h1>
            <p>Check je email om account activeren</p>
            <p>of klik <a
                    href="activate.php?u=<?php echo $param; ?>">hier</a>
                om je account nu te activeren!</p>
        </div>
    </div>
</body>

</html>