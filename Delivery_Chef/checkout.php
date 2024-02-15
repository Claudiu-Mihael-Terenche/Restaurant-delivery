<?php
require_once 'dbConnect.php';

if(isset($_GET['delete_all'])){
  $clear_cart = $db->prepare("DELETE FROM cart");
  if($clear_cart->execute()){
     header('location:menu.php');
  };
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_btn'])) {
  $sql = "SELECT * FROM cart";
  $checkout = $db->query($sql);
  $dish_name = array();
  $total_price = 0;

  if($checkout->rowCount() > 0) {
    while ($order_item = $checkout->fetch()) {
      $dish_name[] = $order_item['dish_name'] .' ('. $order_item['dish_qty'] .') ';
      $dish_price = number_format($order_item['dish_price'] * $order_item['dish_qty']);
      $total_price += $dish_price;
    }
  }

  $total_menu = implode(', ', $dish_name);

  $name = $_POST['name'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $province = $_POST['province'];
  $zip = $_POST['zip'];
  $phone = $_POST['phone'];
  $statusId = 400;
  $userId = $_SESSION['user_id'];

  $order_sql = "INSERT INTO orders (name, address, city, province, zip, phone, status_id, user_id) 
                VALUES (:name, :address, :city, :province, :zip, :phone, :status_id, :userId)";
  $order_register = $db->prepare($order_sql);

  $order_register->bindParam(':name', $name);
  $order_register->bindParam(':address', $address);
  $order_register->bindParam(':city', $city);
  $order_register->bindParam(':province', $province);
  $order_register->bindParam(':zip', $zip);
  $order_register->bindParam(':phone', $phone);
  $order_register->bindParam(':status_id', $statusId);
  $order_register->bindParam(':userId', $userId);

  if ($order_register->execute()) {

    $clear_cart = $db->prepare("DELETE FROM cart");
    if($clear_cart->execute()){

    $orderConfirmation =  "
      <div class='order-message-container'>
        <div class='message-container'>
          <h3>Thank you!</h3>
          <div class='order-detail'>
            <span>".$total_menu."</span>
            <span class='total'> Total Price : $".$total_price." </span>
          </div>
          <div class='customer-details'>
            <p> Your Name : <span>". $name ."</span> </p>
            <p> Your Phone Number : <span>".$phone."</span> </p>
            <p> Your Address : <span>".$address.", ".$city.", ".$province.", ".$zip."</span> </p>
          </div>
          <a href='menu.php' class='btn'>Continue Shopping</a>
        </div>
      </div>
    ";
    echo $orderConfirmation;
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="css/menu.css" />
  <link rel="stylesheet" type="text/css" href="css/cart.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
  <?= include "includes/navbar_logo.php"?>
  <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>

  <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
    <li class="nav-item"><a class="nav-link mx-3 text-white" href="cart.php">Back To Cart <i class="bi bi-cart"></i></a>
    </li>
  </ul>

  <?php include "user_navbar_profile.php" ?>
  <?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>
  <?php include "admin_navbar_log.php" ?>
  <?php    } else { ?>
  <?php include "navbar_login.php" ?>
  <?php   } ?>
  </div>
  </nav>

  <div class="container">
    <section class="checkout-form">
      <h1 class="heading text-center mb-4">Complete your order</h1>
      <form action="" method="POST">
        <div class="display-order">
          <?php
            $sql = "SELECT * FROM cart";
            $select_cart = $db->query($sql);
            $grand_total = 0;

            if ($select_cart->rowCount() > 0) {
              while ($fetch_cart = $select_cart->fetch()) {
                $total_price = number_format($fetch_cart['dish_price'] * $fetch_cart['dish_qty']);
                $grand_total += $total_price;
          ?>
          <span><?= $fetch_cart['dish_name']; ?>(<?= $fetch_cart['dish_qty']; ?>)</span>
          <?php
              }
            } else {
              echo "<div class='display-order'><span>Your cart is empty!</span></div>";
            }
          ?>
          <span class="grand-total"> Grand Total : $<?= $grand_total; ?> </span>
        </div>
        <div class="flex">
          <div class="inputBox">
            <span>Your Name</span>
            <input type="text" placeholder="John Doe" name="name" required>
          </div>
          <div class="inputBox">
            <span>Phone #</span>
            <input type="tel" placeholder="000-000-0000" name="phone" required>
          </div>
          <div class="inputBox">
            <span>Payment Method</span>
            <select name="method">
              <option value="cash on delivery" selected>Cash on delivery</option>
              <option value="credit cart">Credit card</option>
            </select>
          </div>
          <div class="inputBox">
            <span>Address</span>
            <input type="text" placeholder="1234 St-Paul Street" name="address" required>
          </div>
          <div class="inputBox">
            <span>City</span>
            <input type="text" placeholder="Montreal" name="city" required>
          </div>
          <div class="inputBox">
            <span>Province</span>
            <input type="text" placeholder="QC" name="province" required>
          </div>
          <div class="inputBox">
            <span>Postal Code</span>
            <input type="text" placeholder="H3S1Y6" name="zip" required>
          </div>
        </div>
        <input type="submit" value="Order Now" name="order_btn" class="btn">
      </form>
    </section>
  </div>

</body>

</html>