<?php
include('../includes/header.php'); ?>
<?php
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
} 


$allCourses = $conn->query("SELECT * FROM Course")->fetchAll(PDO::FETCH_OBJ);


?>
<?php
if (isset($_POST['submit'])) {
  if (empty($_POST["xlabel"]) || empty($_POST["fromhour"]) || empty($_POST["tohour"])  || empty($_POST["xdate"])) {
    echo "<script>alert('Some of the inputs are empty!');</script>";
  } else {

    $cid = $_POST["cid"];

    $xlabel = $_POST["xlabel"];
    $fromhour = $_POST["fromhour"];
    $tohour = $_POST["tohour"];
    $xdate = $_POST["xdate"];
  
    
   

    $AllExams = $conn->query("SELECT * FROM Exam")->fetchAll(PDO::FETCH_OBJ);

  
    $query = "EXEC InsertExam @xlabel = '$xlabel', @fromhour = '$fromhour', @tohour = '$tohour', @xdate = '$xdate', @cid = '$cid'";
    $result = $conn->query($query);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($rows)) {
        $message = $rows[0]['Result'];
        echo "<script>alert('$message');</script>";
        header("location: " . APPURL . "/exams/manage-exams.php");
    
    }
  }
}

?>


<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Exam </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Add Exam </li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">

              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Exam Type</label>
                  <select name="xlabel" class="form-control" required="true">
                    <option value="Final">Final Exam</option>
                    <option value="Midterm">Midterm Exam</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">From Hour</label>
                  <input type="time" name="fromhour" value="" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">To Hour</label>
                  <input type="time" name="tohour" value="" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Exam Date</label>
                  <input type="date" name="xdate" value="" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Course Name</label>
                  <select name="cid" class="form-control" required>
                    <option value='0'>
                      Please Select
                    </option>
                    <?php foreach ($allCourses as $Course): ?>
                      <option value='<?php echo $Course->cid; ?>'>
                        <?php echo $Course->cname; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
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