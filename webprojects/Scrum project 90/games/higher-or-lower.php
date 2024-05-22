<?php
// Login check, don't remove!
include_once('../connection.php');

$_SESSION['newCredits'] = $user['credits'];
echo '<div class="back"><a href="../index.php"><svg style="width:25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M12.5 9.75A2.75 2.75 0 0 0 9.75 7H4.56l2.22 2.22a.75.75 0 1 1-1.06 1.06l-3.5-3.5a.75.75 0 0 1 0-1.06l3.5-3.5a.75.75 0 0 1 1.06 1.06L4.56 5.5h5.19a4.25 4.25 0 0 1 0 8.5h-1a.75.75 0 0 1 0-1.5h1a2.75 2.75 0 0 0 2.75-2.75Z" clip-rule="evenodd" />
                </svg>Back home</a><hr></div>';

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
    <title>Casino - Higher or lower</title>
    <link rel="stylesheet" href="../style.css">
    <!-- The font, dont remove!! -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- the inline styling to overwrite the external css -->
    <style>
        body {
            background-color: #f4f4f4;
            text-align: center;
            background-position: 50% 50%;
            color: white;
            background: radial-gradient(circle at bottom, navy 0, black 100%);

        }

       


        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .card {
            text-align: center;
            border: 2px solid white;
            width: 7%;
            height: auto;
            margin-top: 4%;
        }

        h2 {
            margin-bottom: -3%;
        }

        .card>* {
            font-size: 250%;

        }

        

        .card-label {
            font-weight: bold;
            margin-top: 20%;
            margin-bottom: 10%;
        }


        p,
        label {
            font-weight: bold;
            font-size: 130%;
        }


        footer {
            position: relative;
            bottom: 0%;
            width: 100%;
        }

  

        .dots {
            background: rgba(128, 0, 128, 0.1) center / 10% 10% round;
            bottom: 0;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            z-index: -1;
        }

        .dots {
            z-index: -1;
            animation: space 120s ease-in-out infinite;
            background-image:
                radial-gradient(1px 1px at 25px 5px,
                    white,
                    rgba(255, 255, 255, 0)),
                radial-gradient(1px 1px at 50px 25px,
                    white,
                    rgba(255, 255, 255, 0)),
                radial-gradient(1px 1px at 125px 20px,
                    white,
                    rgba(255, 255, 255, 0)),
                radial-gradient(1.5px 1.5px at 50px 75px,
                    white,
                    rgba(255, 255, 255, 0)),
                radial-gradient(2px 2px at 15px 125px,
                    white,
                    rgba(255, 255, 255, 0)),
                radial-gradient(2.5px 2.5px at 110px 80px,
                    white,
                    rgba(255, 255, 255, 0));
        }
    </style>
</head>

<body>
    <div class="wrapper-main">
        <!-- the navbar -->
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
        <h1>Higher or Lower Game</h1>
        <div class="oldandnew">
            <h2>previous card-</h2>
            <h2>-current card</h2>
        </div>
        <?php


        //Login check, dont remove!
        include_once('../connection.php');

        if (!isset($_SESSION['loggedInUser'])) {
            header('Location: ../login.php');
            die();
        }

        // Function to initialize or reset the game
        function initializeGame()
        {
            $_SESSION['score'] = 0;
            $_SESSION['currentCard'] = getRandomCard();
        }

        // Function to get a random card
        function getRandomCard()
        {
            $suits = array('♥️', '♠️', '♣️', '♦️');
            $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');
            $randomSuit = $suits[array_rand($suits)];
            $randomValue = $values[array_rand($values)];

            return array('suit' => $randomSuit, 'value' => $randomValue);
        }

        // Function to display the current card
        function displayCard($card)
        {
            echo '<div class="card">';
            echo '<span="value">' . $card['value'] . '</span>';
            echo '<span style="font-size: 120%;">' . $card['suit'] . '</span>';
            echo '</div>';
        }

        // Function to compare two cards
        function compareCards($card1, $card2)
        {
            $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');

            $valueIndex1 = array_search($card1['value'], $values);
            $valueIndex2 = array_search($card2['value'], $values);

            if ($valueIndex1 < $valueIndex2) {
                return 'higher';
            } elseif ($valueIndex1 > $valueIndex2) {
                return 'lower';
            } else {
                return 'equal';
            }
        }

        // Function to play the game
        function playGame($guess, $points)
        {
            $previousCard = $_SESSION['currentCard'];
            $mysteryCard = getRandomCard();

            // Check if the user has enough credits to place the bet
            if ($points > $_SESSION['newCredits']) {
                echo '<div id="higherlower-span"><span style="color: red;">You don\'t have enough credits to place this bet!</span></div>';
                return; // Stop the function if the user doesn't have enough credits
            }

            echo '<div class="card-container">';

            // Display the previous card
            echo '<div class="card">';
            echo '<span="value">' . $previousCard['value'] . '</span>';
            echo '<span style="font-size: 95px;">' . $previousCard['suit'] . '</span>';
            echo '</div>';

            // Display the new card
            echo '<div class="card">';
            echo '<span="value">' . $mysteryCard['value'] . '</span>';
            echo '<span style="font-size: 95px;">' . $mysteryCard['suit'] . '</span>';
            echo '</div>';

            echo '</div>';

            $result = compareCards($previousCard, $mysteryCard);

            if (($guess == 'higher' && $result == 'higher') || ($guess == 'lower' && $result == 'lower')) {
                echo '<div id="higherlower-span"><span style="color: green;">Correct!</span></div>';
                $_SESSION['score'] += $points * 2; // Double the points if correct
            } else {
                echo '<div id="higherlower-span"><span style="color: red;">Incorrect!</span></div>';
                $_SESSION['score'] -= $points; // Lose the points if incorrect
            }

            $_SESSION['currentCard'] = $mysteryCard;
            $_SESSION['newCredits'] -= $points; // Deduct the bet amount from available credits
        }



        // Check if the game has started
        if (!isset($_SESSION['score'])) {
            initializeGame();
        }

        // Check if the player has made a guess
        if (isset($_POST['guess'])) {
            playGame($_POST['guess'], $_POST['points']);
        }

        ?>
        <h2>Score: <?php echo $_SESSION['score']; ?></h2>
        <form method="post">
            <div class="betslider">
                <label for="points" style="margin-right: 1%;">Credits to bet:</label>
                <span id="currentPoints">0</span>
                <input type="range" id="points" name="points" min="0" max="1000" step="5" value="1" oninput="updateSliderValue(this.value)">
                <span>1000</span>
            </div>

            <div class="row">
                <p>will the next card be</p>
                <input type="submit" class="higher" name="guess" value="higher" id="higher" required>
                <p>or</p>
                <input type="submit" class="lower" name="guess" value="lower" id="lower" required>
                <p>?</p>
            </div>
        </form>
        <div class="dots dots"></div>
        <script>
            function updateSliderValue(value) {
                document.getElementById("currentPoints").innerText = value;
                document.getElementById("points").value = value; // Update the slider value
            }
        </script>
    </div>
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