<?php



include('includes/header.php');

if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

?>

<?php
$query1 = $conn->query("SELECT * from  Admin");
$results1 = $query1->fetchAll(PDO::FETCH_OBJ);
$totalAdmins = $query1->rowCount();


$query2 = $conn->query("SELECT * from  Course");
$results2 = $query2->fetchAll(PDO::FETCH_OBJ);
$totalCourses = $query2->rowCount();

$query3 = $conn->query("SELECT * from  Teacher");
$results3 = $query3->fetchAll(PDO::FETCH_OBJ);
$totalTeachers = $query3->rowCount();

$query4 = $conn->query("SELECT * from  Exam");
$results4 = $query4->fetchAll(PDO::FETCH_OBJ);
$totalExams = $query4->rowCount();


$query5 = $conn->query("SELECT * from  Student");
$results5 = $query5->fetchAll(PDO::FETCH_OBJ);
$totalStudents = $query5->rowCount();

$query6 = $conn->query("SELECT * from  MarkRegister");
$results6 = $query6->fetchAll(PDO::FETCH_OBJ);
$totalRegisteredMarks = $query6->rowCount();

$query7 = $conn->query("SELECT * from  Major");
$results7 = $query7->fetchAll(PDO::FETCH_OBJ);
$totalMajors = $query7->rowCount();

$query8 = $conn->query("SELECT * from  Faculty");
$results8 = $query8->fetchAll(PDO::FETCH_OBJ);
$totalFaculties = $query8->rowCount();

$query9 = $conn->query("SELECT * from  Department");
$results9 = $query9->fetchAll(PDO::FETCH_OBJ);
$totalDepartments = $query9->rowCount();


?>
<div class="container-fluid page-body-wrapper">

  <?php include_once('includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="d-sm-flex align-items-baseline report-summary-header">
                    <h5 class="font-weight-semibold">Report Summary</h5>

                  </div>
                </div>
              </div>
              <div class="row ">

                <div class="col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-4">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Teachers</span>
                      <h4>
                        <?php echo $totalTeachers; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/teachers/manage-teachers.php"><span class="report-count"> View Teachers</span></a>
                    </div>
                    <div class="inner-card-icon">
                      <i class="icon-user"></i>
                    </div>
                  </div>
                </div>




                <div class="col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-4">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Exams</span>
                      <h4>
                        <?php echo $totalExams; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/exams/manage-exams.php"><span class="report-count"> View Exams</span></a>
                    </div>
                    <div class="inner-card-icon">
                      <i class="icon-doc"></i>
                    </div>
                  </div>
                </div>

                <div class=" col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-1">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Students</span>
                      <h4>
                        <?php echo $totalStudents; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/students/manage-students.php"><span class="report-count"> View Students</span></a>
                    </div>
                    <div class="inner-card-icon ">
                      <i class="icon-user"></i>
                    </div>
                  </div>
                </div>

                <div class=" col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-1">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Marks</span>
                      <h4>
                        <?php echo $totalRegisteredMarks; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/marks/manage-marks.php"><span class="report-count"> View Marks</span></a>
                    </div>
                    <div class="inner-card-icon ">
                      <i class="icon-doc"></i>
                    </div>
                  </div>
                </div>

                

                <div class="col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-3">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Admins</span>
                      <h4>
                        <?php echo $totalAdmins; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/admins/manage-admins.php"><span class="report-count"> View Admins</span></a>
                    </div>
                    <div class="inner-card-icon ">
                      <i class="icon-user"></i>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-3">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Courses</span>
                      <h4>
                        <?php echo $totalCourses; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/courses/manage-courses.php"><span class="report-count"> View Courses</span></a>
                    </div>
                    <div class="inner-card-icon ">
                      <i class="icon-layers"></i>
                    </div>
                  </div>
                </div>






                



                <div class="col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-4">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Majors</span>
                      <h4>
                        <?php echo $totalMajors; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/majors/manage-majors.php"><span class="report-count"> View Majors</span></a>
                    </div>
                    <div class="inner-card-icon">
                      <i class="icon-layers"></i>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-4">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Faculties</span>
                      <h4>
                        <?php echo $totalFaculties; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/faculties/manage-faculties.php"><span class="report-count"> View Faculties</span></a>
                    </div>
                    <div class="inner-card-icon">
                      <i class="icon-home"></i>
                    </div>
                  </div>
                </div>

                <div class=" col-md-6 report-inner-cards-wrapper">
                  <div class="report-inner-card color-1">
                    <div class="inner-card-text text-white">

                      <span class="report-title">Total Departments</span>
                      <h4>
                        <?php echo $totalDepartments; ?>
                      </h4>
                      <a href="<?php echo APPURL; ?>/departments/manage-departments.php"><span class="report-count"> View Departments</span></a>
                    </div>
                    <div class="inner-card-icon ">
                      <i class="icon-home"></i>
                    </div>
                  </div>
                </div>

              </div>

            </div>
            <?php include_once('includes/footerText.php'); ?>
          </div>
        </div>
      </div>

      <?php include_once('includes/footer.php'); ?>
    </div>
  </div>
</div>
</div>