<?php

//Login check, dont remove!
include_once('connection.php');

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <!-- The font, dont remove!! -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div>
            <img src="assets/images/logo.png" alt="Logo">
            <h2>90 Casino</h2>
        </div>
        <div>
            <a href="settings.php">Settings</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="container">
        <section>
            <div class="info-card">
                <div onclick="window.location='games/blackjack.php';" class="game-card">
                    <img src="assets/images/blackjack.jpg" />
                    <span>
                        <p>Blackjack</p>
                        <button>Play</button>
                    </span>
                </div>
                <div class="info-card-info">
                    <h4>Blackjack</h4>
                    <p>Experience the classic allure of online Blackjack at our casino! Aim for 21 and beat the dealer in this card game of skill and chance. With smooth graphics, it's a captivating casino adventure!</p>
                </div>
            </div>

            <div class="info-card">
                <div onclick="window.location='games/roulette.php';" class="game-card">
                    <img src="assets/images/roulette.jpg" />
                    <span>
                        <p>Russian roulette</p>
                        <button>Play</button>
                    </span>
                </div>
                <div class="info-card-info">
                    <h4>Russian roulette</h4>
                    <p>Welcome to Russian Roulette Showdown, a heart-pounding casino game that blends chance and strategy. Test your nerve against the revolver's chamber in this high-stakes adventure for a thrilling experience!</p>
                </div>
            </div>

            <div class="info-card">
                <div onclick="window.location='games/higher-or-lower.php';" class="game-card">
                    <img src="assets/images/higher-or-lower.png" />
                    <span>
                        <p>Higher or lower</p>
                        <button>Play</button>
                    </span>
                </div>
                <div class="info-card-info">
                    <h4>Higher or lower</h4>
                    <p>Welcome to the High-Low Card Challenge! Test your predictive skills by guessing if the next card is higher or lower. Double your points with each correct guess!</p>
                </div>
            </div>

            <div class="info-card">
                <div onclick="window.location='games/heads-or-tails.php';" class="game-card">
                    <img src="assets/images/heads-or-tails.jpg" />
                    <span>
                        <p>Heads or tails</p>
                        <button>Play</button>
                    </span>
                </div>
                <div class="info-card-info">
                    <h4>Heads or tails</h4>
                    <p>Welcome to the Heads or Tails game. The concept is straightforward: predict whether the next coin flip will result in heads or tails. It's a battle between luck and intuition.</p>
                </div>
            </div>

            <div class="info-card">
                <div onclick="window.location='games/slotmachine.php';" class="game-card">
                    <img src="assets/images/slotmachine.png" />
                    <span>
                        <p>Slotmachine</p>
                        <button>Play</button>
                    </span>
                </div>
                <div class="info-card-info">
                    <h4>Slotmachine</h4>
                    <p>Welcome to Slot Machine! Spin the reels, match symbols, and chase the jackpot. Feel the excitement as luck unfolds with each spin. Place your bets and let the reels decide your fortune!</p>
                </div>
            </div>
        </section>

        <aside>
            <div class="aside-container">
                <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg> <?= $user['credits'] ?></div>
                <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg> <?= $user['username'] ?></div>
            </div>
            <div class="leaderboard">
                <h4>Leaderboard:</h4>
                <p><b>1.</b> admin <i>Credits: 4029</i></p>
                <p><b>2.</b> henk <i>Credits: 3029</i></p>
                <p><b>3.</b> William <i>Credits: 1029</i></p>
            </div>
            <img onclick="window.open('http://lookingfor4.nl', '_blank');" class="ad" src="assets/images/ad1.png" alt="ad">
        </aside>
    </div>

    <footer>
        <div>
            <img src="assets/images/logo.png">
            <h4>90 Casino</h4>
        </div>

        <div>
            <p>Made by: Lennard, Kars, Sven, Dominique</p>
        </div>
    </footer>
</body>

</html>