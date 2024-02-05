
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

    //grap the faculties
    $getFaculties = $conn->query("SELECT * FROM Faculty");

    $faculties = $getFaculties->fetchAll(PDO::FETCH_OBJ);

    $academicOptions = array(
      'Undergraduate',"Master's","Doctoral(Ph.D)"
    );

    $majors = null;

    $default=1;

    if(isset($_GET['fid'])){
      $fid = $_GET['fid'];
      
      $getMajors = $conn->prepare("SELECT * FROM Major WHERE fid=:fid");
      $getMajors->bindParam(':fid', $fid, PDO::PARAM_INT);
      $getMajors->execute();

      $majors = $getMajors->fetchAll(PDO::FETCH_OBJ);

      $default = 0;
    }
    else{
      die("Error!");
      header("location: ".APPURL."/dashboard.php");
    }


    $getStudent->bindParam(':id', $id, PDO::PARAM_INT);
    $getStudent->execute();

    if ($getStudent->rowCount() == 0){
      echo "<script>alert('The Student with id=$id does not exist!');</script>";
      header("location: dashboard.php");
    }

    $student = $getStudent->fetch(PDO::FETCH_OBJ);

    $editImage = false;

    if(isset($_GET['editImage'])){
      $editImage = true;
    }


    if (isset($_POST['submit'])){
      if (1
      ){


        //grap the data from the form

        $sname = $_POST['sname'];

        $birth = $_POST['bdate'];
        $bdate = date_create_from_format('Y-m-d', $_POST['bdate']);
        $bdate = $bdate->format('Y-m-d');

        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $semail = $_POST['semail'];
        $sfaculty = $_POST['sfaculty'];
        $smajor = $_POST['smajor'];
        $gender = $_POST['gender'];
        $academic = $_POST['academic'];
        $nationality = $_POST['nationality'];
        $ffname = $_POST['ffname'];
        $flname = $_POST['flname'];
        $mname = $_POST['mname'];
        $emcontact = $_POST['emcontact'];
        $emcontactnum = $_POST['emcontactnum'];
        $alt_phone = isset($_POST['alt_phone']) ? $_POST['alt_phone'] : NULL;
        $oldDir = "../assets/images/faces/" . basename($student->image);
        if ($editImage){
          $image = $image = $_FILES['image']['name'];
          $newDir = "../assets/images/faces/" . basename($image);
        } else{
          $image = $student->image;
        }



        if (strcmp($birth, date("Y-m-d")) < 0){
          $update = $conn->prepare("UPDATE Student SET
                                  sname = :sname, bdate = :bdate, address = :address, 
                                  phone = :phone, alt_phone = :alt_phone, semail = :semail,
                                  sfaculty = :sfaculty, smajor = :smajor, gender = :gender, 
                                  nationality = :nationality, academic = :academic, ffname = :ffname, 
                                  flname = :flname, mname = :mname, emcontact = :emcontact, 
                                  emcontactnum = :emcontactnum, image=:image

                                  WHERE sid = :sid
            ");


          $update->execute([
          ":sid" => $_GET['id'],
          ":sname" => $sname,
          ":bdate" => $bdate,
          ":address" => $address,
          ":phone" => $phone,
          ":alt_phone" => $alt_phone,
          ":semail" => $semail,
          ":sfaculty" => $sfaculty,
          ":smajor" => $smajor,
          ":gender" => $gender,
          ":nationality" => $nationality,
          ":academic" => $academic,
          ":ffname" => $ffname,
          ":flname" => $flname,
          ":mname" => $mname,
          ":emcontact" => $emcontact,
          ":emcontactnum" => $emcontactnum,
          ":image" => $image
          ]);

          //if the user edit an iage, we should delte the old image by the unlink() function and move the new image
          if ($editImage){
            if(unlink($oldDir)){
              if(move_uploaded_file($_FILES['image']['tmp_name'], $newDir)){
                header("location: ".APPURL."/students/manage-students.php");
              }
            }
          } else{ //do nothing
            header("location: ".APPURL."/students/manage-students.php");
          }

          

        }else{
        echo "<script>alert('Choose Correct Time!');</script>";
        }
      }else{
        echo "<script>alert('Some Inputs are Missing!');</script>";
      }
    }



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
          <h3 class="page-title"> Update Students </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Update Students</li>
            </ol>
          </nav>
        </div>
        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Update Students</h4>

                <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Student Name</label>
                        <input type="text" name="sname" value="<?php echo htmlentities($student->sname); ?>"
                          class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Student Email</label>
                        <input type="text" name="semail" value="<?php echo htmlentities($student->semail); ?>"
                          class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Student Nationality</label>
                        <input type="text" name="nationality" value="<?php echo htmlentities($student->nationality); ?>"
                          class="form-control" required='true'>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputEmail3">Student academic Info</label>
                        <select name="academic" class="form-control" required='true'>
                          <?php for($i=0;$i<3;$i++): ?>
                            <option value="undergraduate" <?php if($academicOptions[$i] == $student->academic): echo "selected"; endif; ?>>
                              <?php echo $academicOptions[$i]?></option>
                          <?php endfor; ?>
                        </select>
                    </div>

                      <div class="form-group" id="faculty">
                        <label for="exampleInputEmail3">Student Faculty</label>
                        <select name="sfaculty" class="form-control" required='true' onchange="updatePage(this.value)">
                        
                          <?php foreach($faculties as $faculty): ?>
                            <option value="<?php echo $faculty->fid ?>" <?php if($faculty->fid == $_GET['fid']): echo "selected"; endif;?>>
                            <?php echo htmlentities($faculty->fname)?></option>
                          <?php endforeach; ?>

                          </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail3">Student Major</label>
                        <select name="smajor" class="form-control" required='true'>
                          
                          <?php foreach($majors as $major): ?>
                            <option value="<?php echo $major->mid ?>" <?php if($major->mid == $student->mid): echo "selected"; endif;?>>
                              <?php echo htmlentities($major->mname)?></option>
                          <?php endforeach; ?>

                          </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Gender</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="Male" <?php if($student->gender == "Male"): echo "selected"; endif; ?>>
                            Male</option>
                          <option value="Female" <?php if($student->gender == "Female"): echo "selected"; endif; ?>>
                            Female</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date of Birth</label>
                        <input type="date" name="bdate" value="<?php echo htmlentities($student->bdate); ?>" class="form-control"
                          required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Student ID</label>
                        <input type="text" name="sid" value="<?php echo htmlentities($student->sid); ?>" class="form-control"
                          readonly='true'>
                      </div>
                    <?php if(!$editImage): ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Photo</label>
                        <img src="../assets/images/faces/<?php echo $student->image; ?>" width="100" height="100"
                          value="<?php echo $student->image; ?>" style="margin-left: 50px;"><a href="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>&editImage=<?php echo hash('sha256','hello'); ?>" style="text-decoration: none;"> &nbsp;
                          Edit Image</a>
                      </div>
                    <?php else:  ?>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Student Photo</label>
                        <input type="file" name="image" value="" class="form-control" required='true'>
                      </div>
                    <?php endif; ?>

                      <!-- Parents' Section -->

                      <h3>Parents/Guardian's details</h3>

                      <div class="form-group">
                        <label for="exampleInputName1">Father's First Name</label>
                        <input type="text" name="ffname" value="<?php echo htmlentities($student->ffname); ?>" 
                        class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Father's Last Name</label>
                        <input type="text" name="flname" value="<?php echo htmlentities($student->flname); ?>" 
                        class="form-control" required='true'>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Mother's Name</label>
                        <input type="text" name="mname" value="<?php echo htmlentities($student->mother); ?>"
                          class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="phone" value="<?php echo htmlentities($student->phone); ?>"
                          class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Alternate Contact Number</label>
                        <input type="text" name="alt_phone" value="<?php echo htmlentities($student->alt_phone); ?>"
                          class="form-control" maxlength="10" pattern="[0-9]+">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Address</label>
                        <textarea name="address" class="form-control"
                          required='true'><?php echo htmlentities($student->address); ?></textarea>
                      </div>

                      <!-- Emergency Section -->

                      <h3>Emergency Contact</h3>

                      <div class="form-group">
                        <label for="exampleInputName1">Emerency Contact Relation</label>
                        <input type="text" name="emcontact" value="<?php echo htmlentities($student->emcontact); ?>" 
                        class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Emergency Contact Number</label>
                        <input type="text" name="emcontactnum" value="<?php echo htmlentities($student->emcontactnum); ?>" 
                        class="form-control" required='true'>
                      </div>
                      
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>

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

  <script>
        function updatePage(id){
            if (id)
                window.location.href = '<?php echo $_SERVER['PHP_SELF']?>?id=' + <?php echo $student->sid ?> + '&fid=' + id + '#faculty';
        }
</script>
