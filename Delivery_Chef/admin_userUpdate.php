<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }


$userId = $_GET['userId'];

$fetch_sql = "SELECT * FROM users WHERE id = :userId";
$fetch_id = $db->prepare($fetch_sql);
$fetch_id->bindParam(':userId', $userId, PDO::PARAM_INT);
$fetch_id->execute();
$user = $fetch_id->fetch();

$email = $user['email'];
$firstName = $user['fname'];
$lastName = $user['lname'];
$address = $user['address'];
$city = $user['city'];
$province = $user['province'];
$zip = $user['zip'];
$phone = $user['phone'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];

    $data = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'address' => $address,
        'city' => $city,
        'province' => $province,
        'zip' => $zip,
        'phone' => $phone,
        'userId' => $userId,
    ];

    $update_sql = "UPDATE users SET fname = :firstName, lname = :lastName, address = :address, city = :city,
               province = :province, zip = :zip, phone = :phone WHERE id = :userId";
    $update_id = $db->prepare($update_sql);
    $update_id->execute($data);

    // echo '<div class="alert alert-success" role="alert">Profile updated successfully</div>';

    header("Location: admin_users.php");
    exit();
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
          <li class="nav-item"><a class="nav-link mx-3 text-white" href="admin_users.php">Back to <i class="bi bi-person-circle mx-1 text-white"></i> Users</a></li>
        </ul>
        <?php include "admin_navbar_log.php" ?>
      <?php    } else { ?>
        <?php include "navbar_login.php" ?>
      <?php   } ?>
  </nav>
  <div class="container profile-container my-3">
    <h1>Edit Profile</h1>
    <form method="POST" enctype="multipart/form-data" action="">
      <div class="form-group mt-3">
        <label>Email</label>
        <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $email; ?>"
                    readonly>
      </div>

      <div class="row mt-3">
        <div class="form-group col-md-6">
          <label>First Name</label>
          <input type="text" class="form-control" name="fname" value="<?= $firstName; ?>">
        </div>
        <div class="form-group col-md-6">
          <label>Last Name</label>
          <input type="text" class="form-control" name="lname" value="<?= $lastName;?>">
        </div>
      </div>



      <div class="form-group mt-3">
        <label for="inputAddress">Address</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address"
          value="<?= $address;?>">
      </div>


      <div class="row mt-3">
        <div class="form-group col-md-6">
          <label>City</label>
          <input type="text" class="form-control" name="city" value="<?= $city;?>">
        </div>
        <div class="form-group col-md-3">
          <label>Province</label>
          <input type="text" class="form-control" name="province" value="<?= $province;?>">
        </div>
        <div class="form-group col-md-3">
          <label>Postal Code</label>
          <input type="text" class="form-control" name="zip" value="<?= $zip;?>">
        </div>
      </div>

      <div class="form-group mt-3 col-md-6">
        <label>Phone:</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="123-456-9870" name="phone"
          value="<?= $phone;?>">
      </div>
      <div class="text-center mt-5">
        <button type="submit" class="btn btn-primary changes">Save changes</button>

        <!-- <p class="text-danger mt-3"><?=$resultMessages ?></p> -->
      </div>
    </form>
  </div>

  <?= include 'includes/footer.php' ?>
</body>
</html>