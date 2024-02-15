<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }


$errorMsg ="";

if (isset($_GET['remove'])) {
  $userId = $_GET['remove'];

  if ($userId !== 1) {
    $sql = "DELETE FROM users WHERE id = :remove_user";
    $remove = $db->prepare($sql);
    $remove->bindParam(':remove_user', $userId);
    
    if ($remove->execute()) {
      header('location: admin_users.php');
    } else {
      // Handle deletion error
      $errorMsg = "Error deleting user.";
    }
  } else {
    $errorMsg = "Cannot delete admin.";
  }
} 

$sql = "SELECT * FROM users"; 
  $query = $db->prepare($sql);
  $query->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Settings</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="css/admin.css" />

  <script>
    function showAlert(message) {
      alert(message);
    }
  </script>

</head>

<body>
  <div class="main-container d-flex">

    <!-- Side Bar -->
    <?= include 'admin_sidebar.php' ?>

    <div class="container-fluid content-container">
      <div class="header-box">
        <div class="header-title p-3">
          <h2>Users</h2>
        </div>
      </div>

      <div class="card-container p-3 mt-2">
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Email</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Edit</th>
              </tr>
            </thead>
            <tbody>

              <?php while($row = $query->fetch()) { ?>
              <tr>
                <th><?=$row['id']; ?></th>
                <th><?=$row['email']; ?></th>
                <th><?=$row['fname']. " " . $row['lname']; ?></th>
                <th><?=$row['address']; ?></th>
                <th>
    
                  <button class="btn btn-warning update-delete p-2 mx-1 rounded-3"><a class="text-dark text-decoration-none"
                      href="admin_userUpdate.php?userId=<?= $row['id']; ?>"><i class="bi bi-pencil"></i> Update</a></button>
       
                      
                      <button class="btn btn-danger">
                    <a class="text-white text-decoration-none" href="admin_users.php?remove=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="delete-btn text-white">
                      <i class="bi bi-trash text-white"></i> Delete
                    </a>
                  </button>

              <?php } ?>


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
    <?php
    if (!empty($errorMsg)) {
      echo "<script>showAlert('$errorMsg');</script>";
    }
    ?>
  </div>
  </div>
</body>

</html>