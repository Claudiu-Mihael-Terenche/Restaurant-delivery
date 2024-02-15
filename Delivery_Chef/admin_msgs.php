<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }


  if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    $remove = $db->prepare("DELETE FROM ContactUs WHERE ContactUsID = :remove_id");
    $remove->bindParam(':remove_id', $remove_id);
    if($remove->execute()){
       header('location: admin_msgs.php');
    }
  }

  $sql = "SELECT * FROM ContactUs"; 
  $query = $db->prepare($sql);
  $query->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Messages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="css/admin.css" />
</head>
<body>
  <div class="main-container d-flex">
    <?= include 'admin_sidebar.php' ?>

    <div class="container-fluid content-container">
      <div class="header-box">
        <div class="header-title p-3">
          <h2>Messages</h2>
        </div>
      </div>

      <div class="card-container p-3 mt-2">
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Message Date</th>
                <th scope="col">Message Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Message</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              while ($row = $query->fetch()) {
              ?>
              <tr>
                <td><?= $row['Timestamp']; ?></td>
                <td><?= $row['ContactUsID']; ?></td>
                <td><?= $row['FullName']; ?></td>
                <td><?= $row['UserEmail']; ?></td>
                <td><?= $row['Message']; ?></td>
                <td>
                  <button class="btn btn-danger">
                    <a class="text-white text-decoration-none" href="admin_msgs.php?remove=<?= $row['ContactUsID']; ?>" onclick="return confirm('Delete message?')" class="delete-btn text-white">
                      <i class="bi bi-trash text-white"></i>Delete
                    </a>
                  </button>
                </td>
              </tr>
              <?php 
              } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>