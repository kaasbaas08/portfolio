<?php
// Login check, don't remove!
include_once('../connection.php');

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: ../login.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino - Russian roulette</title>
    <link rel="stylesheet" href="../style.css">
    <!-- The font, don't remove!! -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body class="roulette-body">

    <div class="roulette-storie">
        <img class="roulette-storie" src="../assets/images/roulette-storie.png" alt="storie" />
    </div>

    <?php

    if (!isset($_SESSION['money'])) {
        $_SESSION['money'] = 100;
    }
    echo "<h2 style='color: red;'>Your current balance: {$_SESSION['money']} rubles</h2>";
    ?>
    <div class="roulette-container">
        <h1 class="roulette-h1">Russian Roulette</h1>

        <form action="roulette.php" method="post">
            <button type="submit" name="trigger">Pull the trigger!</button>
            <button type="submit" name="spin">Spin the barrel</button>
        </form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Game code
            if (isset($_POST['trigger'])) {

                // 40% win, 60% lose chance
                $outcome = mt_rand(1, 10);

                if ($outcome <= 4) {
                    $_SESSION['money'] += 100; // win +100 rubles
                    echo "<h2 style='color: green;'>You survived and won 100 rubles.</h2>";
                } else {
                    $_SESSION['money'] -= 50; // lose -50 rubles
                    echo "<h2 style='color: red;'>You died and lost 50 rubles.</h2>";
                }
            } elseif (isset($_POST['spin'])) {
                // code for using the skip a turn button
                echo "<h2 style='color: black;'>You spun the barrel. Next turn skipped!</h2>";
            }
        }
        ?>

    </div>

    <div class="roulette-image">
        <img class="roulette-revolver" src="../assets/images/roulette-revolver.png" alt="revolver" />
    </div>

    <a href="../index.php" class="roulette-back-to-main">Back to Main Page</a>

</body>

</html>