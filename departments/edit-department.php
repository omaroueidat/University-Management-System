<?php
include('../includes/header.php'); ?>
<?php
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
} ?>
<?php
$id = $_GET['editid'];
$department = $conn->query("SELECT * FROM Department WHERE did = '$id'")->fetch(PDO::FETCH_OBJ); ?>
<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["dname"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {
    $dname = $_POST["dname"];
    $queryUpdate = $conn->prepare("UPDATE Department SET dname = :dname WHERE did = '$id'");
    $queryUpdate->execute([
      ":dname" => $dname,


    ]);

    if ($queryUpdate->rowCount() > 0) {
      echo "<script>alert('Department updated successfully!')</script>";
      header("location: " . APPURL . "/departments/manage-departments.php");
    } else {
      echo "<script>alert('Failed to update the department!')</script>";
    }
  }



}

?>


<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Edit Department </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="manage-departments.php">Manage Departments</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit Department</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Department Name</label>
                  <input type="text" name="dname" value="<?= $department->dname ?>" class="form-control" required='true'>
                </div>


                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Save</button>
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