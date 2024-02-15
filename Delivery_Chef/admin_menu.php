<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }


// variables
$errorMessages = "";
$dishTitle = "";
$foodPrice = "";
$selCategory = "";
$fileImage = "";
$txtDesc = "";
$itemId = "";

  // is there item in the query string
  if(array_key_exists('item', $_GET)){ 
    // ?item=x is in the URL

    // check that the item exists in the DB
      $query = $db->prepare("SELECT * FROM menu WHERE  menu_id = :id");
      $query->execute(['id'=>$_GET['item']]);
   
      $data = $query->fetch(); 
      if(!$data){ // nothing found in the database
         pageNotFound();
      } 

    // populate the form
    $dishTitle = $data['dish_title'];
    $foodPrice = $data['price'];
    $selCategory = $data['foodcat_id'];
    $fileImage = $data['image'];
    $txtDesc = $data['description'];
    $itemId = $data['menu_id'];

  }
// check the POST method
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  //validating the form
  if(validateIsEmptyData($_POST, 'dishTitle')) {
    $errorMessages = "Dish title is required";
  }else {
    $dishTitle = $_POST['dishTitle'];
  }
  
  if(validateIsEmptyData($_POST, 'foodPrice')) {
    $errorMessages = "Price is required";
  }else {
    $foodPrice = $_POST['foodPrice'];
  }
  
  if(validateIsEmptyData($_POST, 'selCategory')) {
    $errorMessages = "Category is required";
  }else {
    $selCategory = $_POST['selCategory'];
  }

  $fileImage = $_POST['oldImage'] ?? ""; // tracking existing image during update
  $itemId = $_POST['itemId'] ?? ""; // track item id if it exists

  // If error message is empty then save to db
  if($errorMessages == ""){
    // save and upload the file (if applicable)
    if($_FILES['fileImage']['error'] == 0){

      $sourceFile = $_FILES['fileImage']['tmp_name'];
      $destinationFile = "image/menu/" . $_FILES['fileImage']['name'];

      if(move_uploaded_file($sourceFile, $destinationFile)){

        if($fileImage != "" && $fileImage != $destinationFile){
          unlink($fileImage);
        }
        $fileImage = $destinationFile;
      }

    } // end $_FILES error

    $txtDesc = $_POST['txtDesc'];
    $data = [
      "dishTitle"=>$dishTitle,
      "selCategory"=>$selCategory,
      "foodPrice"=>$foodPrice,
      "fileImage"=>$fileImage,
      "txtDesc"=>$txtDesc
    ];
    
   
    if($itemId == ""){
      // no item id was found = add new row to the database
      $sql = "INSERT INTO menu (dish_title, foodcat_id, price, image, description ) 
      VALUES (:dishTitle, :selCategory, :foodPrice, :fileImage, :txtDesc)";
    }else {
     // item id was found = update existing row
      $sql = "UPDATE menu SET dish_title = :dishTitle , foodcat_id = :selCategory, price = :foodPrice, 
         image = :fileImage, description = :txtDesc WHERE  menu_id= :id";
     
      $data['id'] = $itemId;    
     // add id to $data
    }

      $query = $db->prepare($sql);
      $query->execute($data);
  
       // if itemId does not exist (INSERT was performed) get the last inserted id from th DB
       if($itemId == "")  $itemId = $db->lastInsertId();
   
       // redirect user to the portfolio single item page
        header("location: menuItem.php?item={$itemId}");    
  }

}

  $pageTitle=  ($itemId == "")? "Add New Item" : "Update Item";
  $mainTitle = "Menu Edit";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?=$pageTitle?></title>
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

  <div class="container-fluid admin-menu-container py-3">
    <h1 class="text-center">Edit Menu</h1>

    <div class="row justify-content-center ">
      <form class="col-sm-6 col-sm-offset-3" method="POST" enctype="multipart/form-data" action="admin_menu.php">
        <input type="hidden" name="itemId" value=<?= $itemId; ?>>
        <input type="hidden" name="oldImage" value=<?= $fileImage; ?>>

        <div class="form-group mb-3">
          <label for="dish">Dish Title :</label>
          <input type="text" class="form-control" id="dish" name="dishTitle" value="<?=$dishTitle; ?>" required>
        </div>
        <div class="form-group mb-3">
          <label for="price">Price :</label>
          <input type="text" class="form-control" id="price" name="foodPrice" value="<?=$foodPrice; ?>" required>
        </div>
        <div class="form-group mb-3">
          <label for="fileImage">Image :</label>
          <input type="file" class="form-control" id="fileImage" name="fileImage">
        </div>
        <div class="form-group mb-3">
          <label for="selCategory">Food Category : </label>
          <select class="form-select" name="selCategory" aria-label="Default select example" required>
            <option value="">Select the Category</option>
            <?php foreach($allCategories as $cat_id => $cat_name) { 
              $selected = ($cat_id == $selCategory)? "selected" : "";
              ?>
            <option value="<?=$cat_id;?>" <?=$selected; ?>><?=$cat_name ?></option>
            <?php } ?>

          </select>
        </div>

        <div class="form-group mb-3">
          <label for="descFood">Description :</label>
          <textarea type="text" class="form-control" cols="40" rows="5" id="descFood"
            name="txtDesc"><?=$txtDesc; ?></textarea>
        </div>

        <div class="form-group mb-3">
          <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>


      </form>
    </div>
  </div>

<?= include 'includes/footer.php' ?>
</body>
</html>