<?php
session_start();
include('dbconnection.php');
define("APPURL", "http://localhost/db-uni-project");
$aid = $_SESSION['id'];

$admin = $conn->query("SELECT * from Admin where aid='$aid'")->fetch(PDO::FETCH_OBJ);

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <title>University Management System</title>
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/chartist/chartist.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
  <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

</head>

<body>
  <div id="page"></div>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo ml-auto text-right" href="dashboard.php">
          <h1>University Management System</h1>
        </a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.php">University Management System</a>
      </div>

      <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">

        <ul class="navbar-nav navbar-nav-right ml-auto">

          <li class="nav-item dropdown d-none d-sm-inline-flex user-dropdown">

            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span>
                <?php echo $admin->aname; ?>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">

              <div class="dropdown-header d-flex">


                <div>
                  <p class="mb-1 mt-3">
                    <?php echo $admin->aname; ?>
                  </p>
                  <p class="font-weight-light text-muted mb-0">
                    <?php echo $admin->email; ?>
                  </p>
                </div>

              </div>



              <a class="dropdown-item" href="<?php echo APPURL; ?>/admins/profile.php?id=<?php echo $admin->aid; ?>"><i
                  class="dropdown-item-icon icon-user text-primary"></i>My
                Profile</a>
              <a class="dropdown-item" href="<?php echo APPURL; ?>/logout.php"><i
                  class="dropdown-item-icon icon-power text-primary"></i>Sign
                Out</a>

            </div>

          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>