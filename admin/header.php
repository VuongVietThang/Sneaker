<?php 
include '../config/database.php';
require '../model/db.php';
require '../model/banner.php';
require '../model/user.php';
require '../model/brand.php';
require '../model/faq.php';

require '../model/order.php';
require '../model/contact.php';
require '../model/statistical.php';
require '../model/encryption_helpers.php';

session_start();
if (!isset($_SESSION['user']) || !$_SESSION['user']['admin_id']) {
  header("Location: ../admin/404.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shop Bán Giày Trực Tuyến</title>
  <!-- Thêm Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style_admin.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href=""><img src="../images/logo.svg" class="mr-2"
            alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href=""><img src="../images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <i class="fas fa-bars"></i> <!-- Sử dụng biểu tượng menu từ Font Awesome -->
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item">
          <?php 
            if (isset($_SESSION['user'])) { 
                echo '<a class="nav-link" href="../view/logout.php"> 
                          <button class="btn btn-danger">Logout</button>
                      </a>'; 
            } 
            ?>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <i class="fas fa-bars"></i> <!-- Sử dụng biểu tượng menu từ Font Awesome -->
        </button>
      </div>
    </nav>