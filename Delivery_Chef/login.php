<?php
require_once 'dbConnect.php';
// print_r($_POST); // to remove (debugging)

if(isset($_SESSION['user_id'])) {
  if($_SESSION['role'] == 'employee'){
    header('Location: emp_dashboard.php');
    exit();
  }else{
    header('Location: index.php');
    exit();
  }
}

$errorMessages = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $user_email = sanitizeEmail($_POST['login_email']);
    $loginPwd = $_POST['login_password'];

    if (validateEmail($user_email)) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $check = $db->prepare($sql);
        $check->execute(["email" => $user_email]);
        $data = $check->fetch();

        if ($data) {
          if(password_verify($loginPwd, $data['password'])){
            $_SESSION['user_id'] = $data['id'];

            if ($data['role'] == 'user') {
                $_SESSION['role'] = 'user';
                header("Location: index.php");
                exit();
            } elseif ($data['role'] == 'admin') {
                $_SESSION['role'] = 'admin';
                header("Location: dashboard.php");
                exit();
            }
          }else {
            $errorMessages = "Invalid password";
          }
        } else {
          $sqlEmp = "SELECT * FROM emp_delivery WHERE emp_email = :email";
          $checkEmp = $db->prepare($sqlEmp);
          $checkEmp->execute(["email" => $user_email]);
          $dataEmp = $checkEmp->fetch(); 

          if ($dataEmp) {
            if(password_verify($loginPwd, $dataEmp['emp_pw'])){
            $_SESSION['user_id'] = $dataEmp['emp_id'];
            $_SESSION['role'] = 'employee';
            header("Location: emp_dashboard.php");
            exit();
            }else{
              $errorMessages = "Invalid password";
            }
          } else {
            $errorMessages = "Invalid email";
          }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="./css/login-register.css" />
</head>

<body>
  <?= include 'includes/navbar_logo.php' ?>
  </nav>

  <div class="login-register-container container-fluid py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="form-box p-4">
          <h2 class="text-white text-center mt-3">Log In</h2>


          <form class="input-group text-center mx-auto py-5 px-auto" id="login" action="" method="post">
            <div class="input-box mb-3">
              <span class="icon"><i class="bi bi-envelope"></i></span>
              <input type="email" class="input-field" name="login_email" value="" required />
              <label for="login_email">Email</label><br>
            </div>

            <div class="input-box mb-3 mt-1">
              <span class="icon"><i class="bi bi-lock"></i></span>
              <input type="password" class="input-field" name="login_password" value="" required />
              <label for="login_password">Password</label>
            </div>

            <div class="form-check remember-forgot mb-3 d-flex flex-column text-center mx-auto">
              <label for="" class="remember-text text-white"><input type="checkbox" class="check-box mb-3"
                  name="remember_me" />Remember
                Password</label>
              <a href="#">Forgot Password?</a>
            </div>

            <div class="register-login-link-box my-3 mx-auto">
              <p class="text-white">Already have an account? <a href="signup.php" class="register-link">Sign Up</a>
              </p>
            </div>

            <button type="submit" class="submit-btn m-auto py-3 btn btn-warning rounded-3" name="submit">
              Log in
            </button>

            <span class="error-msg"><?php echo $errorMessages; ?></span>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?= include 'includes/footer.php' ?>
</body>

</html>