<?php 

require_once 'db_connectie.php';
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzaria Sole Machina</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="styling.css">
</head>


<header>
        <ul id="NavigatieBalk">
            <li >
                <a href="profiel.php">Profiel</a>
            </li>
            <li >
                <a href="bestelling.php">Bestelling</a>
            </li>
        
        <li >
            <a href="privacy.php">Privacy</a>
        </li>
            <li >
                <a id="Menu" href="index.php">Menu</a>
    
            <li >
                <a href="winkelwagentje.php">Winkelwagentje</a>
            </li>
            <li >
                <a href="Login.php">Log in</a>
            </li>
            <li >
                <a href="personeel.php">Personeel</a>
            </li>
        </ul>
    
        <img id="logo" src="fotos/logo.png" alt="foto van een pizza met text: pizzaria het blok">
    
    
    
    </header>


<body>
<?php 

require_once 'db_connectie.php';
session_start();

$db = maakVerbinding();

if (isset($_POST['username'], $_POST['password'])) {
    $username = ($_POST['username']);
    $password = ($_POST['password']);

    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $sql = "SELECT password, role FROM [user] WHERE username = :username";
        $query = $db->prepare($sql);
        $query->execute([':username' => $username]);
        $user = $query->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['login'] = [
                'logged_in' => true, 'username' => $username,'role' => $user['role']
            ];
            print "<p>Ingelogd als {$username}</p>";
        } else {
            print "<p>Onjuiste gebruikersnaam of wachtwoord</p>";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        if (isset($_POST['naam'], $_POST['achternaam'], $_POST['adres'])) {
            $naam = trim($_POST['naam']);
            $achternaam = trim($_POST['achternaam']);
            $adres = trim($_POST['adres']);

            $sql = "SELECT COUNT(*) 
            FROM [user] 
            WHERE username = :username";
            $query = $db->prepare($sql);
            $query->execute([':username' => $username]);
            $count = $query->fetchColumn();

            if ($count == 0) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO [user] (username, password, first_name, last_name, address, role) 
                        VALUES (:username, :password, :naam, :achternaam, :adres, 'Client')";
                $query = $db->prepare($sql);
                $query->execute([
                    ':username' => $username,':password' => $hashedPassword,':naam' => $naam,':achternaam' => $achternaam,':adres' => $adres
                ]);

                $_SESSION['login'] = [
                    'logged_in' => true,'username' => $username, 'role' => 'Client'
                ];
                print "<p>Registratie succesvol! U bent nu ingelogd als {$username}.</p>";
            } else {
                print "<p>Gebruikersnaam bestaat al. Kies een andere.</p>";
            }
        } else {
            print "<p>Alle velden zijn verplicht voor registratie.</p>";
        }
    }
}

var_dump($_SESSION);
?>


    <table id='login'>
        <form action="" method="post">
            <tr><td>Log In</td></tr>
            <tr><td>Gebruikersnaam</td></tr>
            <tr><td><input type="text" name="username" required></td></tr>
            <tr><td>Wachtwoord</td></tr>
            <tr><td><input type="password" name="password" required></td></tr>
            <tr><td><input type="hidden" name="action" value="login"></td></tr>
            <tr><td><input type="submit" value="Inloggen"></td></tr>
        </form>

        <form action="" method="post">
            <tr><td>Registreer</td></tr>
            <tr><td>Voornaam</td></tr>
            <tr><td><input type="text" name="naam" required></td></tr>
            <tr><td>Achternaam</td></tr>
            <tr><td><input type="text" name="achternaam" required></td></tr>
            <tr><td>Adres</td></tr>
            <tr><td><input type="text" name="adres" required></td></tr>
            <tr><td>Gebruikersnaam</td></tr>
            <tr><td><input type="text" name="username" required></td></tr>
            <tr><td>Wachtwoord</td></tr>
            <tr><td><input type="password" name="password" required></td></tr>
            <tr><td><input type="hidden" name="action" value="register"></td></tr>
            <tr><td><input type="submit" value="Registreren"></td></tr>
        </form>
    </table>

</body>

</html>