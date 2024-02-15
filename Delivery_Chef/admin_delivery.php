<?php 
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }

  // $sql = "SELECT * FROM orders";
  $sql = "SELECT O.order_time, O.order_id, O.address, O.city, O.province, O.zip, O.status_id , E.emp_id
  from orders as O 
  inner join sched_order as SC on O.order_id = SC.order_id 
  inner join emp_delivery as E on SC.emp_id = E.emp_id";
  $query = $db->prepare($sql);
  $query->execute();

  $pageTitle = "Admin-Delivery";
  $catTitle = "Delivery Status";

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
            <th scope="col">Delivery Status</th>
            <th scope="col">Employee ID</th>
            <th scope="col">Schedule</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $query->fetch()){ 
         
            if($row['status_id'] != 102) {
            ?>

          <tr>
            <th><?=$row['order_time'] ;?></th>
            <th><?=$row['order_id'] ;?></th>
            <th><?=$row['address'] . ", " . $row['city'] . ", " . $row['province'] . " [" . $row['zip'] . "] ";?></th>

            <th><?php foreach($allStatus as $sts_id => $sts_desc){
              if($row['status_id'] == $sts_id){
                echo $sts_desc;
              }
            } ?></th>
            <th><?=$row['emp_id'] ;?></th>
            <th><button class="btn btn-primary update-delete p-2 mx-1 rounded-3"><a class="text-white text-decoration-none" href="emp_dashboard.php"><i class="bi bi-person-check"></i> Assign</a></button>
            </th>
          </tr>
          <?php }
             } 
          ?>
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
              [ Delivery History ]
            </h4>
          </tr>
        </thead>
        <thead>
          <thead>
            <tr>
              <th scope="col">Order Date</th>
              <th scope="col">Order ID</th>
              <th scope="col">Delivery Address</th>
              <th scope="col">Delivery Status</th>
              <th scope="col">Employee ID</th>

            </tr>
          </thead>
        <tbody>

          <?php $query->execute();
              while($row = $query->fetch()){ 
                if($row['status_id'] == 102) {         
               ?>
          <tr>
            <th><?=$row['order_time'] ;?></th>
            <th><?=$row['order_id'] ;?></th>
            <th><?=$row['address'] . ", " . $row['city'] . ", " . $row['province'] . " [" . $row['zip'] . "] ";?></th>

            <th><?php foreach($allStatus as $sts_id => $sts_desc){
              if($row['status_id'] == $sts_id){
                echo $sts_desc;
              }
            } ?>
            </th>
            <th><?=$row['emp_id'] ;?></th>

          </tr>
          <?php 
                }
            } 
          ?>
        </tbody>
      </table>
    </div>
  </div>


</body>

</html>