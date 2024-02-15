<?php 
  require "dbConnect.php";

  if(!isset($_SESSION['role'])){
  $_SESSION['role'] = [];
  }

  $sql = "SELECT * FROM menu";
  $data = [];
  $currentNav = "recent"; 
  $message = "";

  if(isset($_GET['cat'])){
    $sql .= " WHERE foodcat_id = :cat_id";
    $data['cat_id'] = $_GET['cat'];
    $currentNav = "C" . $_GET['cat'];
    $pageTitle =  $allCategories[$_GET['cat']]; 
  }else {
    $sql .= " ORDER BY foodcat_id ASC";
  }
 
  $query = $db->prepare($sql);
  $query->execute($data);
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
      
      <?php 
    $search = null;

    if (isset($_POST['search'])) {
      $searchMenu = $_POST['search'];

      $sql = "SELECT * FROM menu WHERE dish_title LIKE :searchMenu";
      $search = $db->prepare($sql);
      $search->execute(array(':searchMenu' => '%' . $searchMenu . '%'));
    }
    ?>
      <div class="searchbar-container d-flex flex-row mx-auto my-auto">
    <form class="searchbar" method="POST" action="">
      <input class="form-control-lg" type="search" name="search" placeholder="Search for menu"
        aria-label="Search" />
      <button class="btn btn-warning" type="submit">
        Search
      </button>
    </form>
  </div>

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

      <?php 
    $search = null;

    if (isset($_POST['search'])) {
      $searchMenu = $_POST['search'];

      $sql = "SELECT * FROM menu WHERE dish_title LIKE :searchMenu";
      $search = $db->prepare($sql);
      $search->execute(array(':searchMenu' => '%' . $searchMenu . '%'));
    }
    ?>
    
    <div class="searchbar-container d-flex flex-row mx-auto my-auto">
    <form class="searchbar" method="POST" action="">
      <input class="form-control-lg" type="search" name="search" placeholder="Search for menu"
        aria-label="Search" />
      <button class="btn btn-warning" type="submit">
        Search
      </button>
    </form>
  </div>

      <?php include "admin_navbar_log.php" ?>
    <?php    } else { ?>

      <?php 
    $search = null;

    if (isset($_POST['search'])) {
      $searchMenu = $_POST['search'];

      $sql = "SELECT * FROM menu WHERE dish_title LIKE :searchMenu";
      $search = $db->prepare($sql);
      $search->execute(array(':searchMenu' => '%' . $searchMenu . '%'));
    }
    ?>
      <div class="searchbar-container d-flex flex-row mx-auto my-auto">
    <form class="searchbar" method="POST" action="">
      <input class="form-control-lg" type="search" name="search" placeholder="Search for menu"
        aria-label="Search" />
      <button class="btn btn-warning" type="submit">
        Search
      </button>
    </form>
  </div>

      <?php include "navbar_login.php" ?>
    <?php   } ?>

</nav>

<!-- Filtering Menu with button -->
<div class="container-1-item col-lg-12 text-center my-4">
  <h1>Online Menu</h1>
  <ul class="controls d-flex align-items-center justify-content-center flex-wrap p-1">

    <li class="category-btn btn btn-warning mx-2 my-1" data-filter="All">
      <a href="menu.php">All</a>
    </li>
    <li class="category-btn btn btn-warning mx-2 my-1" data-filter="Entree">
      <a href="menu.php?cat=100">Entree</a>
    </li>
    <li class="category-btn btn btn-warning mx-2 my-1" data-filter="Vegetarian">
      <a href="menu.php?cat=200">Vegetarian</a>
    </li>
    <li class="category-btn btn btn-warning mx-2 my-1" data-filter="Meat">
      <a href="menu.php?cat=300">Meat</a>
    </li>
    <li class="category-btn btn btn-warning mx-2 my-1" data-filter="Seafood">
      <a href="menu.php?cat=400">Seafood</a>
    </li>
    <li class="category-btn btn btn-warning mx-2 my-1" data-filter="Beverage">
      <a href="menu.php?cat=500">Beverage</a>
    </li>
  </ul>

  <h2><?=($pageTitle??""); ?></h2>
  
  <?php include 'add_to_cart.php'?>

  <!-- Menu items -->
  <?php if (isset($search)) { ?>
    <h2>Search Results:</h2>
    <div class="row list">
      <?php while ($row = $search->fetch()) {
              $link = "menuItem.php?item=" . $row['menu_id'];
          ?>
      <div class="item">
        <div class="item-content">
          <?php if ($row['image'] != "") { ?>
          <a href="<?= $link; ?>">
            <img class="img-responsive" src="<?= $row['image']; ?>" alt="" />
          </a>
          <?php } ?>
          <h3 class="title">
            <a href="<?= $link; ?>"><?= $row['dish_title']; ?></a>
          </h3>
          <h4 class="price">
            <?= $row['price'] . " $" ?>
          </h4>

          <!-- Add to cart form -->
          <?php if($_SESSION['role'] === 'admin' or $_SESSION['role'] === 'user'){ ?>
          <form method="post" action="menu.php" class="add-to-cart-form">
            <input type="hidden" name="dish_image" value="<?= $row['image']; ?>">
            <input type="hidden" name="dish_id" value="<?= $row['menu_id']; ?>">
            <input type="hidden" name="dish_name" value="<?= $row['dish_title']; ?>">
            <input type="hidden" name="dish_price" value="<?= $row['price']; ?>">
            <button type="submit" class="btn btn-primary add-btn" name="add_to_cart">Add to Cart</button>
          </form>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="row list">
      <?php while ($row = $query->fetch()) {
              $link = "menuItem.php?item=" . $row['menu_id'];
            ?>
      <div class="item">
        <div class="item-content">
          <?php if ($row['image'] != "") { ?>
          <a href="<?= $link; ?>">
            <img class="img-responsive" src="<?= $row['image']; ?>" alt="" />
          </a>
          <?php } ?>
          <h3 class="title">
            <a href="<?= $link; ?>"><?= $row['dish_title']; ?></a>
          </h3>
          <h4 class="price">
            <?= $row['price'] . " $" ?>
          </h4>

          <!-- Add to cart form -->
          <?php if($_SESSION['role'] === 'admin' or $_SESSION['role'] === 'user'){ ?>
          <form method="post" action="menu.php" class="add-to-cart-form">
            <input type="hidden" name="dish_image" value="<?= $row['image']; ?>">
            <input type="hidden" name="dish_id" value="<?= $row['menu_id']; ?>">
            <input type="hidden" name="dish_name" value="<?= $row['dish_title']; ?>">
            <input type="hidden" name="dish_price" value="<?= $row['price']; ?>">
            <button type="submit" class="btn btn-primary add-btn" name="add_to_cart">Add to Cart</button>
          </form>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
    </div>
  <?php } ?>

  <!-- Back to Top Button -->
  <?= include 'includes/backToTop.php'; ?>

</div>
  
</body>
<?= include 'includes/footer.php' ?>
</html>
