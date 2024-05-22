<?php
//Login check, dont remove!
include_once('../connection.php');

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: ../login.php');
    die();
}

function start($user, $pdo)
{
    if (!isset($_SESSION["bet_amount"])) {
        $_SESSION["bet_amount"] = 1;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //set the bet amount in a session
        $_SESSION["bet_amount"] = $_POST["headsandteals-input"];

        $chosen = $_POST["chosen"];
        //checks for valid bet amount and if enough credits
        if ($user['credits'] <= 0 || $user['credits'] < $_SESSION["bet_amount"] || $_SESSION["bet_amount"] <= 0) {
            echo "<p id='msg' style='color:red;'>invalid bet or not enough credits.</p>";
            return;
        }
        //generates a random number
        $random = rand(0, 1);

        $lostbet = $_SESSION["bet_amount"];
        $winbet = $_SESSION["bet_amount"] * 2;

        if ($random == $chosen) {
            $newCredits = $user['credits'] + $winbet;
            echo "<p id='msg'>You won! +$winbet </p>";
        } else {
            $newCredits = $user['credits'] - $_SESSION["bet_amount"];
            echo "<p id='msg' style='color:red;'>You lost! -$lostbet </p>";
        }

        // if ($_SESSION['random'] == 0) {
        //     echo '<img src="../assets/images/tail.png" width="150">';
        // } else {
        //     echo '<img src="../assets/images/head.png" width="150">';
        // }

        //updates the won or lost credits to the database
        $updateQuery = "UPDATE users SET credits = :credits WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':credits', $newCredits, PDO::PARAM_INT);
        $loggedInUserId = $_SESSION['loggedInUser'];
        $updateStmt->bindParam(':id', $loggedInUserId, PDO::PARAM_INT);
        $updateStmt->execute();

        $_SESSION['newCredits'] = $newCredits;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino - Heads or tails</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- The font, dont remove!! -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
    .headstails-form div:first-child {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .headstails-form {
        margin: 10px;
    }
</style>

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
        <h2>Heads or Tails</h2>
        <form id="form" class="headstails-form" method="post">
            <div>
                <div class="radio-container">
                    <div class="radio-wrapper">
                        <label class="radio-button">
                            <input checked type="radio" id="heads" name="chosen" value="1">
                            <span class="radio-checkmark"></span>
                            <img src="../assets/images/head.png" width="80">
                        </label>
                    </div>
                    <i>or..</i>
                    <div class="radio-wrapper">
                        <label class="radio-button">
                            <input type="radio" id="tails" name="chosen" value="0" required>
                            <span class="radio-checkmark"></span>
                            <img src="../assets/images/tail.png" width="80">
                        </label>
                    </div>
                </div>
            </div>
            <?php

            $_SESSION['newCredits'] = $user['credits'];

            start($user, $pdo);

            echo '<div class="back"><a href="../index.php"><svg style="width:25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M12.5 9.75A2.75 2.75 0 0 0 9.75 7H4.56l2.22 2.22a.75.75 0 1 1-1.06 1.06l-3.5-3.5a.75.75 0 0 1 0-1.06l3.5-3.5a.75.75 0 0 1 1.06 1.06L4.56 5.5h5.19a4.25 4.25 0 0 1 0 8.5h-1a.75.75 0 0 1 0-1.5h1a2.75 2.75 0 0 0 2.75-2.75Z" clip-rule="evenodd" />
            </svg>Back home</a><hr><p>Credits: ' . $_SESSION['newCredits'] . '</p></div>';

            if (!isset($_POST["headsandteals-input"])) {
                echo "<p id='msg'>Welcome to head or tails!</p>";
            }

            ?>

            <input name="headsandteals-input" id="slots-input" type="number" placeholder="Enter bet amount!" required value="<?php echo $_SESSION["bet_amount"]; ?>">
            <button type="submit">Submit</button>
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
    <script src="../assets/js/jquery-headstails.js"></script>
</body>

</html>