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



<body>

    <!-- <header>
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
    
    
    
    </header> -->


</body>


<?php

var_dump($_SESSION);
var_dump($_POST);
   
$winkelwagen = '<table id="winkelwagen">';
foreach ($_SESSION['winkelmand'] as $product => $aantal) {
    $winkelwagen .= "
    <tr>
        <td>$product</td>
        <td>$aantal</td>
        <td>
            <form action='winkelwagentje.php' method='post' style='display:inline;'>
                <input type='hidden' name='productmin' value='$product'>
                <button type='submit'>-</button>
            </form>
            <form action='winkelwagentje.php' method='post' style='display:inline;'>
                <input type='hidden' name='product' value='$product'>
                <button type='submit'>+</button>
            </form>
        </td>
    </tr><tr><td>";
}


$winkelwagen .= "</td></tr>";


 $winkelwagen .='</table>'; 

 print($winkelwagen);

?>

</html>