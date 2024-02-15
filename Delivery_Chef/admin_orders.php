<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }

  $sql = "SELECT * FROM orders";
  $query = $db->prepare($sql);
  $query->execute();

  $pageTitle = "Admin-Order";
  $catTitle = "Order Status";

  include "includes/header_dashbd.php";

?>

<body>
  <div class="card-container p-3 mt-2">
    <div class="table-container">
      <table class="table table-striped table-responsive">
        <thead>
          <tr>
            <th scope="col">Order Date</th>
            <th scope="col">Order ID</th>
            <th scope="col">Delivery Address</th>
            <th scope="col">Service Status</th>
            <th scope="col">Schedule</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $query->fetch()){ 
            if($row['status_id'] == 400 ){
            ?>
          <tr>
            <th><?=$row['order_time'];?></th>
            <th><?=$row['order_id'];?></th>
            <th><?=$row['address'] . ", " . $row['city'] . ", " . $row['province'] . " [" . $row['zip'] . "] ";?></th>
            <th><?php foreach($allStatus as $sts_id => $sts_desc){
              if($row['status_id'] == $sts_id){
                echo $sts_desc;
              }
            } ?></th>
            <th><button class="btn btn-primary update-delete p-2 mx-1 rounded-3"><a 
            class="text-white text-decoration-none" href="emp_dashboard.php"><i class="bi bi-person-check"></i> Assign</a></button></th>
          </tr>

          <?php 
            }
           }  ?>

        </tbody>
      </table>
    </div>
  </div>



  <div class="card-container p-3 mt-2">
    <div class="table-container">
      <table class="table table-striped table-responsive">

        <thead>
          <br>
          <tr>
            <h4>
              [ Order History ]
            </h4>
          </tr>
        </thead>

        <thead>
          <tr>
            <th scope="col">Order Date</th>
            <th scope="col">Order ID</th>
            <th scope="col">Delivery Address</th>
            <th scope="col">Service Status</th>
          </tr>
        </thead>
        <tbody>
          <?php  $query->execute();
            while($row = $query->fetch()){ 
              if($row['status_id'] != 400 ){
            ?>
          <tr>
            <th><?=$row['order_time'];?></th>
            <th><?=$row['order_id'];?></th>
            <th><?=$row['address'] . ", " . $row['city'] . ", " . $row['province'] . " [" . $row['zip'] . "] ";?></th>
            <th><?php foreach($allStatus as $sts_id => $sts_desc){
              if($row['status_id'] == $sts_id){
                echo $sts_desc;
              }
            } ?></th>

          </tr>

          <?php }
        } ?>

        </tbody>
      </table>
    </div>
  </div>
</body>

</html>