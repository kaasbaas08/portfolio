<?php
// Login check, don't remove!
include_once('../connection.php');

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: ../login.php');
    die();
}

function gameLogic()
{
    $slotItems = array(
        "1" => "../assets/slotitems/1.svg",
        "2" => "../assets/slotitems/2.svg",
        "3" => "../assets/slotitems/3.svg",
        "4" => "../assets/slotitems/4.svg",
        "5" => "../assets/slotitems/5.svg",
        "6" => "../assets/slotitems/6.svg",
        "7" => "../assets/slotitems/7.svg",
        "8" => "../assets/slotitems/8.svg",
        "9" => "../assets/slotitems/9.svg",
        "10" => "../assets/slotitems/10.svg",
        "11" => "../assets/slotitems/11.svg",
    );

    $generatedImages = array();
    for ($i = 0; $i < 3; $i++) {
        $randomKey = array_rand($slotItems);
        $generatedImages[] = $slotItems[$randomKey];
        echo '<img src="' . $slotItems[$randomKey] . '">';
    }

    // Check for winning combinations and set win amount
    $winamount = checkWin($generatedImages);
    $_SESSION['win_amount'] = $winamount;
}

function checkWin($images)
{
    $symbolMap = [
        "1.svg" => 1, "2.svg" => 2, "3.svg" => 3, "4.svg" => 4,
        "5.svg" => 5, "6.svg" => 6, "7.svg" => 7, "8.svg" => 8,
        "9.svg" => 9, "10.svg" => 10, "11.svg" => 11
    ];

    // Convert image paths to numbers and count occurrences
    $symbolCounts = array_count_values(array_map(function ($image) use ($symbolMap) {
        return $symbolMap[basename($image)];
    }, $images));

    // combinations
    $winningCombinations = [
        '1' => ['multiplier' => 2, 'jackpot' => 5],
        '2' => ['multiplier' => 2, 'jackpot' => 5],
        '3' => ['multiplier' => 2, 'jackpot' => 10],
        '4' => ['multiplier' => 3, 'jackpot' => 10],
        '5' => ['multiplier' => 3, 'jackpot' => 20],
        '6' => ['multiplier' => 3, 'jackpot' => 20],
        '7' => ['multiplier' => 4, 'jackpot' => 30],
        '8' => ['multiplier' => 4, 'jackpot' => 30],
        '9' => ['multiplier' => 4, 'jackpot' => 40],
        '10' => ['multiplier' => 5, 'jackpot' => 40],
        '11' => ['multiplier' => 10, 'jackpot' => 100],
    ];

    // Check for winning combination
    foreach ($symbolCounts as $symbol => $count) {
        if ($count >= 3 && array_key_exists($symbol, $winningCombinations)) {
            return $winningCombinations[$symbol]['jackpot'] * $_SESSION["bet_amount"];
        } elseif ($count >= 2 && array_key_exists($symbol, $winningCombinations)) {
            return $winningCombinations[$symbol]['multiplier'] * $_SESSION["bet_amount"];
        }
    }

    return 0;
}

function start($user, $pdo)
{
    if (!isset($_SESSION["bet_amount"])) {
        $_SESSION["bet_amount"] = 1;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION["bet_amount"] = $_POST["slots-input"];

        if ($user['credits'] <= 0 || $user['credits'] < $_SESSION["bet_amount"] || $_SESSION["bet_amount"] <= 0) {
            echo "<script>var msg = document.getElementById('msg');
            msg.innerHTML= 'invalid bet or not enough credits.';
            msg.style.color = 'red';</script>";
            for ($i = 0; $i < 3; $i++) {
                echo '<img src="../assets/images/logo.png">';
            }
            return;
        }

        //Generates the images and generates the win or losses.
        gameLogic();

        $winamount = $_SESSION['win_amount'];

        if ($winamount > 0) {
            $newCredits = $user['credits'] + ($winamount);
            echo "<script>var msg = document.getElementById('msg');
            msg.innerHTML= '+$winamount credits!';
            msg.style.color = 'green';</script>";
        } else {
            $newCredits = $user['credits'] - $_SESSION["bet_amount"];
            echo "<script>var msg = document.getElementById('msg');
            msg.innerHTML= 'You lost $_SESSION[bet_amount] credits.';
            msg.style.color = 'red';</script>";
        }
        //updates the lost or win credits
        $updateQuery = "UPDATE users SET credits = :credits WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':credits', $newCredits, PDO::PARAM_INT);
        $loggedInUserId = $_SESSION['loggedInUser'];
        $updateStmt->bindParam(':id', $loggedInUserId, PDO::PARAM_INT);
        $updateStmt->execute();

        $_SESSION['newCredits'] = $newCredits;
    } else {
        for ($i = 0; $i < 3; $i++) {
            echo '<img src="../assets/images/logo.png">';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino - Slot machine</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- The font, dont remove!! -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
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
    <main>
        <h2>Slot machine</h2>
        <form id="form" method="post">
            <section>
                <?php

                $_SESSION['newCredits'] = $user['credits'];

                start($user, $pdo);

                echo '<div class="back"><a href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M12.5 9.75A2.75 2.75 0 0 0 9.75 7H4.56l2.22 2.22a.75.75 0 1 1-1.06 1.06l-3.5-3.5a.75.75 0 0 1 0-1.06l3.5-3.5a.75.75 0 0 1 1.06 1.06L4.56 5.5h5.19a4.25 4.25 0 0 1 0 8.5h-1a.75.75 0 0 1 0-1.5h1a2.75 2.75 0 0 0 2.75-2.75Z" clip-rule="evenodd" />
                    </svg>Back home</a><hr><p>Credits: ' . $_SESSION['newCredits'] . '</p></div>';

                ?>

            </section>
            <p id="msg">Welcome to slots!</p>

            <input name="slots-input" id="slots-input" type="number" placeholder="Enter bet amount!" value="<?php echo $_SESSION["bet_amount"]; ?>" required>
            <button type="submit">Spin</button>
        </form>
    </main>
    <footer>
        <div>
            <img src="../assets/images/logo.png">
            <h4>90 Casino</h4>
        </div>

        <div>
            <p>Made by: Lennard, Kars, Sven, Dominique</p>
        </div>
    </footer>
    <script src="../assets/js/jquery-slots.js"></script>
</body>

</html>