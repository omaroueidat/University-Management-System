<?php
include('../includes/header.php'); ?>
<?php
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
} ?>
<?php
$id = $_GET['editid'];

$bound = $conn->query("SELECT * FROM MajorCourses WHERE id = '$id'")->fetch(PDO::FETCH_OBJ);
$majors = $conn->query("SELECT * FROM Major")->fetchAll(PDO::FETCH_OBJ);
$courses = $conn->query("SELECT * FROM Course")->fetchAll(PDO::FETCH_OBJ); ?>


<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["cid"]) || empty($_POST["mid"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {
    $cid = $_POST["cid"];
    $mid = $_POST["mid"];
    $queryUpdate = $conn->prepare("UPDATE MajorCourses SET mid = :mid, cid = :cid WHERE id = '$id'");
    $queryUpdate->execute([
      ":mid" => $mid,
      ":cid" => $cid,

    ]);

    if ($queryUpdate->rowCount() > 0) {
      echo "<script>alert('Registration updated successfully!')</script>";
      header("location: " . APPURL . "/courses/registered-courses.php");
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
        <h3 class="page-title"> Edit Course Registration </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="registered-courses.php">Manage Registered Courses</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit Registration</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Major</label>
                  <select name="mid" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($majors as $major): ?>
                      <?php if ($major->mid === $bound->mid): ?>
                        <option value='<?php echo $bound->mid; ?>' selected>
                          <?php echo $major->mname; ?>
                        </option>

                      <?php else: ?>
                        <option value='<?php echo $major->mid; ?>'>
                        <?php echo $major->mname; ?>
                        </option>
                      <?php endif; ?>

                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Course</label>
                  <select name="cid" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($courses as $course): ?>
                      <?php if ($course->cid === $bound->cid): ?>
                        <option value='<?php echo $bound->cid; ?>' selected>
                          <?php echo $course->cname; ?>
                        </option>

                      <?php else: ?>
                        <option value='<?php echo $course->cid ; ?>'>
                        <?php echo $course->cname; ?>
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