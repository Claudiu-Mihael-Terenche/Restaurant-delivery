<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant Delivery</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>

<body>
<?= require_once "dbConnect.php"?>
  <?= include "includes/navbar_logo.php"?>
    <ul class="navbar-nav ms-auto flex-row flex-wrap mx-center my-auto">
      <li class="nav-item"><a class="nav-link mx-3 text-white" href="menu.php">Online Menu</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="#about-us">About Us</a></li>
      <li class="nav-item"><a class="nav-link mx-3 text-white" href="#contact-us">Contact Us</a></li>
    </ul>
  
    <?php if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "user") { ?>

      <?php include "user_navbar_profile.php" ?>

<?php  } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin") { ?>

      <?php include "admin_navbar_log.php" ?>

      <?php    } elseif (isset($_SESSION["user_id"]) && $_SESSION["role"] === "employee") { ?>

        <?php include "emp_navbar_log.php" ?>

<?php    } else { ?>
  <?php include "navbar_login.php" ?>
<?php   } ?>
</div>
</nav>
  
  <header>
    <div class="jumbotron text-center d-flex justify-content-center align-items-center container-1">
      <div class="container-1-item col-lg-12 text-center">
        <h1>Welcome to Delivery Chef</h1>
        <h2>Delicious Food Are Waiting for you!</h2>
        <button type="button" class="btn btn-warning"><a href="./menu.php">Order Online</a></button>
      </div>
  </header>

  <!-- Gallery Section -->
  <?php include "gallery.php" ?>

  <!-- About us Section -->
    <div class="container-fluid container-3" id="about-us">
      <div class="row">
        <div class="image-container text-center col-lg-6">
          <img src="image/aboutus.jpg" alt="chefs knife" class="img-fluid mx-auto my-3" />
        </div>
        <div class="aboutus-container col-lg-6">
          <h2 class="text-center">About Us</h2>
          <p>
            At Delivery Chef, we believe that great food should be accessible to everyone, no matter where they are or
            what their schedule looks like. That's why we've embarked on a flavorful journey to redefine dining in the
            modern world. With a passion for culinary excellence, a commitment to convenience, and a dash of creativity,
            we've crafted a unique experience just for you.
          </p>

          <h3>Our Story</h3>
          <p> Delivery Chef was born out of a shared love for delicious food and a deep appreciation for the art of
            cooking. Our founders, Alex and Mia, were both professional chefs with an unwavering dedication to their
            craft. However, they also understood the challenges that people face in their busy lives when it comes to
            enjoying a restaurant-quality meal.
            With this in mind, they set out to bridge the gap between fine dining and everyday life. They envisioned a
            restaurant that doesn't confine you to a physical location or a rigid schedule but brings gourmet dishes to
            your doorstep whenever you crave them.
          </p>
        </div>

        <div class="aboutus-container col-lg-6">
          <h3>Our Culinary Team</h3>
          <p>
            At Delivery Chef, we've assembled a diverse team of culinary virtuosos who bring a world of flavors to your
            plate. Our chefs hail from different culinary backgrounds, each with their own signature dishes and styles.
            Together, they create an extensive menu that caters to every palate, from classic comfort foods to
            international delicacies.
            <br>
            <br>
            Our chefs are passionate about sourcing the freshest ingredients, and they infuse each dish with creativity
            and care, resulting in a dining experience that transcends the ordinary.
          </p>
          <br>
          <br>
          <h3>Our Vision</h3>
          <p>
            At Delivery Chef, our vision is clear: to transform the way you experience food. We want to be more than
            just a restaurant; we want to be a part of your everyday life. A culinary adventure is no longer reserved
            for special occasions; it's now an integral part of your daily routine.
          </p>
        </div>
        <div class="image-container text-center col-lg-6">
          <img src="./image/Chefs.jpg" alt="chefs" class="img-fluid mx-auto my-3 img-1" />
        </div>
      </div>
    </div>

  <!-- Contact us Section -->
  <?php include "contactus.php" ?>

 
<!-- Footer Section -->
    <?php include "includes/footer.php" ?>

  </body>
</html>