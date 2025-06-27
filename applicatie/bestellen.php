<?php
session_start();
require_once 'db_connectie.php';
require_once 'header.php';
$db = maakVerbinding();
$mistakes = [];
$orderSucces = false;
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


<?php
var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['bestelName']);
    $address = htmlspecialchars($_POST['bestelAddress']);

    //naam sanitisation
    if (empty($name)) {
        $mistakes[] = 'Naam is verplicht';
    }
    if (strlen($name) > 255) {
        $mistakes[] = 'Naam mag niet langer zijn dan 255 characters';
    }

    if (!preg_match("/^[\p{L}\p{N}\s]+$/u", $name ?? '')) {
        $mistakes[] = 'Naam mag geen speciale tekens bevatten.';
    }

    //address sanitisation
    if (empty($address)) {
        $mistakes[] = 'Adres is verplicht';
    }
    if (strlen($address) > 255) {
        $mistakes[] = 'Adres mag niet langer zijn dan 255 characters';
    }

    if (!preg_match('/\d/', $address)) {
        $mistakes[] = 'Het adres moet minstens 1 cijfer bevatten.';
    }
    if (!preg_match("/^[\p{L}\p{N}\s]+$/u", $address ?? '')) {
        $mistakes[] = 'Het adres mag geen speciale tekens bevatten.';
    }

    if (count($mistakes) > 0) {
        echo '<p id="mistakes">';
        foreach ($mistakes as $mistake) {
            echo $mistake;
            echo '<br>';
        }
        echo '</p>';
    } else {
        if (isset($_SESSION['winkelmand']) && !empty($_SESSION['winkelmand'])) {
            if (isset($_SESSION['ingelogged']) && $_SESSION['ingelogged']) {
                $username = $_SESSION['username'];
                $name = $_SESSION['name'];
                $address = $_SESSION['address'];
            } else {
                $username = NULL;
                $name = $_POST['bestelName'];
                $address = $_POST['bestelAddress'];
            }

            $orderNumberSql = 'SELECT MAX(order_id) FROM pizza_order';
            $orderNumberQuery = $db->prepare($orderNumberSql);
            $orderNumberQuery->execute();
            $highestOrder = $orderNumberQuery->fetch();

            $date = date("Y-m-d H:i:s");
            $orderId = $highestOrder[0] + 1;

            $personnelSql = "SELECT TOP 1 username FROM [User] where role = 'personnel' ORDER BY NEWID()";
            $personnelQuery = $db->prepare($personnelSql);
            $personnelQuery->execute();
            $personnel = $personnelQuery->fetch();

            $orderSql = "INSERT INTO Pizza_Order( client_username, client_name, personnel_username, datetime, status, address)
                     VALUES(:client_username, :client_name, :personnel_username, :datetime, 1, :address)";
            $orderQuery = $db->prepare($orderSql);
            $orderQuery->execute([':client_username' => $username, ':client_name' => $name, ':personnel_username' => $personnel[0], ':datetime' => $date, ':address' => $address]);


            foreach ($_SESSION['winkelmand'] as $product => $aantal) {
                $orderPizzaSql = "INSERT INTO Pizza_Order_Product(order_id, product_name, quantity)
                         VALUES($orderId, :product_name, :quantity)";
                $orderPizzaQuery = $db->prepare($orderPizzaSql);
                $orderPizzaQuery->execute([':product_name' => $product, ':quantity' => $aantal]);
            }
            $orderSucces = true;
        }
    }
}
?>

<body>

    <div id="bestelling">


        <?php
    if(!empty($_SESSION['winkelmand'])){
        $winkelwagen = '<table id="winkelwagen">';
        foreach ($_SESSION['winkelmand'] as $product => $aantal) {
            $winkelwagen .= "
    <tr>
        <td>$product</td>
        <td>$aantal</td>
    </tr><tr><td>";
        }
                if (isset($_SESSION['ingelogged']) && $_SESSION['ingelogged']) {
            $form = '
<form method="post">
    <label for="naam">Naam</label>
    <input type="text" id="bestelName" name="bestelName" value="' . $_SESSION['name'] . '" required>
    <label for="address">Adres</label>
    <input type="text" id="bestelAddress" name="bestelAddress" value="' . $_SESSION['address'] . '" required>
    <input type="submit" value="bestellen">
</form>';
        } else {
            $form = '<form method="post">
    <label for="naam">Naam</label>
    <input type="text" id="bestelName" name="bestelName" required>
    <label for="address">Adres</label>
    <input type="text" id="bestelAddress" name="bestelAddress" required>
    <input type="submit" value="bestellen">
</form>';
        }

        $winkelwagen .= "</td></tr>";


        $winkelwagen .= '</table>';
                if (!$orderSucces) {
            print($winkelwagen);
        }
                if (!$orderSucces) {
            print($form);
        } else {
            echo "<div id='bestellingGeplaatst'><p> Uw bestelling is geplaatst</p><p> Uw bestelnummer is $orderId</p></div>";
            
        }


    }else
    {
                echo "<p id='winkelwagen'.> Uw winkelwagen is leeg</p>";
    }








        ?>
    </div>
</body>

</html>