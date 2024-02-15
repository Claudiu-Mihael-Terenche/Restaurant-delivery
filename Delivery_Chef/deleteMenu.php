<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }

$errorMessages = "";
$resultMessage = "";

// filtering invalid access to the page
if(!$_SESSION['user_id']){
  header("Location: index.php");
}

// check if item value exists on the GET
if(!isset($_GET)){
  menuPageNotFound();
}

$data = [
  'id'=>$_GET['item']
];

// check if the item exists in the DB
$query = $db->prepare("SELECT * FROM menu WHERE menu_id = :id");
$query->execute($data);
$result = $query->fetch();

if(!$result){
  menuPageNotFound();
}

if (isset($_POST['submit'])){
  $user_id = $_SESSION['user_id'];
  $pwd = $_POST['pwd_deleteMenu'];

  $sql = "SELECT * FROM users WHERE id = :userId";
  $queryAdmin = $db->prepare($sql);
  $queryAdmin->bindParam(":userId", $user_id, PDO::PARAM_INT);
  $queryAdmin->execute();
  $admin = $queryAdmin->fetch();

  if($admin && $_SESSION['role'] === 'admin') {
    if(password_verify($pwd, $admin['password'])){
      // delete if exists
      $query = $db->prepare("DELETE FROM menu WHERE menu_id = :id");
      $query->execute($data);

      // remove the image if exist
    if($result['image'] != ""){
       unlink($result['image']);
      }
      $resultMessage ="[ " . $result['dish_title'] . " ] " . " has been succesfully removed.";
    }else{
      $errorMessages = "Invalid Password!";
    }
    
  }else {
    $errorMessages = "Invalid User!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delete Menu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/user_account.css" />
  <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>

  <body>
      <?= include "includes/navbar_logo.php"?>
      <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>
        <?php include "user_navbar_profile.php" ?>
      <?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>

        <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
          <li class="nav-item"><a class="nav-link mx-3 text-white" href="admin_menu_dashbd.php">Back to Menu</a></li>
        </ul>

        <?php include "admin_navbar_log.php" ?>
      <?php    } else { ?>
        <?php include "navbar_login.php" ?>
      <?php   } ?>
  </nav>

<div class="profile-container my-3">
  <h1>Delete Menu</h1>
  <form method="POST" action="">
    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" class="form-control" id="pwd_deleteMenu" name="pwd_deleteMenu" required>
    </div>

    <span class="text-danger"><?= $errorMessages ?></span>
    <span class="text-danger"><?= $resultMessage ?></span>

    <div class="text-right mt-3">
      <button type="submit" class="btn btn-danger" name="submit">Delete Menu</button>
    </div>
</div>
</div>
</form>
</div>

<?= include 'includes/footer.php' ?>
</body>
</html>