<?php 

require_once 'db_connectie.php';
require_once 'header.php';
$db = maakVerbinding();
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

    session_start();

   if(isset($_POST['item'])){
    $geselecteerd = $_POST['item'];
    if(isset($_SESSION['winkelmand']["$geselecteerd"]))
    {
     $_SESSION['winkelmand']["$geselecteerd"] +=1;
    } else {

    $_SESSION['winkelmand']["$geselecteerd"] = 1; 
    }
    unset($_POST['item']);
    header("Location: winkelwagentje.php");
   }

   
   $winkelwagen = '<table id="winkelwagen">';

   if (isset($_POST['product'])) {
       $product = $_POST['product'];
   
       if (isset($_SESSION['winkelmand'][$product])) {
           $_SESSION['winkelmand'][$product]++;
       } else {
           $_SESSION['winkelmand'][$product] = 1;
       }
   
       header("Location: winkelwagentje.php");
       exit;
   }
   
   if (isset($_POST['productmin'])) {
       $product = $_POST['productmin'];
   
       if (isset($_SESSION['winkelmand'][$product])) {
           $_SESSION['winkelmand'][$product]--;
           if ($_SESSION['winkelmand'][$product] <= 0) {
               unset($_SESSION['winkelmand'][$product]);
           }
       }
   
       header("Location: winkelwagentje.php");
       exit;
   }
   
   $winkelwagen = '<table id="winkelwagenList">';
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
   
   $winkelwagen .= "
   <tr><td>
        <button>
            <a href='bestellen.php'>bestellen</a>
        </button>
    </td></tr>";

    $winkelwagen .='</table>'; 

    print($winkelwagen);


        ?>


    
</body>

</html>