<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPHPApp</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

    $host = "localhost";
    $username = "root";
    $password = "root";
    $name = "home_epstein";

    $conn = mysqli_connect($host, $username, $password);

    if ($conn->connect_error) {
        die("Nepodarilo sa pripojiť k DB") . $conn->connect_error();
    }
    else{
        echo "HOORAY! Pripojené k DB";
    }

    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100)
    )";
?>

<form method="$_POST">
    <input placeholder="meno" name="meno" type="text" required>
    <input placeholder="email" name="email" type="email" required>
    <input placeholder="heslo" name="heslo" type="password" required>

    <button type="submit">Odoslať</button>
</form>
</body>
</html>