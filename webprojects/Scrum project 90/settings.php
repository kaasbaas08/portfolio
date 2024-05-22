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
    <title>Casino - Settings</title>
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
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>
</body>

</html>