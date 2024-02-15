<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="./css/admin.css" />
  <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>

<body>
  <div class="main-container d-flex">

    <!-- Side Bar -->
    <?= include 'admin_sidebar.php' ?>

    <div class="container-fluid content-container">
      <div class="header-box">
        <div class="header-title p-3">
          <h2>Dashboard</h2>
        </div>
      </div>


      <div class="card-container p-3 mt-2">
        <h3 class="main-title">Data</h3>
        <div class="card-box p-2 rounded-1 d-flex flex-wrap gap-2">

          <!-- Total Users Registered -->
          <div class="cardcontent-box d-flex justify-content-between align-items-center p-3">
            <div class="card-title">
              <span>Total Users:</span>
              <?php include 'admin_userCount.php'?>
              <span class="user-count d-flex flex-columns"><?=$userCount?></span>
            </div>
            <i class="bi bi-people-fill icon text-center p-1"></i>
          </div>

          <!-- Total Menu Registered -->
          <div class="cardcontent-box d-flex justify-content-between align-items-center p-3">
            <div class="card-title">
              <span>Menu Items:</span>
              <?php include 'admin_menuCount.php'?>
              <span class="user-count d-flex flex-columns"><?=$menuCount?></span>
            </div>
            <i class="bi bi-book icon text-center p-1"></i>
          </div>

          <div class="cardcontent-box d-flex justify-content-between align-items-center p-3">
            <div class="card-title">
              <span>Total Delivery:</span>
              <span class="user-count d-flex flex-columns">0</span>
            </div>
            <i class="bi bi-truck icon text-center p-1"></i>
          </div>

          <div class="cardcontent-box d-flex justify-content-between align-items-center p-3">
            <div class="card-title">
              <span>Earnings Today:</span>
              <span class="user-count d-flex flex-columns">0$</span>
            </div>
            <i class="bi bi-currency-dollar icon text-center p-1"></i>
          </div>
        </div>
      </div>

      <div class="card-container p-3 mt-2">
        <h3>Orders Today</h3>
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Order Id</th>
                <th scope="col">Menu Id</th>
                <th scope="col">Dish</th>
                <th scope="col">Price</th>
              </tr>
            </thead>
            <tbody>
              <!-- will be added in the future  -->
              <!-- <?php
                    require_once 'dbConnect.php';

                    $sql = "SELECT O.order_time, O.order_id, M.menu_id, M.dish_title, M.price
                            FROM orders AS O
                            INNER JOIN menu AS M
                            ON O.menu_id = M.menu_id
                            ORDER BY O.order_time DESC";
                            $order_fetch = $db->prepare($sql);
                            $order_fetch->execute();

                    ?>
              <?php while($result = $order_fetch->fetchAll()) { ?>
              <tr>
                <td><?= $row['order_time'] ?></td>
                <td><?= $row['order_id'] ?></td>
                <td><?= $row['menu_id'] ?></td>
                <td><?= $row['dish_title'] ?></td>
                <td><?= $row['price'] ?></td>
              </tr>
              <?php } ?> -->
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-container p-3 mt-2">
        <h3>Delivers Today</h3>
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Schedule Id</th>
                <th scope="col">Order Id</th>
                <th scope="col">Employee</th>
                <th scope="col">Service Status</th>
              </tr>
            </thead>
          </table>
        </div>

      </div>
    </div>
  </div>

  </div>
  </div>
</body>

</html>