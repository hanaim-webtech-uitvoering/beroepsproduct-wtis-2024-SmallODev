<?php 

require_once 'db_connectie.php';
require_once 'header.php';
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


    <p class="timeline">
       <img class="timeline-image" src="fotos/bereiding.png" alt="Je pizza word bereid"> 
       <img class="timeline-image" src="fotos/inoven.png" alt="Je pizza zit in de oven"> 
       <img class="timeline-image" src="fotos/onderweg.png" alt="Je pizza is onderweg"> 
       <img class="timeline-image" src="fotos/bezorgd.png" alt="Je pizza is bezord"> 
        
    </p>
    <p>
        <p class="bestelling">
            bestelling 1
        </p>
        <ul class="bestellinglijst">
            <li>
                1 pizza mozzarella
            </li>
            <li>
                1 tomaaten pizza
            </li>
            <li>
                1 kaas pizza
            </li>
        </ul>
        <select  class="dropdown" name="Status" >
            <option value="Bereiding">Bereiding</option>
            <option value="InOven">InOven</option>
            <option value="Onderweg">Onderweg</option>
            <option value="Bezorgd">Bezord</option>
          </select>
    


    <p class="timeline">
       <img class="timeline-image" src="fotos/bereiding.png" alt="Je pizza word bereid"> 
       <img class="timeline-image" src="fotos/inoven.png" alt="Je pizza zit in de oven"> 
       <img class="timeline-image" src="fotos/onderweg.png" alt="Je pizza is onderweg"> 
       <img class="timeline-image" src="fotos/bezorgd.png" alt="Je pizza is bezord"> 
        
    </p>
    <p>
        <p class="bestelling">
            bestelling 2
        </p>
        <ul class="bestellinglijst">
            <li>
                1 pizza hawaii
            </li>
            <li>
                1 kaas pizza
            </li>
            <li>
                1 calzone
            </li>
        </ul>
        <select  class="dropdown" name="Status" >
            <option value="Bereiding">Bereiding</option>
            <option value="InOven">InOven</option>
            <option value="Onderweg">Onderweg</option>
            <option value="Bezorgd">Bezord</option>
          </select>


    <p class="timeline">
       <img class="timeline-image" src="fotos/bereiding.png" alt="Je pizza word bereid"> 
       <img class="timeline-image" src="fotos/inoven.png" alt="Je pizza zit in de oven"> 
       <img class="timeline-image" src="fotos/onderweg.png" alt="Je pizza is onderweg"> 
       <img class="timeline-image" src="fotos/bezorgd.png" alt="Je pizza is bezord"> 
        
    </p>
    <p>
        <p class="bestelling">
            bestelling 3
        </p>
        <ul class="bestellinglijst">
            <li>
                1 pizza salami
            </li>
            <li>
                3 tomaaten pizzas
            </li>

        </ul>
        <select  class="dropdown" name="Status" >
            <option value="Bereiding">Bereiding</option>
            <option value="InOven">InOven</option>
            <option value="Onderweg">Onderweg</option>
            <option value="Bezorgd">Bezord</option>
          </select>
    

</body>

</html>