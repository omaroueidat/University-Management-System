<?php
include('../includes/header.php'); ?>
<?php
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
} ?>
<?php $departments = $conn->query("SELECT * FROM Department")->fetchAll(PDO::FETCH_OBJ); ?>
<?php $faculties = $conn->query("SELECT * FROM Faculty")->fetchAll(PDO::FETCH_OBJ); ?>
<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["fid"]) || empty($_POST["did"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {
    $fid = $_POST["fid"];
    $did = $_POST["did"];



    $query2 = $conn->prepare("INSERT INTO FacDepReg (fid, did) VALUES (:fid, :did)");
    $query2->execute([
      ":fid" => $fid,
      ":did" => $did,
    ]);

    echo "<script>alert('Department registered successfully!')</script>";
    header("location: " . APPURL . "/departments/registered-departments.php");


  }
}

?>


<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Register Department </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Register Department</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Department</label>
                  <select name="did" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($departments as $department): ?>
                      <option value='<?php echo $department->did; ?>'>
                        <?php echo $department->dname; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Faculty</label>
                  <select name="fid" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($faculties as $faculty): ?>
                      <option value='<?php echo $faculty->fid; ?>'>
                        <?php echo $faculty->fname; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>


                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Register</button>
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