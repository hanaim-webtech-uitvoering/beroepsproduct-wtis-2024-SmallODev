<?php
session_start();
require_once 'db_connectie.php';
$db = maakVerbinding();
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

<?php
if (isset($_SESSION['ingelogged']) && $_SESSION['ingelogged']) {
    $username = $_SESSION['username'];

    $userOrdersSql = "SELECT pizza_order_product.product_name, pizza_order.status, Pizza_Order.order_id, quantity
                        FROM pizza_order_product
                        JOIN pizza_order 
                        ON pizza_order.order_id = pizza_order_product.order_id
                        WHERE pizza_order.client_username = :username";
    $userOrdersQuery = $db->prepare($userOrdersSql);
    $userOrdersQuery->execute([':username' => $username]);
    $userOrders = $userOrdersQuery->fetchAll();
    $lastId = null;

    echo "<div id='profielList'>";
    echo "<h1> Welkom $username </h1>";
    foreach ($userOrders as $order) {
        if ($lastId !== $order['order_id']) {
            if ($lastId !== null) {
                echo "</ul>"; 
            }
            if($order['status'] == 1)
            {
                $status = 'Uw Bestelling word bereid';
            }
            if($order['status'] == 2)
            {
                $status = 'Uw bestelling is onderweg';
            }
            if($order['status'] == 3)
            {
                $status = 'Uw bestelling is bezorgd';
            }
            echo "<p class='bestelNummerTitel'>Bestelnummer #{$order['order_id']} (Status: $status)</p>";
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