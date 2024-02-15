<?php
require_once 'dbConnect.php';

$sql = "SELECT orders.order_time, orders.order_id, menu.menu_id, menu.dish_title, menu.price
        FROM orders
        INNER JOIN menu
        ON orders.menu_id = menu.menu_id
        ORDER BY orders.order_time DESC";
$order_fetch = $db->prepare($sql);
$order_fetch->execute();

?>