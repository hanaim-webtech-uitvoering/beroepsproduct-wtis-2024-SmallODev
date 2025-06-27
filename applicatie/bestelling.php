<?php
require_once 'db_connectie.php';
require_once 'header.php';
$db = maakVerbinding();
$mistakes = [];
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
    <div id="bestelContent">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderNumber = htmlspecialchars($_POST['bestel']);

    //orderNumber sanitisation
    if (empty($orderNumber)) {
        $mistakes[] = 'Vul een nummer in';
    }

    if (!is_numeric($orderNumber)) {
        $mistakes[] = 'Vul een geldige waarde in';
    }

    if (count($mistakes) > 0) {
        echo '<p id="mistakes">';
        foreach ($mistakes as $mistake) {
            echo $mistake;
            echo '<br>';
        }
        echo '</p>';
    }
    else
    {
        $orderSql = '
                    SELECT pizza_order_product.product_name, pizza_order_product.quantity, pizza_order.status FROM pizza_order_product
                    JOIN pizza_order 
                    ON pizza_order.order_id = pizza_order_product.order_id
                    WHERE pizza_order_product.order_id = :orderId;';
        $orderQuery = $db->prepare($orderSql);
        $orderQuery->execute([':orderId' => $orderNumber]);
        $order = $orderQuery->fetchAll();

        echo"<div id='orderList'>";
        foreach($order as $product)
        {
            if($product[2] == 1)
            {
                $status = 'Bestelling word bereid';
            }
            if($product[2] == 2)
            {
                $status = 'Bestelling is onderweg';
            }
            if($product[2] == 3)
            {
                $status = 'Bestelling is bezorgd';
            }
            echo "Product: $product[0]: ";
            echo "$product[1]<br>";
            echo "Status: $status <br>";
        }
        echo"</div>";

    }
}
?>


    <p>
    <form id='line' method='post' action='bestelling.php'>
        <input type='number' name='bestel'>
        <input type='submit' value='Check bestelling'>
    </form>
    </p>
</div>
</body>

</html>