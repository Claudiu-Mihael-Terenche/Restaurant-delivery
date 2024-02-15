<?php
  require "dbConnect.php";

// Preventing unauthorized access 
 if (!isset($_SESSION['user_id'])) {
  header("Location: index.php ");
}else if($_SESSION['role'] !== 'admin'){
  if($_SESSION['role'] !== 'employee'){
    header("Location: index.php ");
  }
} 

  // for Admin Interface
  // Loading Order List which is to be delivered only
  $sqlOrder = "SELECT * FROM orders WHERE status_id = 400";
  $queryOrder1 = $db->prepare($sqlOrder);
  $queryOrder1->execute();
  // Loading to list the Order ID for the delivery scheduling 
  $sqlOrder2 = "SELECT order_id, status_id FROM orders WHERE status_id = 400";
  $queryOrder2 = $db->query($sqlOrder2);
  $resOrder = $queryOrder2->fetchAll(PDO::FETCH_KEY_PAIR);

  // Loading Employee list
  $sqlEmp = "SELECT * FROM emp_delivery WHERE status_id = 400";
  $queryEmp = $db->prepare($sqlEmp);
  $empList = $queryEmp->execute(); 
  
// ================================================================================= 
  // for Employee Interface
  $empId = $_SESSION['user_id'];
  $empSchedule = "SELECT SC.sched_id, SC.scheduleTime, O.address, O.city, O.province,
      O.zip, O.status_id AS orderStatus, E.status_id AS empStatus, E.emp_id, O.order_id
  from emp_delivery as E 
  inner join sched_order as SC on E.emp_id = SC.emp_id
  inner join orders as O on SC.order_id = O.order_id
  WHERE E.emp_id = $empId";
  $querySchedule = $db->prepare($empSchedule);
  $resSchedule = $querySchedule->execute();
  
  // delivery status list
  $sqlStatus = "SELECT status_id, status_desc FROM service_sts WHERE status_id < 200";
  $queryStatus = $db->query($sqlStatus);
  $statusList = $queryStatus->fetchAll(PDO::FETCH_KEY_PAIR);

// ================================================================================= 
  // Event handling 
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['adminUpdate'])) {      
      // for handling event of admin interface
    $empId = $_POST['empId'];
    $orderId = $_POST['orderId'];

    // place an schedule for delivery
    $sql = "INSERT INTO sched_order (emp_id, order_id ) VALUES (:empId, :orderId)";
    $query = $db->prepare($sql);
    $query->bindParam(':empId' , $empId);
    $query->bindParam(':orderId' , $orderId);
    $query->execute();

    // update service status of employee table as "Preparing"
    $sqlUpdateEmp = "UPDATE emp_delivery SET status_id = 100 WHERE  emp_id = :empId";
    $queryUpdateEmp = $db->prepare($sqlUpdateEmp);
    $queryUpdateEmp->bindParam(':empId' , $empId);
    $queryUpdateEmp->execute();

    // update service status of order table as "Preparing"
    $sqlUpdateOrder = "UPDATE orders SET status_id = 100 WHERE  order_id = :orderId";
    $queryUpdateOrder = $db->prepare($sqlUpdateOrder);
    $queryUpdateOrder->bindParam(':orderId' , $orderId);
    $queryUpdateOrder->execute();

    header("location: emp_dashboard.php");
    } else if (isset($_POST['empUpdate'])) {
    // for handling event of employee interface
    $empId = $_POST['empId'];
    $orderId = $_POST['orderId'];
    $status = $_POST['deliveryStatus'];

     // update service status of employee table 
     if($status == 102){
        $sqlUpdateEmp = "UPDATE emp_delivery SET status_id = 400 WHERE  emp_id = :empId";
     }else{
        $sqlUpdateEmp = "UPDATE emp_delivery SET status_id = $status WHERE  emp_id = :empId";
     }

     $queryUpdateEmp = $db->prepare($sqlUpdateEmp);
     $queryUpdateEmp->bindParam(':empId' , $empId);
     $queryUpdateEmp->execute();
     
     // update service status of order table 
        $sqlUpdateOrder = "UPDATE orders SET status_id = $status WHERE  order_id = :orderId";
        $queryUpdateOrder = $db->prepare($sqlUpdateOrder);
        $queryUpdateOrder->bindParam(':orderId' , $orderId);
        $queryUpdateOrder->execute();

     }

  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee Schedule</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="./css/admin.css" />
</head>

<body>
  <div class="main-container d-flex">

    <div class="sidebar p-4 text-center" id="side_nav">
      <div class="side-header px-2 pt-3 pb-4">
        <h1 class="fs-4"><a class="text-white text-decoration-none" href="index.php">Delivery<span>Chef</span></a></h1>
      </div>

      <?php if($_SESSION['role'] == 'admin'){ ?>
      <ul class="side-menu list-unstyled px-2">
        <li class="">
          <a href="admin_orders.php" class="text-white text-decoration-none py-2 d-block"><i class="bi bi-speedometer"></i> Order
            list</a>
        </li>
        <li class="">
          <a href="admin_employees.php" class="text-white text-decoration-none py-2 d-block"><i
              class="bi bi-speedometer"></i>Employee list</a>
        </li>
        <li>
          <a href="admin_delivery.php" class="text-white text-decoration-none py-2 d-block"><i class="bi bi-truck"></i> Delivery</a>
        </li>
        <?php } ?>
        <li class="side-links mb-2">
    <a href="logout.php" class="text-white text-decoration-none py-2 d-block logout mb-5">
      <i class="bi bi-box-arrow-right text-white"></i>Logout
    </a>
  </li>
      </ul>

    </div>

    <div class="container-fluid content-container">
      <div class="header-box">
        <div class="header-title p-3">
          <h2>Employee Schedule
          <?php if($_SESSION['role'] == 'employee'){ ?>
            <small> <?="[Employee ID : " . $_SESSION['user_id'] . "]" ;?></small>
            <?php }?>
          </h2>
        </div>
      </div>
      <?php if($_SESSION['role'] == 'admin'){ ?>
      <div class="card-container p-3 mt-2">
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Employee ID</th>
                <th scope="col">Name</th>
                <th scope="col">Service Status</th>
                <th scope="col">Order ID</th>
                <th scope="col">Assign Schedule</th>
              </tr>
            </thead>
            <tbody>
              <?php while($r_emp = $queryEmp->fetch()){ ?>
              <tr>
                <form method="POST" action="emp_dashboard.php">
                  <th><?=$r_emp['emp_id'] ;?>
                    <input type="text" name="empId" value="<?=$r_emp['emp_id'] ;?>" hidden>
                  </th>

                  <th><?=$r_emp['emp_fname'] . " " . $r_emp['emp_lname']; ?></th>
                  <th>
                    <?php foreach($allStatus as $sts_id => $sts_desc){
                  if($sts_id == $r_emp['status_id']){echo $sts_desc;}             
                } ?>

                  </th>
                  <th>
                    <select name="orderId">
                      <?php foreach($resOrder as $id => $status ){ ?>
                      <option value="<?=$id; ?>"><?=$id ;?></option>
                      <?php } ?>
                    </select>
                  </th>

                  <th>
                    <button type='submit' class="btn btn-primary text-white text-decoration-none update-delete p-2 mx-1 rounded-3" name="adminUpdate"
                      value="adminUpdate"><i class="bi bi-person-check"></i> 
                      Assign</button>
                  </th>
                </form>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>


      <div class="table-container">
        <table class="table table-striped table-responsive">
          <thead>
            <br><br>
            <tr>
              <h4>
                [ Order List ]
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
            <?php while($r1 = $queryOrder1->fetch()){ ?>
            <tr>
              <th><?=$r1['order_time'];?></th>
              <th><?=$r1['order_id'];?></th>
              <th><?=$r1['address'] . ", " . $r1['city'] . ", " . $r1['province'] . " [" . $r1['zip'] . "] ";?></th>
              <th><?php foreach($allStatus as $sts_id => $sts_desc){
              if($r1['status_id'] == $sts_id){
                echo $sts_desc;
              }
            } ?></th>

              <?php } ?>
          </tbody>
        </table>
      </div>


      <?php } ?>

      <?php if($_SESSION['role'] == 'employee'){ ?>
      <div class="card-container p-3 mt-2">
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Schedule ID</th>
                <th scope="col">Schedule Time</th>
                <th scope="col">Delivery Address</th>
                <th scope="col">Service Status</th>
                <th scope="col">Schedule Update</th>
              </tr>
            </thead>
            <tbody>
              <?php while($sc_emp = $querySchedule->fetch()){ ?>
              <?php if($sc_emp['empStatus'] !=400 && $sc_emp['orderStatus'] !=102 ) { ?>
              <tr>
                <form method="POST" action="emp_dashboard.php">

                  <th><?=$sc_emp['sched_id']?></th>
                  <th><?=$sc_emp['scheduleTime']?></th>
                  <th>
                    <?=$sc_emp['address'] . ", " . $sc_emp['city'] . ", " . $sc_emp['province'] . " [" . $sc_emp['zip'] . "] ";?>
                  </th>
                  <th>
                    <select name="deliveryStatus">
                      <?php foreach($statusList as $id => $status ){ ?>
                      <option value="<?=$id; ?>"><?=$status ;?></option>
                      <?php } ?>
                    </select>
                  </th>

                  <th>
                    <input type="text" name="empId" value="<?=$sc_emp['emp_id'] ;?>" hidden>
                    <input type="text" name="orderId" value="<?=$sc_emp['order_id'] ;?>" hidden>
                    <button type='submit' class="update-delete p-2 mx-1 rounded-3" name="empUpdate" value="empUpdate">
                      Submit</button>
                  </th>

                </form>
              </tr>

              <?php } ?>
            </tbody>
            <?php } ?>
          </table>
        </div>
      </div>


      <div class="card-container p-3 mt-2">
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <br><br>
              <tr>
                <h4>
                  [ Delivery History ]
                </h4>
              </tr>
            </thead>
            <thead>
              <tr>
                <th scope="col">Schedule ID</th>
                <th scope="col">Schedule Time</th>
                <th scope="col">Delivery Address</th>
                <th scope="col">Service Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $querySchedule->execute(); 
              while($sc_emp = $querySchedule->fetch()){ 
                ?>
              <tr>
                <form method="POST" action="emp_dashboard.php">

                  <th><?=$sc_emp['sched_id']?></th>
                  <th><?=$sc_emp['scheduleTime']?></th>
                  <th>
                    <?=$sc_emp['address'] . ", " . $sc_emp['city'] . ", " . $sc_emp['province'] . " [" . $sc_emp['zip'] . "] ";?>
                  </th>

                  <th>

                    <?php foreach($statusList as $id => $status ){ 
                    if ($sc_emp['orderStatus'] == $id) { 
                      echo "$status" ;
                    }
                    } ?>

                  </th>


                </form>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php } ?>


    </div>
</body>

</html>