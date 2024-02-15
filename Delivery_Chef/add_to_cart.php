<?php
if(isset($_POST['add_to_cart'])){
  $dish_id = $_POST['dish_id'];
  $dish_name = $_POST['dish_name'];
  $dish_price = $_POST['dish_price'];
  $dish_image = $_POST['dish_image'];

  // Check if the item is already in the cart
  $select_item = $db->prepare("SELECT * FROM cart WHERE dish_id = :dish_id");
  $select_item->bindParam(':dish_id', $dish_id);
  $select_item->execute();
  $cart_item = $select_item->fetch(PDO::FETCH_ASSOC);

  if ($cart_item) {
    // If the item exist, update the quantity by adding 1
    $new_qty = $cart_item['dish_qty'] + 1;
    $update_cart = $db->prepare("UPDATE cart SET dish_qty = :new_qty WHERE dish_id = :dish_id");
    $update_cart->bindParam(':new_qty', $new_qty);
    $update_cart->bindParam(':dish_id', $dish_id);
    $update_cart->execute();
  } else {
    $dish_qty = 1;
    $insert_cart = $db->prepare("INSERT INTO cart (dish_id, dish_name, dish_price, dish_image, dish_qty) 
        VALUES (:dish_id, :dish_name, :dish_price, :dish_image, :dish_qty)");
    $insert_cart->bindParam(':dish_id', $dish_id);
    $insert_cart->bindParam(':dish_name', $dish_name);
    $insert_cart->bindParam(':dish_price', $dish_price);
    $insert_cart->bindParam(':dish_image', $dish_image);
    $insert_cart->bindParam(':dish_qty', $dish_qty);
    $insert_cart->execute();
  }

  header('location:menu.php');
  exit();
}
?>