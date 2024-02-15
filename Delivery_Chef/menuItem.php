<?php 
  require "dbConnect.php";

  if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
  }

$sql = "SELECT * FROM menu WHERE menu_id = :id";
$query = $db->prepare($sql);
$query->execute(['id' => $_GET['item'] ]);

$result = $query->fetch(); 

if(!$result){  
  menuPageNotFound();
}

$mainTitle = "For your choice";  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="css/menu.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
  <?= include "includes/navbar_logo.php"?>

    <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>

      <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
      <li class="nav-item"><a class="nav-link mx-3 text-white" href="menu.php">Back to Menu</a></li>
    </ul>

      <div class="d-flex align-items-center text-center">
  <?php
  $select_rows = $db->query("SELECT * FROM cart");
  $row_count = $select_rows->rowCount();
  ?>
  <div class="shopping mx-4">
    <a href="cart.php">
      <img src="./image/shopping-bag.jpg" alt="">
      <span class="quantity">
        <?php echo $row_count; ?>
      </span>
    </a>
  </div>

  <?php include "user_navbar_profile.php" ?>

    <?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>

    <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
      <li class="nav-item"><a class="nav-link mx-3 text-white" href="admin_menu_dashbd.php">Back to Menu</a></li>
    </ul>

      <?php include "admin_navbar_log.php" ?>
    <?php    } else { ?>

      <?php include "navbar_login.php" ?>
    <?php   } ?>
  </div>
</nav>

<div class="container">
  <div class="menu-item-box row">
    <?php if ($result['image'] != "") { ?>
    <div class="col-md-6 order-md-2 img-box">
      <img class="img-fluid" src="<?= $result['image']; ?>" alt="Dish Image" />
    </div>
    <?php } ?>
    <div class="menu-item-content col-md-6">
    <div class="text-center">
      <h1><?= $result['dish_title']; ?></h1>
    </div>

    <div class="py-1 text-center">
      <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] == "admin") { ?>
      <a href="admin_menu.php?item=<?= $result['menu_id']; ?>" class="btn btn-primary">Edit Item</a>
      <a href="deleteMenu.php?item=<?= $result['menu_id']; ?>" class="btn btn-danger">Delete</a>
      <?php } ?>
    </div>

      <p><strong><?= $allCategories[$result['foodcat_id']]; ?></strong></p>
      <p>
        <?= nl2br($result['description']); ?>
      </p>

      <?php include 'add_to_cart.php'?>
      <?php if (isset($_SESSION["user_id"])) { ?>
      <div class="text-center">
      <form method="post" action="">
        <input type="hidden" name="dish_id" value="<?= $result['menu_id']; ?>">
        <input type="hidden" name="dish_name" value="<?= $result['dish_title']; ?>">
        <input type="hidden" name="dish_price" value="<?= $result['price']; ?>">
        <input type="hidden" name="dish_image" value="<?= $result['image']; ?>">
        <button class="btn btn-warning add-btn" type="submit" name="add_to_cart">Add to Cart</button>
      </form>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<?= include 'includes/footer.php' ?>
</body>
</html>