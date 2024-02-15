<?php
  require "dbConnect.php";

  // Preventing unauthorized access 
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php ");
}else if($_SESSION['role'] !== 'admin'){
  header("Location: index.php ");   
}



  $sql = "SELECT * FROM emp_delivery";
  $query = $db->prepare($sql);
  $query->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin-Employees</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="css/admin.css" />
</head>

<body>
  <div class="main-container d-flex">

    <!-- Side Bar -->
    <?= include 'admin_sidebar.php' ?>

    <div class="container-fluid content-container">
      <div class="header-box">
        <div class="header-title p-3">
          <h2>Employee List</h2>
          <a href="emp_edit.php">
            <p> [ Add Employee ]</p>
          </a>
        </div>
      </div>

      <div class="card-container p-3 mt-2">
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Employee Id</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Employee Status</th>
                <!-- <th scope="col">Delivery Status</th> -->
                <th scope="col">Schedule/ EmpInfo-Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $query->fetch() ) { ?>
              <tr>
                <th><?=$row['emp_id']; ?></th>
                <th><?=$row['emp_fname'] . " " . $row['emp_lname']; ?></th>
                <th><?=$row['emp_phone']; ?></th>
                <th><?php foreach($allStatus as $sts_id => $sts_desc){
                  if($sts_id == $row['status_id']){echo $sts_desc;}             
                } ?></th>
                <!-- get status info from Delivery table -->
                <!-- <th>Preparing</th> -->
                <th>
                  <button class="btn btn-primary update-delete p-2 mx-1 rounded-3"><a class="text-white text-decoration-none" 
                      href="emp_dashboard.php"><i class="bi bi-person-check"></i> Assign</a></button>
                  
                <button class="btn btn-warning update-delete p-2 mx-1 rounded-3"><a class="text-dark text-decoration-none"
                      href="emp_edit.php?empId=<?=$row['emp_id'];?>"><i class="bi bi-pencil"></i> Update</a></button>
                  
                      <button class="btn btn-danger update-delete p-2 mx-1 rounded-3"><a class="text-white text-decoration-none"
                      href="deleteEmployee.php?empId=<?=$row['emp_id'];?>"><i class="bi bi-trash text-white"></i> Delete</a></button>
                </th>
              </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>



    </div>
  </div>
  </div>

  </div>
  </div>
</body>

</html>