<?php include_once('../includes/header.php'); ?>

<?php

    if (!isset($_SESSION['id'])) {
      header("location: " . APPURL);
    }

  if (!isset($_GET['id'])){
    header("location: ".APPURL."/dashboard.php");
  }
  else{
    $id = $_GET['id'];
    $getStudent = $conn->prepare("SELECT *,s.mname AS mother 
                                  FROM Student as s, Faculty as f, Major as m
                                  WHERE s.sfaculty = f.fid AND s.smajor = m.mid AND sid=:id
    ");


    $getStudent->bindParam(':id', $id, PDO::PARAM_INT);
    $getStudent->execute();

    if ($getStudent->rowCount() == 0){
      echo "<script>alert('The Student with id=$id does not exist!');</script>";
      header("location: ".APPURL."/dashboard.php");
    }

    $student = $getStudent->fetch(PDO::FETCH_OBJ);

    //we need to get the number of courses and credits the student can obtain

    $getCoursesInfo = $conn->prepare("SELECT COUNT(c.cid) AS courseNum, SUM(credits) AS totalCred
                                   FROM Student AS s, MajorCourses AS mc, Course AS c
                                   WHERE s.sid=:id AND s.smajor = mc.mid AND mc.cid = c.cid
    ");

    $getCoursesInfo->bindParam(':id',$id, PDO::PARAM_INT);
    $getCoursesInfo->execute();

    $coursesInfo = $getCoursesInfo->fetch(PDO::FETCH_OBJ);
    

    



  }



  ?>


  
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('../includes/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> View Student <strong style="text-decoration:underline;"><?php echo $student->sname ?></strong> </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
            </ol>
          </nav>
        </div>
        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">View Details</h4>

                <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Student Name</label>
                        <input type="text" name="sname" value="<?php echo htmlentities($student->sname); ?>"
                          class="form-control" required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Student Email</label>
                        <input type="text" name="semail" value="<?php echo htmlentities($student->semail); ?>"
                          class="form-control" required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Student Nationality</label>
                        <input type="text" name="nationality" value="<?php echo htmlentities($student->nationality); ?>"
                          class="form-control" required='true' readonly='true'>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputEmail3">Student academic Info</label>
                        <input type="text" name="nationality" value="<?php echo htmlentities($student->academic); ?>"
                          class="form-control" required='true' readonly='true'>
                    </div>

                      <div class="form-group" id="faculty">
                        <label for="exampleInputEmail3">Student Faculty</label>
                        <input type="text" name="nationality" value="<?php echo htmlentities($student->fname); ?>"
                          class="form-control" required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail3">Student Major</label>
                        <input type="text" name="nationality" value="<?php echo htmlentities($student->mname); ?>"
                          class="form-control" required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Gender</label>
                        <input type="text" name="nationality" value="<?php echo htmlentities($student->gender); ?>"
                          class="form-control" required='true' readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date of Birth</label>
                        <input type="date" name="bdate" value="<?php echo htmlentities($student->bdate); ?>" class="form-control"
                          required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Student ID</label>
                        <input type="text" name="sid" value="<?php echo htmlentities($student->sid); ?>" class="form-control"
                          readonly='true' readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Photo</label>
                        <img src="../assets/images/faces/<?php echo $student->image; ?>" width="100" height="100"
                          value="<?php echo $student->image; ?>" style="margin-left: 50px;">
                      </div>
                      

                      <!-- Student's Academic Details -->

                      <div class="form-group">
                        <label for="exampleInputName1">Obtained Courses</label>
                        <input type="text" name="sid" value="<?php echo htmlentities($student->ObtainedCourses) . ' / ' . htmlentities($coursesInfo->courseNum); ?>" class="form-control"
                          readonly='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Obtained Credits</label>
                        <input type="text" name="sid" value="<?php echo htmlentities($student->ObtainedCredits) . ' / ' . htmlentities($coursesInfo->totalCred); ?>" class="form-control"
                          readonly='true' readonly='true'>
                      </div>

                      <!-- Parents' Section -->

                      <h3>Parents/Guardian's details</h3>

                      <div class="form-group">
                        <label for="exampleInputName1">Father's First Name</label>
                        <input type="text" name="ffname" value="<?php echo htmlentities($student->ffname); ?>" 
                        class="form-control" required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Father's Last Name</label>
                        <input type="text" name="flname" value="<?php echo htmlentities($student->flname); ?>" 
                        class="form-control" required='true' readonly='true'>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Mother's Name</label>
                        <input type="text" name="mname" value="<?php echo htmlentities($student->mother); ?>"
                          class="form-control" required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="phone" value="<?php echo htmlentities($student->phone); ?>"
                          class="form-control" required='true' maxlength="10" pattern="[0-9]+" readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Alternate Contact Number</label>
                        <input type="text" name="alt_phone" value="<?php echo htmlentities($student->alt_phone); ?>"
                          class="form-control" maxlength="10" pattern="[0-9]+" readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Address</label>
                        <input type='text' name="address" class="form-control" value="<?php echo htmlentities($student->address); ?>"
                          required='true' readonly='true'>
                      </div>

                      <!-- Emergency Section -->

                      <h3>Emergency Contact</h3>

                      <div class="form-group">
                        <label for="exampleInputName1">Emerency Contact Relation</label>
                        <input type="text" name="emcontact" value="<?php echo htmlentities($student->emcontact); ?>" 
                        class="form-control" required='true' readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Emergency Contact Number</label>
                        <input type="text" name="emcontactnum" value="<?php echo htmlentities($student->emcontactnum); ?>" 
                        class="form-control" required='true'readonly='true'>
                      </div>
                      

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
      <?php include_once('../includes/footer.php'); ?>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
