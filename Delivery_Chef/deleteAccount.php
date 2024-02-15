<?php
require 'dbConnect.php';

$errorMessages = "";

if (isset($_POST['submit'])) {
    $password = $_POST['pwd_deleteAccount']; 

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $check = $db->prepare("SELECT * FROM users WHERE id = :user_id");
        $check->bindParam(':user_id', $user_id);
        $check->execute();
        $user = $check->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $deleteUser = $db->prepare("DELETE FROM users WHERE id = :user_id");
                $deleteUser->bindParam(':user_id', $user_id);
                $deleteUser->execute();
                session_destroy(); 
                header("Location: index.php");
                exit();
            } else {
                $errorMessages = "Incorrect password.";
            }
        } else {
            $errorMessages = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Account</title>

  <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
<?= include "includes/navbar_logo.php"?>
      <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>
        <?php include "user_navbar_profile.php" ?>
      <?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>

        <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
          <li class="nav-item"><a class="nav-link mx-3 text-white" href="menu.php">Back to Menu</a></li>
        </ul>
        <?php include "admin_navbar_log.php" ?>
      <?php    } else { ?>
        <?php include "navbar_login.php" ?>
      <?php   } ?>
  </nav>

  <div class="container profile-container my-3">
  <h1>Delete Profile</h1>
  <form method="POST" action="">
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" class="form-control" id="pwd_deleteAccount" name="pwd_deleteAccount" required>
        </div>

        <span class="text-danger"><?= $errorMessages ?></span>

        <div class="text-right mt-3">
          <button type="submit" class="btn btn-danger" name="submit">Confirm</button>
        </div>
      </div>
    </div>
  </form>
</div>

<?= include 'includes/footer.php' ?>
</body>
</html>







