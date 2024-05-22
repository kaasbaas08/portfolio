<?php

include_once('connection.php');

// Login check, don't remove!
if (isset($_SESSION['loggedInUser'])) {
    header('Location: index.php');
    die();
}

unset($_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeat'];

    if ($password !== $repeatPassword) {
        $_SESSION['error'] = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $pdo->prepare("INSERT INTO users (username, password, credits) VALUES (:username, :password, 45)");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($query->execute()) {
            header("Location: login.php");
            die();
        } else {
            $_SESSION['error'] = "Error registering user.";
        }
    }
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
    </header>

    <form class="accountsystem" method="post">
        <img class="logo" src="assets/images/logo.png" alt="Logo">

        <?php if (isset($_SESSION['error'])) { ?>
            <div style="color: red;"><?= $_SESSION['error']; ?></div>
        <?php } ?>

        <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg><input autofocus minlength="2" maxlength="15" type="text" name="username" placeholder="Username" required></div>

        <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
            </svg><input minlength="5" maxlength="256" type="password" name="password" placeholder="Password" required></div>

        <div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
            </svg><input minlength="5" maxlength="256" type="password" name="repeat" placeholder="Repeat Password" required></div>

        <div style="box-shadow: none;">
            <input type="checkbox" id="age" name="age" required style="width: unset; min-width: unset;" />
            <label for="age">I'm older than 16.</label>
        </div>
        <button name="register" type="submit">Register</button>
        <span>
            <i>Or..</i>
            <a href="login.php">Login</a>
        </span>
    </form>

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