<?php
require'dbConnect.php';

$email = "";
$fname = "";
$lname = "";
$address = "";
$city = "";
$province = "";
$zip = "";
$phone = "";
$resultMessages = "";
$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = :userId";
$query = $db->prepare($sql);
$query->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
$query->execute();

$result = $query->fetch();


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $isPhoneValid = validatePhone($_POST['phone']);
    if(!$isPhoneValid){
      $phone = "0000000000";
    }else {
      $phone = $_POST['phone'];
    }
  
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $province = $_POST['province'];
  $zip = $_POST['zip'];

  $data = [
    "fname"=>$fname,
    "lname"=>$lname,
    "address"=>$address,
    "city"=>$city,
    "province"=>$province,
    "zip"=>$zip,
    "phone"=>$phone,
    "userId"=>$userId
  ];
  
  $sqlEdit = "UPDATE users SET fname = :fname, lname = :lname, address = :address, city = :city, 
          province = :province, zip = :zip, phone = :phone WHERE id = :userId";

   $queryEdit = $db->prepare($sqlEdit);
   if($queryEdit->execute($data)){
    // header('location: updateAccount.php');
    $resultMessages = 'Profile updated successfully';
   };
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>

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
          <li class="nav-item"><a class="nav-link mx-3 text-white" href="menu.php">Back to User</a></li>
        </ul>
        <?php include "admin_navbar_log.php" ?>
      <?php    } else { ?>
        <?php include "navbar_login.php" ?>
      <?php   } ?>
  </nav>

  <div class="container profile-container my-3">
    <h1>Edit Profile</h1>
    <form method="POST" enctype="multipart/form-data" action="updateAccount.php">
      <div class="form-group mt-3">
        <label>Email</label>
        <input type="email" class="form-control" placeholder="Email" name="email" value="<?=$result['email']; ?>"
          readonly>
      </div>

      <div class="row mt-3">
        <div class="form-group col-md-6">
          <label>First Name</label>
          <input type="text" class="form-control" name="fname" value="<?=$result['fname']; ?>">
        </div>
        <div class="form-group col-md-6">
          <label>Last Name</label>
          <input type="text" class="form-control" name="lname" value="<?=$result['lname'];?>">
        </div>
      </div>



      <div class="form-group mt-3">
        <label for="inputAddress">Address</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address"
          value="<?=$result['address'];?>">
      </div>


      <div class="row mt-3">
        <div class="form-group col-md-6">
          <label>City</label>
          <input type="text" class="form-control" name="city" value="<?=$result['city'];?>">
        </div>
        <div class="form-group col-md-3">
          <label>Province</label>
          <input type="text" class="form-control" name="province" value="<?=$result['province'];?>">
        </div>
        <div class="form-group col-md-3">
          <label>Postal Code</label>
          <input type="text" class="form-control" name="zip" value="<?=$result['zip'];?>">
        </div>
      </div>

      <div class="form-group mt-3 col-md-6">
        <label>Phone:</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="123-456-9870" name="phone"
          value="<?=$result['phone'];?>">
      </div>
      <div class="text-center mt-5">
        <button type="submit" class="btn btn-primary changes">Save changes</button>

        <p class="text-danger mt-3"><?=$resultMessages ?></p>
      </div>
    </form>
  </div>

  <?= include 'includes/footer.php' ?>
</body>
</html>