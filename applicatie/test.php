<?php
require_once 'db_connectie.php';


?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$db = maakVerbinding();

$query = "
SELECT name AS name, type_id AS type_id, price AS price
FROM product
ORDER BY type_id;
";


$data = $db->query($query);

$menukaart = '<table id="tabel">';

$menukaart = $menukaart .'<tr><th>Soort</th><th>Naam</th><th>Prijs</th></tr>';

foreach($data as $rij) {
    $type = $rij['type_id'];
    $name = $rij['name'];
    $price = $rij['price'];

    $menukaart = $menukaart . "<tr><td>$type</td><td>$name</td><td>$price</td><td><button>Toevoegen aan winkelwagentje</button></td></tr>";
    }


$menukaart = $menukaart . '</table>';

print $menukaart;

var_dump($_POST);

$test = $_GET['Sprite'];

$bestelling = "<p>";

$bestelling = $bestelling .$test;

$bestelling = $bestelling ."dikke ballen";

$bestelling = $bestelling ."</p>";


print($test);




?>
    
</body>
</html>