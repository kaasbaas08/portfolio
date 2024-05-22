<?php

//set credit change session
if (!isset($_SESSION['credit-change'])) {
    $_SESSION['credit-change'] = 0;
} else {
    $_SESSION['credit-change'] = 0;
}

//set outcome session
if (!isset($_SESSION['outcome'])) {
    $_SESSION['outcome'] = "";
} else {
    $_SESSION['outcome'] = "";
}

//function for the start of the game
function gameStart($playingcards)
{

    if (empty($_SESSION['playercards'])) {
        //give player 2 cards
        drawCard_Player($playingcards);
        drawCard_Player($playingcards);
    }

    if (empty($_SESSION['dealercards'])) {
        //give player 2 cards
        drawCard_Dealer($playingcards);
        drawCard_Dealer($playingcards);
    }
}

//function for displaying the player cards
function displayDealerCards()
{
    //if the session dealercards is set and is an array
    if (isset($_SESSION["dealercards"]) && is_array($_SESSION["dealercards"])) {
        $dealercards = $_SESSION["dealercards"];

        //if it's the players turn, the first card of the dealer is hidden
        if ($_SESSION['your_turn'] == true) {
            $dealercards[0] = "../assets/cards/back-red.png";
        }
        //displaying cards
        foreach ($dealercards as $card) {
            echo "<img src='" . $card . "' alt='card' class='blackjack-card'>";
        }
    } else {
        $dealercards = [];
        $_SESSION["dealercards"] = [];
    }
}

//function for displaying the dealer cards
function displayPlayerCards()
{
    //if the session playercards is set and is an array
    if (isset($_SESSION["playercards"]) && is_array($_SESSION["playercards"])) {
        $playercards = $_SESSION["playercards"];
        //displaying cards
        foreach ($_SESSION['playercards'] as $card) {
            echo "<img src='" . $card . "' alt='card' class='blackjack-card'>";
        }
    } else {
        $playercards = [];
        $_SESSION["playercards"] = [];
    }
}

//setting the bet session for the betGUI function
if (!isset($_SESSION['betamount'])) {
    $_SESSION['betamount'] = 0;
}
function betGUI($user, $pdo)
{
    //checks for valid bet amount and if enough credits
    echo "<h1>You need to bet first!</h1>";
?>
    <!-- form for betting-->
    <form method="post">
        <input type="submit" name="bet" value="bet" class="blackjack-betbutton">
        <input type="number" name="betamount" min="1" max="1000" class="blackjack-betfield">
    </form>
<?php
    //if bet is set
    if (isset($_POST['bet'])) {
        
        $_SESSION['betamount'] += $_POST['betamount'];

        //error message if bet is invalid
        if ($user['credits'] <= 0 || $user['credits'] < $_SESSION["betamount"] || $_SESSION["betamount"] <= 0) {
            echo "<p id='msg' style='color:red;'>invalid bet or not enough credits.</p>";
            return;
        } else {
            //update the credits in the database
            $user['credits'] -= $_SESSION["betamount"];
            echo "<h1 style='margin-top: 15px'>You bet: " . $_SESSION['betamount'] . "</h1>";

            $_SESSION['newCredits'] = $user['credits'];

            $newCredits = $_SESSION['newCredits'];
            $updateQuery = "UPDATE users SET credits = :credits WHERE id = :id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':credits', $newCredits, PDO::PARAM_INT);
            $loggedInUserId = $_SESSION['loggedInUser'];
            $updateStmt->bindParam(':id', $loggedInUserId, PDO::PARAM_INT);
            $updateStmt->execute();

            header("refresh:2; url= blackjack.php");
        }
    }
}
// function for the hit button
function hit($playingcards)
{

    if ($_SESSION['playerscore'] == 21) {

        $_SESSION['eventmessage'] = "You have 21!";
        $_SESSION['your_turn'] = false;
    } else {

        drawCard_Player($playingcards);
    }
}

//function for the stand button
function stand()
{
    $_SESSION['your_turn'] = false;
    header("location: blackjack.php");
    $_SESSION['eventmessage'] = "You Stand! Dealers turn!";
}

//dealer logic and outcome
function dealerLogic($playingcards, $user, $pdo)
{
    // Check if a refresh is needed and redirect accordingly.
    if (isset($_SESSION['refresh_needed2']) && $_SESSION['refresh_needed2']) {
        header("location: blackjack.php");
        // Reset the flag.
        $_SESSION['refresh_needed2'] = false;
    }

    $_SESSION['eventmessage'] = "Dealers turn!";

    //if the dealer has less than 16, the dealer will draw a card
    if ($_SESSION['dealerscore'] < 16) {
        drawCard_Dealer($playingcards);
        header("refresh:1; url=blackjack.php");
        // Set a flag to indicate that a page refresh is needed.

        $_SESSION['refresh_needed'] = true;
    } else {
        //if the dealer has 16 or more, the dealer will stand
        if ($_SESSION['playerscore'] > 21) {
            $_SESSION['eventmessage'] = "You busted, you lost: " . $_SESSION['betamount'] . " Press restart to play again.";
            $_SESSION['outcome'] = "lose";
            // Check if a refresh is needed and redirect accordingly.
            if (isset($_SESSION['refresh_needed']) && $_SESSION['refresh_needed']) {
                header("refresh:1; url=blackjack.php");
                // Reset the flag.
                $_SESSION['refresh_needed'] = false;
            } else {
                restart_game($pdo, $user);
            }
        //if dealer has more then 22 then bust
        } elseif ($_SESSION['dealerscore'] >= 22) {

            $_SESSION['eventmessage'] = "Dealer bust, you win: " . $_SESSION['betamount'] . " Press restart to play again.";
            $_SESSION['outcome'] = "win";
        //if dealer has more then player and less then 22 then lose
        } elseif ($_SESSION['playerscore'] > $_SESSION['dealerscore'] && $_SESSION['playerscore'] <= 21) {

            $_SESSION['eventmessage'] = "Dealer stands, you win: " . $_SESSION['betamount'] . " Press restart to play again.";
            $_SESSION['outcome'] = "win";
        //if player score == dealerscore then tie
        } else if ($_SESSION['playerscore'] == $_SESSION['dealerscore']) {
            $_SESSION['eventmessage'] = "Dealer stands, it's a tie and you lost nothing! Press restart to play again.";
            $_SESSION['outcome'] = "tie";
            
        } else {
            //rest of outcomes are lose
            $_SESSION['eventmessage'] = "Dealer stands, you lost: " . $_SESSION['betamount'] . " Press restart to play again.";
            $_SESSION['outcome'] = "lose";
            
        }
        // Check if a refresh is needed and redirect accordingly.
        if (isset($_SESSION['refresh_needed']) && $_SESSION['refresh_needed']) {
            header("refresh:1; url=blackjack.php");
            // Reset the flag.
            $_SESSION['refresh_needed'] = false;
        } else {
            restart_game($pdo, $user);
        }
    }
}

//function for restarting and resetting the game
function restart_game($pdo, $user)
{
    //restart button
    echo "<form class='blackjack-restart-container' method='POST'>"
        . "<input class='blackjack-restart' type='submit' name='restart' value='restart'>"
        . "</form>";

    //logicthe restart button
    if (isset($_POST['restart'])) {

        if ($_SESSION['outcome'] == "win") {

            $_SESSION['credit-change'] = $_SESSION['betamount'] * 2;
            $_SESSION['newCredits'] = $user['credits'] + $_SESSION['credit-change'];

        } else {

            $_SESSION['credit-change'] = 0;
            $_SESSION['newCredits'] = $user['credits'];

        }
        //update the credits in the database
        $newCredits = $_SESSION['newCredits'];
        $updateQuery = "UPDATE users SET credits = :credits WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':credits', $newCredits, PDO::PARAM_INT);
        $loggedInUserId = $_SESSION['loggedInUser'];
        $updateStmt->bindParam(':id', $loggedInUserId, PDO::PARAM_INT);
        $updateStmt->execute();

        $_SESSION['newCredits'] = $newCredits;
        //reset all game sessions except for usedcards
        $_SESSION['dealercards'] = [];
        $_SESSION['eventmessage'] = "Game started!";
        $_SESSION['playerscore'] = 0;
        $_SESSION['dealerscore'] = 0;
        $_SESSION['betamount'] = 0;
        $_SESSION['credit-change'] = 0;
        $_SESSION['playercards'] = [];
        $_SESSION['your_turn'] = true;
        $_SESSION['refresh_needed'] = true;
        header("refresh:0; url=blackjack.php");
    }
}
