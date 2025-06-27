<?php 
session_start();
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'header.php';

if($_SESSION['role'] != 'Personnel')
{
    header('location: index.php');
    exit;
}

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $order_id = $_POST['order_id'];
    $order_status = $_POST['status'];

    if(is_numeric($order_id) && is_numeric($order_status))
    {
        $statusSql = "UPDATE pizza_order
                        SET status = :status
                        WHERE order_id = :order_id";
        $statusQuery = $db->prepare($statusSql);
        $statusQuery->execute([':status' => $order_status, ':order_id' => $order_id]);
    }

    
}


if (isset($_SESSION['ingelogged']) && $_SESSION['ingelogged']) {
    $username = $_SESSION['username'];

    $OrderSql = 
               "SELECT Pizza_Order.order_id, pizza_order_product.product_name, quantity, [User].first_name, [User].last_name, [User].address, pizza_order.status, datetime
                FROM pizza_order_product
                JOIN pizza_order 
                ON pizza_order.order_id = pizza_order_product.order_id
                JOIN [User]
                ON [User].username = Pizza_Order.client_username
                ORDER BY
                datetime asc";
    $orderQuery = $db->prepare($OrderSql);
    $orderQuery->execute();
    $orders = $orderQuery->fetchAll();
    $lastId = null;

    echo "<div id='profielList'>";
    echo "<h1> Welkom $username </h1>";
    foreach ($orders as $order) {

        if($order['status'] == 1)
            {
                $status = 'Bestelling word bereid';
            }
            if($order['status'] == 2)
            {
                $status = 'Bestelling is onderweg';
            }
            if($order['status'] == 3)
            {
                $status = 'Bestelling is bezorgd';
            }
        if($order['address'] == null)
        {
            $order['address'] = 'geen adres';
        }
        if ($lastId !== $order['order_id']) {
            if ($lastId !== null) {
                echo "</ul>"; 
            }
            echo "<p class='bestelNummerTitel'>Bestelnummer #{$order['order_id']} (Status: $status) 
                <form method='post'>
                    <select name='status' id='status'>
                        <option value='1'>Bereiden</option>
                        <option value='2'>Onderweg</option>
                        <option value='3'>Bezorgd</option>
                    </select>
                    <input type='hidden' name='order_id' value='{$order['order_id']}'>
                    <input type='submit' value='Pas status aan'>
                </form>
            </p>";
            echo "<p>Besteller: {$order['first_name']} {$order['last_name']}</p>";
            echo "<p>Adres: {$order['address']}</p>";
            echo "<p>Besteltijd {$order['datetime']}</p>";
            echo "<ul>";
            $lastId = $order['order_id'];
        }
        echo "<li>{$order['product_name']}: {$order['quantity']}</li>";
    }
    if ($lastId !== null) {
        echo "</ul>";
    }
    echo '</div>';
}
?>


<body>

</body>

</html>