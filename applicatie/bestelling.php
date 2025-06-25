<?    if(isset($_POST['bestel'])){
        $order_id = (int)$_POST['bestel'];
        $query->execute([':order_id' => $order_id]);
        $data = $query -> fetch();
   
    }php 

require_once( 'db_connectie.php');
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
    <?php
        $verbinding = maakVerbinding();
        $sql = "select status from pizza_order where order_id = :order_id";
        $query = $verbinding->prepare($sql);

    

    $check_bestelling = "<p>";

    $check_bestelling .=
       "<form id='line' method='post' action='bestelling.php'>
            <input type='number' name='bestel'>
            <input type='submit' value='Check bestelling'>
        </form>";

    $check_bestelling .="</p>";
    
    


    $status = "<p id='line2'>";

    if ($data[0] == 1) {
        $status .= 'Je bestelling zit in de oven';
    } elseif ($data[0] == 2) {
        $status .= 'Je bestelling wordt bezorgd';
    } elseif ($data[0] == 3) {
        $status .= 'Je bestelling is bezorgd';
    } else {
        $status .= 'Bestelnummer bestaat niet';
    }
    

    $status .= '</p>';

    print($status);
    print($check_bestelling);


    ?>

</body>

</html>