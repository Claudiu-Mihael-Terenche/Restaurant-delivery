<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?=$pageTitle; ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" type="text/css" href="css/admin.css" />
</head>

<div class="main-container d-flex">

  <!-- Side Bar -->
  <?= include 'admin_sidebar.php' ?>

  <div class="container-fluid content-container">
    <div class="header-box">
      <div class="header-title p-3">
        <h2><?=$catTitle;?></h2>
      </div>
    </div>