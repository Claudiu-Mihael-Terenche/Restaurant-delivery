<?php
require_once 'dbConnect.php';

// Fetch order history for a user
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if ($userId) {
  $sql = "
    SELECT 
      r.receipt_id AS receiptId, 
      o.order_id AS orderId, 
      u.id AS userId,
      o.order_date AS orderDate,
      m.menu_id AS dishId, 
      m.title AS dishTitle,
      r.dish_qty AS dishQty, 
      r.dish_price AS dishPrice,
      SUM(r.dish_qty * r.dish_price) AS grandTotal
    FROM 
      receipt r
      JOIN orders o ON o.order_id = r.order_id
      JOIN menu m ON m.menu_id = r.menu_id
      JOIN cart c ON c.dish_id = m.menu_id
      JOIN users u ON u.id = o.user_id
    WHERE 
      u.id = :userId
    GROUP BY 
      r.receipt_id, 
      o.order_id, 
      m.menu_id
    ORDER BY o.order_date DESC;
  ";
  $fetch_receipt = $db->prepare($sql);
  $fetch_receipt->bindParam(':userId', $userId);
  $fetch_receipt->execute();
  $order_history = $fetch_receipt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant Delivery</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>

<body>
<?= require_once "dbConnect.php"?>
  <?= include "includes/navbar_logo.php"?>
    <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
      <li class="nav-item"><a class="nav-link mx-3 text-white" href="menu.php">Online Menu</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="#about-us">About Us</a></li>
      <li class="nav-item"><a class="nav-link mx-3 text-white" href="#contact-us">Contact Us</a></li>
    </ul>
  
    <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>

      <?php include "user_navbar_profile.php" ?>

<?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>

      <?php include "admin_navbar_log.php" ?>

      <?php    } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "employee") { ?>

        <?php include "emp_navbar_log.php" ?>

<?php    } else { ?>
  <?php include "navbar_login.php" ?>
<?php   } ?>
</div>
</nav>

  <h1>Order History</h1>
  
  <?php if ($userId && !empty($order_history)) { ?>
    <table>
      <thead>
        <tr>
          <th>Receipt ID</th>
          <th>Order ID</th>
          <th>User ID</th>
          <th>Order Date</th>
          <th>Dish ID</th>
          <th>Dish Title</th>
          <th>Dish Qty</th>
          <th>Dish Price</th>
          <th>Grand Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order_history as $order) { ?>
          <tr>
            <td><?= $order['receiptId'] ?></td>
            <td><?= $order['orderId'] ?></td>
            <td><?= $order['userId'] ?></td>
            <td><?= $order['orderDate'] ?></td>
            <td><?= $order['dishId'] ?></td>
            <td><?= $order['dishTitle'] ?></td>
            <td><?= $order['dishQty'] ?></td>
            <td><?= $order['dishPrice'] ?></td>
            <td><?= $order['grandTotal'] ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <p>No order history found.</p>
  <?php } ?>


  <?php include "includes/footer.php" ?>

</body>
</html>