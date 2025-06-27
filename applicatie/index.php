<?php 
session_start();
require_once 'db_connectie.php';
require_once 'header.php';
$menuknop =0;
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
    
    <?php
    
        $winkelwagen = array();

        $db = maakVerbinding();

        $query = "
        SELECT name AS name, type_id AS type_id, price AS price
        FROM product
        ORDER BY type_id;
        ";


        $data = $db->query($query);

        $menukaart = '<table id="menukaart">';

        $menukaart = $menukaart .'<tr><th>Soort</th><th>Naam</th><th>Prijs</th></tr>';

 
        foreach($data as $rij) {
            $type = $rij['type_id'];
            $name = $rij['name'];
            $price = $rij['price'];
            $menuknop = $menuknop +1;

            $menukaart = $menukaart . "<tr><td>$type</td><td>$name</td><td>$price</td><td>


             <form method='POST' action='winkelwagentje.php'>
                <input type='hidden' name='item' value='$name'>
                <input type='hidden' name='price' value='$price'>
                <input type='submit' value='toevoegen aan mandje'>
            </form>
            
            ";
                        
            }


        $menukaart = $menukaart . '</table>';

        print $menukaart;

        var_dump($_GET);
        var_dump($menukaart);


        ?>


</body>

</html>