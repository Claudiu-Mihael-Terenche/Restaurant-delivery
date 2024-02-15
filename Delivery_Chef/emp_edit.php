<?php 
require "dbConnect.php";

// Preventing unauthorized access 
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php ");
}else if($_SESSION['role'] !== 'admin'){
  header("Location: index.php ");   
}


// variables
$errorMessages = "";
$empEmail = "";
$empPwd = "";
$empFName = "";
$empLName = "";
$empPhone = "";
$statusId = "";
$empId = "";

  // is there item in the query string
  if(array_key_exists('empId', $_GET)){ 
    // ?item=x is in the URL

    // check that the item exists in the DB
      $query = $db->prepare("SELECT * FROM emp_delivery WHERE  emp_id = :id");
      $query->execute(['id'=>$_GET['empId']]);
   
      $data = $query->fetch(); 
      if(!$data){ // nothing found in the database
         pageNotFound();
      } 

    // populate the form
    $empEmail = $data['emp_email'];
    $empPwd = $data['emp_pw'];
    $empFName = $data['emp_fname'];
    $empLName = $data['emp_lname'];
    $empPhone = $data['emp_phone'];
    $statusId = $data['status_id'];
    $empId = $data['emp_id'];

  }
// check the POST method
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  //validating the form
  if(validateIsEmptyData($_POST, 'empEmail')) {
    $errorMessages = "Email is required";
  }else {
    $email = sanitizeEmail($_POST['empEmail']);
    if(validateEmail($email)){
      $empEmail = $_POST['empEmail'];
    }else {
      $errorMessages = "Invalid Email!";
    }
  }

  if(validateIsEmptyData($_POST, 'empPwd')) {
    $errorMessages = "Password is required";
  }else {
    if(validatePassword($_POST['empPwd'])){
      $empPwd = hashPassword($_POST['empPwd']);
    }else {
      $errorMessages = "Invalid Password!";
    }
  }

  if(validateIsEmptyData($_POST, 'empFName')) {
    $errorMessages = "First Name is required";
  }else {
    if(validateName($_POST['empFName'])){
      $empFName = $_POST['empFName'];
    }else {
      $errorMessages = "Invalid First Name!";
    }
  }

  if(validateIsEmptyData($_POST, 'empLName')) {
    $errorMessages = "Last Name is required";
  }else {
    if(validateName($_POST['empLName'])){
      $empLName = $_POST['empLName'];
    }else {
      $errorMessages = "Invalid Last Name!";
    }
  }

  if(validateIsEmptyData($_POST, 'empPhone')) {
    $errorMessages = "Last Name is required";
  }else {
    if(validatePhone($_POST['empPhone'])){
      $empPhone = $_POST['empPhone'];
    }else {
      $errorMessages = "Invalid Phone number!";
    }
  }

  $empId = $_POST['empId'] ?? ""; // track employee id if it exists
  $statusId = $_POST['statusId'] ?? 400; 
  // If error message is empty then save to db
  if($errorMessages == ""){
    // save and upload the file (if applicable)

    $data = [
      "empEmail"=>$empEmail,
      "empPwd"=>$empPwd,
      "empFName"=>$empFName,
      "empLName"=>$empLName,
      "empPhone"=>$empPhone,
      "statusId"=>$statusId
    ];

   
    if($empId == ""){
      // no employee id was found = add new row to the database
      $sql = "INSERT INTO emp_delivery (emp_email, emp_pw, emp_fname, emp_lname, emp_phone, status_id ) 
      VALUES (:empEmail, :empPwd, :empFName, :empLName, :empPhone, :statusId)";
    }else {
     // employee id was found = update existing row
      $sql = "UPDATE emp_delivery SET emp_email=:empEmail , emp_pw=:empPwd, emp_fname=:empFName, 
            emp_lname=:empLName, emp_phone=:empPhone, status_id=:statusId WHERE emp_id = :id";
     
      $data['id'] = $empId;    
     // add id to $data
    }

      $query = $db->prepare($sql);
      $query->execute($data);
  
       // if itemId does not exist (INSERT was performed) get the last inserted id from th DB
       if($empId == "")  $empId = $db->lastInsertId();
   
       // redirect user to the portfolio single item page
        header("location: admin_employees.php");    
  }

}

  $pageTitle=  ($empId == "")? "Add New Employee" : "Update Employee";
  $mainTitle = "Employee Edit";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Employee</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>

<body>
<?= include "includes/navbar_logo.php"?>
      <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>
        <?php include "user_navbar_profile.php" ?>
      <?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>

        <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
          <li class="nav-item"><a class="nav-link mx-3 text-white" href="admin_employees.php">Back to Employees List</a></li>
        </ul>
        <?php include "admin_navbar_log.php" ?>
      <?php    } else { ?>
        <?php include "navbar_login.php" ?>
      <?php   } ?>
  </nav>

<body>
  <?php if($errorMessages != ""){ ?>
  <?="[Error] : ". $errorMessages ?>
  <?php } ?>
  <div class="container-fluid admin-menu-container">
    <h1 class="text-center mt-3">Edit Employee Account</h1>
    <div class="row justify-content-center ">
      <form class="col-sm-6 col-sm-offset-3" method="POST" enctype="multipart/form-data" action="emp_edit.php">
        <input type="hidden" name="empId" value=<?= $empId; ?>>

        <div class="form-group mb-3">
          <label for="empEmail">Employee Email :</label>
          <input type="text" class="form-control" id="empEmail" name="empEmail" value="<?=$empEmail; ?>" required>
        </div>
        <div class="form-group mb-3">
          <label for="empPwd">Password :</label>
          <input type="text" class="form-control" id="empPwd" name="empPwd" value="<?=$empPwd; ?>" required>
        </div>
        <div class="form-group mb-3">
          <label for="empFName">First Name :</label>
          <input type="text" class="form-control" id="empFName" name="empFName" value="<?=$empFName; ?>">
        </div>
        <div class="form-group mb-3">
          <label for="empLName">Last Name :</label>
          <input type="text" class="form-control" id="empLName" name="empLName" value="<?=$empLName; ?>">
        </div>
        <div class="form-group mb-3">
          <label for="empPhone">Phone :</label>
          <input type="text" class="form-control" id="empPhone" name="empPhone" value="<?=$empPhone; ?>">
        </div>
        <div class="form-group mb-3">
          <label>Service status : </label>
          <select class="form-select" name="statusId" aria-label="Default select example" required>
            <option value=""> - Select Status - </option>
            <?php foreach($allStatus as $sts_id => $sts_desc) { 
              $selected = ($sts_id == $statusId)? "selected" : "";
              ?>
            <option value="<?=$sts_id;?>" <?=$selected; ?>><?=$sts_desc ?></option>
            <?php } ?>

          </select>
        </div>

        <div class="form-group mb-3">
          <button type="submit" class="btn btn-primary mb-3">Save Changes</button>
        </div>

      </form>
    </div>
  </div>

  <?= include 'includes/footer.php' ?>
</body>
</html>