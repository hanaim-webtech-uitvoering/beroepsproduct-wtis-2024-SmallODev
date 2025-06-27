<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzaria Sole Machina</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="styling.css">
</head>
<?php
$wwfout = false;
$mistakesMade;
$_SESSION['ingelogged'] = false;
session_start();
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'header.php';

$mistakes = [];

if (isset($_SESSION['ingelogged'])) {
    if ($_SESSION['ingelogged'] == true) {
        header('location: index.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        $loginSql = 'SELECT username, password, role, first_name, address FROM [User] WHERE username = :username';
        $loginQuery = $db->prepare($loginSql);
        $loginQuery->execute([':username' => $username]);
        $user = $loginQuery->fetch();

        echo '<br>';
        echo '<br>';
        if ($user == false) {
            echo '<div id="mistakes">Wachtwoord of Gebruikersnaam klopt niet</div>';
            $_SESSION['ingelogged'] = false;
        } else {
            if (password_verify($password, $user['password'])) {
                $_SESSION['ingelogged'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['first_name'];
                $_SESSION['address'] = $user['address'];
            } else {
                $_SESSION['ingelogged'] = false;
                $wwfout = true;
            }
        }

        if (strlen($username) > 255) {
            $mistakes[] = 'Gebruikersnaam mag niet langer zijn dan 255 characters';
        }
    }

    if (isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $address = htmlspecialchars($_POST['address']);
        $username = htmlspecialchars($_POST['usernameRegister']);
        $password1 = htmlspecialchars($_POST['password1']);
        $password2 = htmlspecialchars($_POST['password2']);


        //naam sanitisation
        if (empty($name)) {
            $mistakes[] = 'Naam is verplicht';
        }
        if (strlen($name) > 255) {
            $mistakes[] = 'Naam mag niet langer zijn dan 255 characters';
        }
        if (!preg_match("/^[\p{L}\s'-]+$/u", $name)) {
            $mistakes[] = 'Uw naam mag alleen letters bevatten';
        }

        //achternaam sanitisation
        if (empty($lastname)) {
            $mistakes[] = 'Achternaam is verplicht';
        }
        if (strlen($lastname) > 255) {
            $mistakes[] = 'Achternaam mag niet langer zijn dan 255 characters';
        }
        if (!preg_match("/^[\p{L}\s'-]+$/u", $lastname)) {
            $mistakes[] = 'Uw achternaam mag alleen letters bevatten';
        }

        //adres sanitisation
        if (empty($address)) {
            $mistakes[] = 'Adres is verplicht';
        }
        if (strlen($address) > 255) {
            $mistakes[] = 'address mag niet langer zijn dan 255 characters';
        }

        //gebruikersnaam sanitisation
        if (empty($username)) {
            $mistakes[] = 'Gebruikersnaam is verplicht';
        }
        if (strlen($username) > 255) {
            $mistakes[] = 'Gebruikersnaam mag niet langer zijn dan 255 characters';
        }


        //wachtwoord sanitisation
        if (empty($password1)) {
            $mistakes[] = 'Wachtwoord is verplicht';
        }
        if (empty($password2)) {
            $mistakes[] = 'Wachtwoord moet herhaald worden';
        }
        if (strlen($password1) > 255) {
            $mistakes[] = 'Wachtwoord mag niet langer zijn dan 255 characters';
        }

        if ($password1 != $password2) {
            $mistakes[] = 'Wachtwoorden moeten overeen komen';
        }

        if (count($mistakes) > 0) {
            $mistakesMade = true;
        } else {
            $usernameCheckSql = "select count(username) from [User] where username = :username";
            $usernameCheckQuery = $db->prepare($usernameCheckSql);
            $usernameCheckQuery->execute([':username' => $username]);
            $usernameCount = $usernameCheckQuery->fetch();
            print_r($usernameCount);
            if ($usernameCount[0] == 0) {

                $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

                $registerSql = "INSERT INTO [User] (username, password, first_name, last_name, address, role)
                            VALUES(:username, :password, :firstname, :lastname, :address, :role)";
                $registerQuery = $db->prepare($registerSql);
                $registerQuery->execute([':username' => $username, ':password' => $hashedPassword, ':firstname' => $name, ':lastname' => $lastname, ':address' => $address, ':role' => 'Client']);
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'Client';
                $_SESSION['ingelogged'] = true;
            } else {
                echo '<div id="wwfout">gebruikersnaam is al in gebruik</div>';
            }
        }
    }
    if (isset($_SESSION['ingelogged'])) {
        if ($_SESSION['ingelogged'] == true) {
            header('location: index.php');
        }
    }
}

?>

<body>

    <?php
    if ($wwfout) {
        echo '<div id="mistakes">Wachtwoord of Gebruikersnaam klopt niet</div>';
    }
    ?>

    <form method="POST" id="login">
        <label for="#">Log In</label>
        <label for="username">Gebruikersnaam</label>
        <input type="text" name="username" id="username">
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Log In">
    </form>

    <form method="POST" id="register">
        <label for="#">Registeren</label>
        <label for="name">Naam</label>
        <input type="text" name="name" id="name">
        <label for="lastname">Achternaam</label>
        <input type="text" name="lastname" id="lastname">
        <label for="address">adres</label>
        <input type="text" name="address" id="adress">
        <label for="usernameRegister">Gebruikersnaam</label>
        <input type="text" name="usernameRegister" id="usernameRegister">
        <label for="password1">Wachtwoord</label>
        <input type="password" name="password1" id="password1">
        <label for="password2">Wachtwoord Herhalen</label>
        <input type="password" name="password2" id="password2">
        <input type="submit" value="Registreren">
    </form>
    <?php

    if($mistakesMade)
    {
    echo '<p id="mistakes">';
    foreach ($mistakes as $mistake) {
        echo $mistake;
        echo '<br>';
    }
    echo '</p>';
}
    ?>

</body>

</html>