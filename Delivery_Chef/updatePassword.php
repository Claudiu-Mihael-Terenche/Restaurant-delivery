<?php
require 'dbConnect.php';
$currentPassword = $newPassword = $confirmNewPassword = '';
$errorMessages = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $currentPassword = $_POST['user_currentPwd'];
  $newPassword = $_POST['user_newPwd'];
  $confirmNewPassword = $_POST['user_confirmPwd'];

  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $check = $db->prepare("SELECT password FROM users WHERE id = ?");
    $check->execute([$user_id]);
    $user = $check->fetch();

    if (!password_verify($currentPassword, $user['password'])) {
      $errorMessages = 'Incorrect current password';
    } elseif ($newPassword !== $confirmNewPassword) {
      $errorMessages = 'Passwords do not match';
    } elseif (!validatePassword($newPassword)) {
      $errorMessages = 'New password must be at least 5 characters long';
    } else {
      $hashedPassword = hashPassword($newPassword);
      $updatePassword = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
      $updatePassword->execute([$hashedPassword, $user_id]);
      $errorMessages = 'Password updated successfully';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Password</title>

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
  <h1>Update Password</h1>
    <form method="POST" action="">

      <div class="form-group mt-3">
        <label class="form-label">Current password</label>
        <input type="password" class="form-control" name="user_currentPwd" required/>
      </div>
      <div class="form-group mt-3">
        <label class="form-label">New password</label>
        <input type="password" class="form-control" name="user_newPwd" required/>
      </div>
      <div class="form-group mt-3">
        <label class="form-label">Repeat new password</label>
        <input type="password" class="form-control" name="user_confirmPwd" required/>
      </div>

      <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

        <?php if (!empty($errorMessages)) { ?>
          <p class="text-danger mt-3"><?=$errorMessages?></p>
        <?php } ?>

    </form>
  </div>
</div>

<?= include 'includes/footer.php' ?>
</body>
</html>
