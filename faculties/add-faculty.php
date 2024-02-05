<?php
include('../includes/header.php'); ?>
<?php
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
} ?>
<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["fname"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {
    $fname = $_POST["fname"];



    $query2 = $conn->prepare("INSERT INTO Faculty (fname) VALUES (:fname)");
    $query2->execute([
      ":fname" => $fname,
    ]);

    echo "<script>alert('Faculty added successfully!')</script>";
    header("location: " . APPURL . "/faculties/manage-faculties.php");


  }
}

?>


<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Faculty </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Add Faculty</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Faculty Name</label>
                  <input type="text" name="fname" value="" class="form-control" required='true'>
                </div>


                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                </div>
              </form>

            </div>
            <?php include_once('../includes/footerText.php'); ?>
          </div>

        </div>
      </div>
    </div>

    <?php include_once('../includes/footer.php'); ?>

  </div>
</div>
</div>