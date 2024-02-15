<?php
require_once "dbConnect.php";

// Preventing unauthorized access 
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php ");
  }else if($_SESSION['role'] !== 'admin'){
    header("Location: index.php ");   
  }


  $sql = "SELECT * FROM menu ORDER BY foodcat_id ASC";
  $query = $db->prepare($sql);
  $query->execute();


  $sqlCat = "SELECT foodcat_desc FROM food_cat WHERE foodcat_id = :id";
  $queryCat = $db->prepare($sqlCat);
  $data = [];
  $catName = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin</title>
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
          <h2>Menu</h2>
          <a href="admin_menu.php">
            <p> [ Add Menu ]</p>
          </a>
        </div>
      </div>

      <div class="card-container p-3 mt-2">
        <div class="table-container">
          <table class="table table-striped table-responsive">
            <thead>
              <tr>
                <th scope="col">Category</th>
                <th scope="col">Image</th>
                <th scope="col">Dish name</th>
                <th scope="col">Price</th>
                <th scope="col">Edit</th>
              </tr>
            </thead>

            <tbody>
              <?php while($row = $query->fetch()) { 
                  $data['id']= $row['foodcat_id'];
                  $queryCat->execute($data);
                  $catName = $queryCat->fetchColumn();
                ?>

              <tr>
                <td><?=$catName;?></td>
                <td><img class="menu-img" src="<?=$row['image']; ?>" alt=""></td>
                <td><a href="menuItem.php?item=<?=$row['menu_id']; ?>"><?=$row['dish_title']; ?></a></td>
                <td><?=$row['price'] . "$"; ?></td>
                <td>
                  <button class="btn btn-warning update-delete p-2 mx-1 rounded-3"><a class="text-dark text-decoration-none"
                      href="admin_menu.php?item=<?=$row['menu_id']; ?> "><i class="bi bi-pencil"></i> Update</a></button>
                      
                      <button
                    class="btn btn-danger update-delete p-2 mx-1 rounded-3"><a class="text-decoration-none text-white"
                      href="deleteMenu.php?item=<?=$row['menu_id']; ?>"><i class="bi bi-trash text-white"></i> Delete</a></button>

                </td>
              </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>



    </div>
  </div>
  </div>

  </div>
  </div>
</body>

</html>