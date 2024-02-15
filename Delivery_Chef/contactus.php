<div class="container-fluid text-center container-4 my-4" id="contact-us">
      <h2>Contact Us</h2>
      <p>Delivery Chef is located in the heart of Old Montreal.</p>

      <div class="container-fluid location-container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-lg-4">
            <div class="info-container flex-column">
              <div class="location-item">
                <div class="icon"><i class="bi bi-geo-alt"></i></div>
                <h3>Address</h3>
                <p>122 Rue Saint-Paul E,<br>Montreal, Quebec, h2Y 1G6</p>
              </div>

              <div class="location-item ">
                <div class="icon"><i class="bi bi-envelope"></i></div>
                <h3>Email</h3>
                <p>DeliveryChef@gmail.com</p>
              </div>

              <div class="location-item py-1">
                <div class="icon"><i class="bi bi-telephone"></i></div>
                <h3>Phone</h3>
                <p>514-123-4567</p>
              </div>

              <div class="location-item py-1">
                <h3>Follow Us</h3>
                <div class="icon"><a href=""><i class="bi bi-instagram"></i></a><a href=""><i
                      class="bi bi-facebook  mx-2"></i></a><a href=""><i class="bi bi-twitter-x"></i></a></div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 map-container">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d174.76873274555984!2d-73.55471582926054!3d45.50404474944808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc91a57815abb25%3A0x43633c7b12b3b712!2s122%20Rue%20Saint-Paul%20E%2C%20Montr%C3%A9al%2C%20QC%20H2Y%201G6!5e0!3m2!1sen!2sca!4v1697337649777!5m2!1sen!2sca"
              width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>

      <?php
      require_once 'dbConnect.php';

      if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
        $emailSanitized = sanitizeEmail($_POST['email']);

        if (validateEmail($emailSanitized)) {
          $email = $_POST['email'];
        }

        $name = $_POST['name'];
        $message = $_POST['message'];

        $sql = "INSERT INTO ContactUs (FullName, UserEmail, Message) VALUES (:name, :email, :message)";
        $query = $db->prepare($sql);
        $query->bindParam(':name', $name);
        $query->bindParam(':email', $email);
        $query->bindParam(':message', $message);

        $query->execute();
    }

      ?>
      <div class="contact-container text-center mx-auto my-auto px-5 py-4 col-lg-4">
        <form method="post" action="">
          <h2>Send Us A Message</h2>
          <div class="contact-item">
            <input type="text" name="name" required>
            <span>Full Name</span>
          </div>

          <div class="contact-item mt-2">
            <input type="text" name="email" required>
            <span>Email</span>
          </div>

          <div class="contact-item mt-2">
            <textarea name="message" required></textarea>
            <span>Type your Message...</span>
          </div>

          <div class="contact-item mt-2">
            <input type="submit" name="submit" value="Send">
          </div>

        </form>
      </div>