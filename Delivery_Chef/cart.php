<?php
require 'dbConnect.php';

if(isset($_POST['update_btn'])){
  $update_qty = $_POST['update_qty'];
  $update_id = $_POST['update_qty_id'];
  $sql = "UPDATE cart SET dish_qty = :update_qty WHERE dish_id = :update_id"; 
  $update = $db->prepare($sql);
  $update->bindParam(':update_qty', $update_qty);
  $update->bindParam(':update_id', $update_id);
  if($update->execute()){
     header('location:cart.php');
  };
};



if(isset($_GET['remove'])){
  $remove_id = $_GET['remove'];
  $remove = $db->prepare("DELETE FROM cart WHERE dish_id = :remove_id");
  $remove->bindParam(':remove_id', $remove_id);
  if($remove->execute()){
     header('location:cart.php');
  };
};

if(isset($_GET['delete_all'])){
  $clear_cart = $db->prepare("DELETE FROM cart");
  if($clear_cart->execute()){
     header('location:cart.php');
  };
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu list</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <!-- <link rel="stylesheet" type="text/css" href="css/menu.css" /> -->
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" type="text/css" href="css/cart.css" />
</head>

<body>
<?= include "includes/navbar_logo.php"?>  
    <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>
      <?php include "user_navbar_profile.php" ?>
<?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>
   <?php include "admin_navbar_log.php" ?>
<?php    } else { ?>
  <?php include "navbar_login.php" ?>
<?php   } ?>
</div>
</nav>

  <div class="container-fluid">

<section class="shopping-cart">

   <h1 class="text-center py-4">shopping cart</h1>

   <div class="table-responsive">
   <table class="table">

      <thead class="table-dark">
         <th></th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th></th>
      </thead>

      <tbody>

      <?php 
         $select_cart = $db->query("SELECT * FROM cart");
         $total_price = 0;
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch()){
         ?>

         <tr>
            <td><img class="cart-img" src="<?php echo $fetch_cart['dish_image']; ?>" alt=""></td>
            <td><?php echo $fetch_cart['dish_name']; ?></td>
            <td>$<?php echo number_format($fetch_cart['dish_price']); ?></td>
            <td>

               <form action="" method="post">
                  <input type="hidden" name="update_qty_id"  value="<?php echo $fetch_cart['dish_id']; ?>" >
                  <input type="number" name="update_qty" min="1"  value="<?php echo $fetch_cart['dish_qty']; ?>" >
                  <input type="submit" value="update" name="update_btn">
               </form>  
                
            </td>
            <td>$<?php echo $sub_total = number_format($fetch_cart['dish_price'] * $fetch_cart['dish_qty']); ?></td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['dish_id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="bi bi-trash"></i>Remove</a></td>
         </tr>
         <?php
           $total_price += $sub_total;  
            };
         };
         ?>
         
         <tr class="table-bottom">
            <td><a href="menu.php" class="option-btn align-middle">Continue Shopping</a></td>
            <td colspan="3" class="text-end fw-bold align-middle">Grand Total:</td>
            <td class="fw-bold align-middle">$<?php echo $total_price; ?></td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="bi bi-trash"></i>Clear Order</a></td>
         </tr>

      </tbody>

   </table>
   </div>

   <div class="checkout-btn text-center mt-5">
      <a href="checkout.php" class="btn <?= ($total_price > 1)?'':'disabled'; ?>">procced to checkout</a>
   </div>

</section>
</div>
</body>
</html>