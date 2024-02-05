<?php
include('../includes/header.php'); ?>
<?php
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
} ?>
<?php
$id = $_GET["editid"];
$departments = $conn->query("SELECT * FROM Department")->fetchAll(PDO::FETCH_OBJ);
$teacher = $conn->query("SELECT * FROM Teacher WHERE tid = '$id'")->fetch(PDO::FETCH_OBJ);
?>
<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["tname"]) || empty($_POST["address"]) || empty($_POST["phone"]) || empty($_POST["speciality"]) || empty($_POST["did"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {
    $tname = $_POST["tname"];
    $phone = $_POST["phone"];
    $speciality = $_POST["speciality"];
    $address = $_POST["address"];
    $did = $_POST["did"];

    $query2 = $conn->prepare("UPDATE Teacher SET tname = :tname, address = :address, phone = :phone, speciality = :speciality, did = :did WHERE tid = '$id'");
    $query2->execute([
      ":tname" => $tname,
      ":address" => $address,
      ":phone" => $phone,
      ":speciality" => $speciality,
      ":did" => $did,
    ]);

    if ($query2->rowCount() > 0) {
      echo "<script>alert('Teacher updated successfully!')</script>";
      header("location: " . APPURL . "/teachers/manage-teachers.php");
    } else {
      echo "<script>alert('Failed to update the teacher!')</script>";
    }

    
    


  }
}

?>


<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Edit Teacher </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="manage-teachers.php">Manage Teachers</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit Teacher</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">


              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Name</label>
                  <input type="text" name="tname" value="<?= $teacher->tname; ?>" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Address</label>
                  <input type="text" name="address" value="<?= $teacher->address; ?>" class="form-control"
                    required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail3">Phone Number</label>
                  <input type="text" name="phone" value="<?= $teacher->phone; ?>" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Speciality</label>
                  <input type="text" name="speciality" value="<?= $teacher->speciality; ?>" class="form-control"
                    required='true'>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Department</label>
                  <select name="did" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($departments as $department): ?>
                      <?php if ($department->did === $teacher->did): ?>
                        <option value='<?php echo $teacher->did; ?>' selected>
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