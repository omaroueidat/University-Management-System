<?php
session_start();

define("APPURL", "http://localhost/db-uni-project");


include('includes/dbconnection.php');

if (isset($_SESSION["id"])) {
  header("location: dashboard.php");
}

if (isset($_POST["login"])) {
  if (empty($_POST["username"]) || empty($_POST["password"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $login = $conn->query("SELECT * FROM Admin WHERE username='$username'")->fetch(PDO::FETCH_ASSOC);

    if ($login) {
      if (password_verify($password, $login["apassword"])) {

        $_SESSION["username"] = $login["username"];
        $_SESSION["id"] = $login["aid"];

        header("location: dashboard.php");
      } else {

        echo "<script>alert('Credentials didn't match!')</script>";

      }
    } else {
      echo "<script>alert('username missing');</script>";
    }

  }

}
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <title>UMS :: Login Page</title>
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>/assets/css/style.css">
  <style>
    .content-wrapper {
      background-image: url('<?php echo APPURL; ?>/assets/images/background.jpg');
      background-size: cover;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-center p-5">
              <h2>University Management System</h2>

              <h6 class="font-weight-light">Hello! Sign In</h6>
              <form class="pt-3" id="login" method="post" name="login">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" placeholder="Enter your username"
                    required="true" name="username">
                </div>
                <div class="form-group">

                  <input type="password" class="form-control form-control-lg" placeholder="Enter your password"
                    name="password" required="true">
                </div>
                <div class="mt-3">
                  <button class="btn btn-success btn-block loginbtn" name="login" type="submit">Login</button>
                </div>



              </form>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <script src="<?php echo APPURL; ?>/assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo APPURL; ?>/assets/js/off-canvas.js"></script>
  <script src="<?php echo APPURL; ?>/assets/js/bootstrap.min.js"></script>

</body>

</html>