<?php
require_once "dbConnect.php";

$sql = "SELECT * FROM tblgallery;";
$query = $db->query($sql);
?>

<div class="container-fluid text-center container-2 mt-4 mb-4">
  <h2>Gallery</h2>
  <div class="gallery-container">
    <?php
    while ($row = $query->fetch()) {
      $title = $row['title'];
      $file_path = $row['file_path'];
      ?>
    <div class="gallery-item">
      <img src="<?=$file_path?>" alt="<?=$title?>" class="img-fluid">
    </div>
    <?php }
    ?>
  </div>
</div>