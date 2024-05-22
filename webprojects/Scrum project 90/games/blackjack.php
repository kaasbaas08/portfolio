<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino - Blackjack</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <!-- The font, dont remove!! -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body class="blackjack-body">
    <header>
        <div>
            <img src="../assets/images/logo.png" alt="Logo">
            <h2>90 Casino</h2>
        </div>
        <div>
            <a href="../settings.php">Settings</a>
            <a href="../logout.php">Logout</a>
        </div>
    </header>
    <?php


    //Login check, dont remove!
    include_once('../connection.php');

    if (!isset($_SESSION['loggedInUser'])) {
        header('Location: ../login.php');
        die();
    }

    $_SESSION['newCredits'] = $user['credits'];

    echo '<div class="back"><a href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
    <path fill-rule="evenodd" d="M12.5 9.75A2.75 2.75 0 0 0 9.75 7H4.56l2.22 2.22a.75.75 0 1 1-1.06 1.06l-3.5-3.5a.75.75 0 0 1 0-1.06l3.5-3.5a.75.75 0 0 1 1.06 1.06L4.56 5.5h5.19a4.25 4.25 0 0 1 0 8.5h-1a.75.75 0 0 1 0-1.5h1a2.75 2.75 0 0 0 2.75-2.75Z" clip-rule="evenodd" />
</svg>Back home</a><hr><p>Credits: ' . $_SESSION['newCredits'] . '</p></div>';

    //check if session eventmessage is set
    if (isset($_SESSION['eventmessage'])) {
        $eventmessage = $_SESSION['eventmessage'];
    } else {
        $eventmessage = "";
        $_SESSION['eventmessage'] = "";
    }

    include "cardHandler.php";
    include "blackjack-game-logic.php";

    //check if session playerscore is set
    if (isset($_SESSION['playerscore'])) {
        $playerscore = $_SESSION['playerscore'];
    } else {
        $playerscore = 0;
        $_SESSION['playerscore'] = 0;
    }


    //check if session eventmessage is set
    gameStart($playingcards);

    if (!isset($_SESSION['your_turn'])) {
        $_SESSION['your_turn'] = true;
        $your_turn = $_SESSION['your_turn'];
    } else {
        $your_turn = $_SESSION['your_turn'];
    }
    ?>
    <!-- layout and displaying all blackjack elements -->
    <div class='blackjack-table'>
        <?php if ($_SESSION['betamount'] > 0) { ?>
            <div class="blackjack-betGUI">
                <h1 class="blackjack-betamount">Bet: <?php echo $_SESSION['betamount'] ?></h1>
            </div>
            <?php
            if ($_SESSION['your_turn'] == false) {
                echo "Dealer score: " . $_SESSION['dealerscore'] . "<br>";
            }
            ?>
            <?php
                ?>
            <div class="blackjack-dealerGUI">
                <div class="blackjack-dealercards">
                    <?php
                    displayDealerCards()
                    ?>
                </div>
            </div>
            <!-- Event message -->
            <div class="blackjack-eventBox">
                <?php

                echo '<h1 class="blackjack-eventmessage">' . $_SESSION['eventmessage'] . '</h1>';
                ?>
            </div>

            <div class="blackjack-playerGUI">
                <div class="blackjack-playercards">
                    <?php
                    displayPlayerCards()
                    ?>
                </div>

            </div>
            <!-- buttons -->
            <div class="blackjack-playerbuttons">
                <form method="post">
                    <input type="submit" name="hit" value="hit" class="blackjack-playerbutton">
                    <input type="submit" name="stand" value="stand" class="blackjack-playerbutton">
                    <?php
                    echo "Your score: " . $_SESSION['playerscore'];
                    ?>
                </form>
            </div>

        <?php
        //if bet is not set
        } else {
            betGui($user, $pdo);
        }
        ?>

    </div>
    </div>
    <?php
    //game logic
    if ($your_turn == true) {
        if (isset($_POST['hit'])) {
            hit($playingcards);
            if ($_SESSION['playerscore'] > 21) {
                $_SESSION['eventmessage'] = "You busted!";
                $_SESSION['your_turn'] = false;
                header("location: blackjack.php");
                
            } else {
            header("location: blackjack.php");
            }


        }

        if (isset($_POST['stand'])) {
            stand();
        }
    } elseif ($your_turn == false) {
        dealerLogic($playingcards, $user, $pdo);
    }
    ?>
    <!-- footer -->
    <footer class="absolutefooter">
        <div>
            <img src="../assets/images/logo.png">
            <h4>90 Casino</h4>
        </div>

        <div>
            <p>Made by: Lennard, Kars, Sven, Dominique</p>
        </div>
    </footer>
</body>

</html>