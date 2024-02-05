<?php
include('../includes/header.php'); ?>
<?php
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
} ?>
<?php
$id = $_GET['editid'];

$bound = $conn->query("SELECT * FROM FacDepReg WHERE id = '$id'")->fetch(PDO::FETCH_OBJ);
$departments = $conn->query("SELECT * FROM Department")->fetchAll(PDO::FETCH_OBJ);
$faculties = $conn->query("SELECT * FROM Faculty")->fetchAll(PDO::FETCH_OBJ); ?>


<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["did"]) || empty($_POST["fid"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {
    $did = $_POST["did"];
    $fid = $_POST["fid"];
    $queryUpdate = $conn->prepare("UPDATE FacDepReg SET did = :did, fid = :fid WHERE id = '$id'");
    $queryUpdate->execute([
      ":did" => $did,
      ":fid" => $fid,

    ]);

    if ($queryUpdate->rowCount() > 0) {
      echo "<script>alert('Registration updated successfully!')</script>";
      header("location: " . APPURL . "/departments/registered-departments.php");
    } else {
      echo "<script>alert('Failed to update the registration!')</script>";
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
            <li class="breadcrumb-item"><a href="registered-departments.php">Manage Registered Departments</a></li>
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
                  <label for="exampleInputName1">Department</label>
                  <select name="did" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($departments as $department): ?>
                      <?php if ($department->did === $bound->did): ?>
                        <option value='<?php echo $bound->did; ?>' selected>
                          <?php echo $department->dname; ?>
                        </option>

                      <?php else: ?>
                        <option value='<?php echo $department->did; ?>'>
                          <?php echo $department->dname; ?>
                        </option>
                      <?php endif; ?>

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
                      <?php if ($faculty->fid === $bound->fid): ?>
                        <option value='<?php echo $bound->fid; ?>' selected>
                          <?php echo $faculty->fname; ?>
                        </option>

                      <?php else: ?>
                        <option value='<?php echo $faculty->fid; ?>'>
                          <?php echo $faculty->fname; ?>
                        </option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
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