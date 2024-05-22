<?php
//deck of cards

if (isset($_SESSION["playingcards"])) {
    $playingcards = $_SESSION["playingcards"];
} else {
    $playingcards = [
        "clubs" => [
            "ace" => [1, "../assets/cards/ace_of_clubs.svg"],
            "2" => [2, "../assets/cards/2_of_clubs.svg"],
            "3" => [3, "../assets/cards/3_of_clubs.svg"],
            "4" =>  [4, "../assets/cards/4_of_clubs.svg"],
            "5" => [5, "../assets/cards/5_of_clubs.svg"],
            "6" => [6, "../assets/cards/6_of_clubs.svg"],
            "7" => [7, "../assets/cards/7_of_clubs.svg"],
            "8" => [8, "../assets/cards/8_of_clubs.svg"],
            "9" => [9, "../assets/cards/9_of_clubs.svg"],
            "10" => [10, "../assets/cards/10_of_clubs.svg"],
            "jack" => [10, "../assets/cards/jack_of_clubs.svg"],
            "queen" => [10, "../assets/cards/queen_of_clubs.svg"],
            "king" => [10, "../assets/cards/king_of_clubs.svg"]
        ],
        "diamonds" => [
            "ace" => [1, "../assets/cards/ace_of_diamonds.svg"],
            "2" => [2, "../assets/cards/2_of_diamonds.svg"],
            "3" => [3, "../assets/cards/3_of_diamonds.svg"],
            "4" =>  [4, "../assets/cards/4_of_diamonds.svg"],
            "5" => [5, "../assets/cards/5_of_diamonds.svg"],
            "6" => [6, "../assets/cards/6_of_diamonds.svg"],
            "7" => [7, "../assets/cards/7_of_diamonds.svg"],
            "8" => [8, "../assets/cards/8_of_diamonds.svg"],
            "9" => [9, "../assets/cards/9_of_diamonds.svg"],
            "10" => [10, "../assets/cards/10_of_diamonds.svg"],
            "jack" => [10, "../assets/cards/jack_of_diamonds.svg"],
            "queen" => [10, "../assets/cards/queen_of_diamonds.svg"],
            "king" => [10, "../assets/cards/king_of_diamonds.svg"]
        ],
        "hearts" => [
            "ace" => [1, "../assets/cards/ace_of_hearts.svg"],
            "2" => [2, "../assets/cards/2_of_hearts.svg"],
            "3" => [3, "../assets/cards/3_of_hearts.svg"],
            "4" =>  [4, "../assets/cards/4_of_hearts.svg"],
            "5" => [5, "../assets/cards/5_of_hearts.svg"],
            "6" => [6, "../assets/cards/6_of_hearts.svg"],
            "7" => [7, "../assets/cards/7_of_hearts.svg"],
            "8" => [8, "../assets/cards/8_of_hearts.svg"],
            "9" => [9, "../assets/cards/9_of_hearts.svg"],
            "10" => [10, "../assets/cards/10_of_hearts.svg"],
            "jack" => [10, "../assets/cards/jack_of_hearts.svg"],
            "queen" => [10, "../assets/cards/queen_of_hearts.svg"],
            "king" => [10, "../assets/cards/king_of_hearts.svg"]
        ],
        "spades" => [
            "ace" => [1, "../assets/cards/ace_of_spades.svg"],
            "2" => [2, "../assets/cards/2_of_spades.svg"],
            "3" => [3, "../assets/cards/3_of_spades.svg"],
            "4" =>  [4, "../assets/cards/4_of_spades.svg"],
            "5" => [5, "../assets/cards/5_of_spades.svg"],
            "6" => [6, "../assets/cards/6_of_spades.svg"],
            "7" => [7, "../assets/cards/7_of_spades.svg"],
            "8" => [8, "../assets/cards/8_of_spades.svg"],
            "9" => [9, "../assets/cards/9_of_spades.svg"],
            "10" => [10, "../assets/cards/10_of_spades.svg"],
            "jack" => [10, "../assets/cards/jack_of_spades.svg"],
            "queen" => [10, "../assets/cards/queen_of_spades.svg"],
            "king" => [10, "../assets/cards/king_of_spades.svg"]
        ]
    ];
    $_SESSION["playingcards"] = $playingcards;
}


//function to draw a card from the deck Player
function drawCard_Player($playingcards)
{
    $playingcards = $_SESSION['playingcards'];
    //draw random card
    $suit = array_rand($playingcards);
    $card = array_rand($playingcards[$suit]);

    //check if card is already used
    if (isset($_SESSION['usedcards'])) {
        $usedcardsplayer = $_SESSION['usedcards'];
        while (isset($usedcards[$suit][$card])) {
            $suit = array_rand($playingcards);
            $card = array_rand($playingcards[$suit]);
        }
    }
    //get card value and image
    $cardValue = $playingcards[$suit][$card][0];
    $cardImage = $playingcards[$suit][$card][1];

    //save outcome and set playercards session
    if (isset($_SESSION["playercards"]) && is_array($_SESSION["playercards"])) {
        array_push($_SESSION['playercards'], $cardImage);
    } else {
        $playercards = [];
        $_SESSION["playercards"] = [];
        array_push($_SESSION['playercards'], $cardImage);
    }

    if (isset($_SESSION["usedcards"])) {
        $_SESSION['usedcards'][$suit][$card] = $playingcards[$suit][$card];
    } else {
        $usedcards = [];
        $_SESSION["usedcards"] = [];
        $_SESSION['usedcards'][$suit][$card] = $playingcards[$suit][$card];
    }

    //check if playerscore is set
    if (isset($_SESSION["playerscore"])) {
        $_SESSION['playerscore'] += $cardValue;
    } else {
        $playerscore = 0;
        $_SESSION["playerscore"] = 0;
        $_SESSION['playerscore'] += $cardValue;
    }   
}

//function to draw a card from the deck Dealer
function drawCard_Dealer($playingcards)
{
    $playingcards = $_SESSION['playingcards'];
    //draw random card
    $suit = array_rand($playingcards);
    $card = array_rand($playingcards[$suit]);

    //check if card is already used
    if (isset($_SESSION['usedcards'])) {
        $usedcardsplayer = $_SESSION['usedcards'];
        while (isset($usedcards[$suit][$card])) {
            $suit = array_rand($playingcards);
            $card = array_rand($playingcards[$suit]);
        }
    }
    //get card value and image
    $cardValue = $playingcards[$suit][$card][0];
    $cardImage = $playingcards[$suit][$card][1];

    //save outcome and set dealercards session
    if (isset($_SESSION["dealercards"]) && is_array($_SESSION["dealercards"])) {
        array_push($_SESSION['dealercards'], $cardImage);
    } else {
        $dealercards = [];
        $_SESSION["dealercards"] = [];
        array_push($_SESSION['dealercards'], $cardImage);
    }
    //check if usedcards is set
    if (isset($_SESSION["usedcards"])) {
        $_SESSION['usedcards'][$suit][$card] = $playingcards[$suit][$card];
    } else {
        $usedcards = [];
        $_SESSION["usedcards"] = [];
        $_SESSION['usedcards'][$suit][$card] = $playingcards[$suit][$card];
    }

    //check if playerscore is set
    if (isset($_SESSION["dealerscore"])) {
        $_SESSION['dealerscore'] += $cardValue;
    } else {
        $playerscore = 0;
        $_SESSION["dealerscore"] = 0;
        $_SESSION['dealerscore'] += $cardValue;
    }   
}