<?php
include('../includes/header.php');
include('../includes/dbconnection.php');



if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

$Allteachers = $conn->query("SELECT * FROM Teacher")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["teacherid"]) || empty($_POST["ccode"]) || empty($_POST["cname"]) || empty($_POST["hours"]) || empty($_POST["credits"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {

    $teacherId = $_POST["teacherid"];

    $ccode = $_POST["ccode"];
    $cname = $_POST["cname"];
    $hours = $_POST["hours"];
    $credits = $_POST["credits"];

    $query2 = $conn->prepare("INSERT INTO Course (teacher, ccode, cname, hours, credits) VALUES (:teacher, :ccode, :cname, :hours, :credits)");
    $query2->execute([
      ":teacher" => $teacherId,
      ":ccode" => $ccode,
      ":cname" => $cname,
      ":hours" => $hours,
      ":credits" => $credits,
    ]);

    if ($query2->rowCount() > 0) {
      echo "<script>alert('Course added successfully!')</script>";
      header("location: " . APPURL . "/courses/manage-courses.php");

    } else {
      echo "<script>alert('Failed to add the course!');</script>";
    }

  }
}

?>


<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Course </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Add Course</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">


              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Course Code</label>
                  <input type="text" name="ccode" value="" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Course Name</label>
                  <input type="text" name="cname" value="" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail3">Course Hours</label>
                  <input type="text" name="hours" value="" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Course Credits</label>
                  <input type="text" name="credits" value="" class="form-control" required='true'>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Teacher Name</label>
                  <select name="teacherid" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($Allteachers as $teacher): ?>
                      <option value='<?php echo $teacher->tid; ?>'>
                        <?php echo $teacher->tname; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                </div>
              </form>
              <?php include_once('../includes/footerText.php'); ?>
            </div>

          </div>

        </div>
      </div>
    </div>

    <?php include_once('../includes/footer.php'); ?>

  </div>
</div>
</div>