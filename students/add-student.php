<script>
  function clearFormData() {
    localStorage.removeItem('sname');
    localStorage.removeItem('bdate');
    localStorage.removeItem('address');
    localStorage.removeItem('phone');
    localStorage.removeItem('semail');
    localStorage.removeItem('sfaculty');
    localStorage.removeItem('smajor');
    localStorage.removeItem('gender');
    localStorage.removeItem('academic');
    localStorage.removeItem('nationality');
    localStorage.removeItem('ffname');
    localStorage.removeItem('flname');
    localStorage.removeItem('mname');
    localStorage.removeItem('emcontact');
    localStorage.removeItem('alt_phone');

  }
</script>


<?php include_once('../includes/header.php'); ?>
<?php include_once('../includes/dbconnection.php'); ?>
<?php



if (!isset($_SESSION['id'])) {
  header("location: " . APPURL);
}


//grap the faculties
$getFaculties = $conn->query("SELECT * FROM Faculty");

$faculties = $getFaculties->fetchAll(PDO::FETCH_OBJ);

$majors = null;

$default = 1;

if (isset($_GET['id'])) {
  $fid = $_GET['id'];

  $getMajors = $conn->prepare("SELECT * FROM Major WHERE fid=:fid");
  $getMajors->bindParam(':fid', $fid, PDO::PARAM_INT);
  $getMajors->execute();

  $majors = $getMajors->fetchAll(PDO::FETCH_OBJ);

  $default = 0;
}



if (isset($_POST['submit'])) {

  //condition if one of the inputs is missing

  if (
    empty($_POST['sname']) or empty($_POST['bdate']) or empty($_POST['address']) or empty($_POST['phone'])
    or empty($_POST['semail']) or $_POST['sfaculty'] == "" or $_POST['smajor'] == "" or $_POST['gender'] == ""
    or $_POST['academic'] == "" or empty($_FILES['image']) or empty($_POST['nationality']) or empty($_POST['ffname'])
    or empty($_POST['flname']) or empty($_POST['mname']) or empty($_POST['emcontact']) or empty($_POST['emcontactnum'])
  ) {
    echo "<script>alert('Some inputs are missing!')</script>";
  } else {
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
    $image = $_FILES['image']['name'];
    $nationality = $_POST['nationality'];
    $ffname = $_POST['ffname'];
    $flname = $_POST['flname'];
    $mname = $_POST['mname'];
    $emcontact = $_POST['emcontact'];
    $emcontactnum = $_POST['emcontactnum'];
    $alt_phone = isset($_POST['alt_phone']) ? $_POST['alt_phone'] : NULL;
    $admission_date = date('Y-m-d H:i:s');

    //path to move the images
    $dir = "../assets/images/faces/" . basename($image);

    //check if the date is not in the future
    if (strcmp($birth, date("Y-m-d")) < 0) {


      //start inserting into the database


      $insert = $conn->prepare("INSERT INTO Student (sname, bdate, address, phone, alt_phone, semail,
                                  sfaculty, smajor, gender, image, nationality, academic, ffname, flname,
                                  mname, emcontact, emcontactnum, admission_date)

                                  VALUES (:sname, :bdate, :address, :phone, :alt_phone, :semail, :sfaculty, 
                                  :smajor, :gender, :image, :nationality, :academic, :ffname, :flname, 
                                  :mname, :emcontact, :emcontactnum, :admission_date)
        ");

      $insert->execute([
        ":sname" => $sname,
        ":bdate" => $bdate,
        ":address" => $address,
        ":phone" => $phone,
        ":alt_phone" => $alt_phone,
        ":semail" => $semail,
        ":sfaculty" => $sfaculty,
        ":smajor" => $smajor,
        ":gender" => $gender,
        ":image" => $image,
        ":nationality" => $nationality,
        ":academic" => $academic,
        ":ffname" => $ffname,
        ":flname" => $flname,
        ":mname" => $mname,
        ":emcontact" => $emcontact,
        ":emcontactnum" => $emcontactnum,
        ":admission_date" => $admission_date
      ]);



      if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
        echo "<script>clearFormData(); window.location.href = '".APPURL."/dashboard.php';</script>";
        exit;
      }

    } else {
      echo "<script>alert('Choose Correct Time!');</script>";
    }
  }
}



?>


<!-- partial -->
<div class="container-fluid page-body-wrapper mt-5">
  <!-- partial:partials/_sidebar.html -->
  <?php include_once('../includes/sidebar.php'); ?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Students </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Add Students</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">


              <form class="forms-sample row" method="post" enctype="multipart/form-data" onsubmit="">
                <!-- 
                    Section title
                  -->

                <h3 class="col-md-12">Parents/Guardian's details</h3>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Father's First Name</label>
                  <input type="text" name="ffname" id='ffname' value="" class="form-control" required='true'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Father's Last Name</label>
                  <input type="text" name="flname" value="" class="form-control" required='true' id='flname'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Mother's Full Name</label>
                  <input type="text" name="mname" id="mname" value="" class="form-control" required='true'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Contact Number</label>
                  <input type="text" name="phone" value="" class="form-control" required='true' maxlength="10"
                    pattern="[0-9]+" id='phone' oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Alternate Contact Number(opt)</label>
                  <input type="text" name="alt_phone" value="" class="form-control" maxlength="10" pattern="[0-9]+"
                    id='alt_phone' oninput="storeFormData()">
                </div>

                <!-- 
                    Section title
                  -->

                <h3 class="col-md-12">Student's Details</h3>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Student Name</label>
                  <input type="text" name="sname" id='sname' value="" class="form-control" id='sname' required='true'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Student Email</label>
                  <input type="text" name="semail" id='semail' value="" class="form-control" required='true'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Student Nationality</label>
                  <input type="text" name="nationality" id='nationality' value="" class="form-control" required='true'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputEmail3">Student academic Info</label>
                  <select name="academic" id='academic' class="form-control" required='true' oninput="storeFormData()">
                    <option value="">Select academic Info</option>
                    <option value="undergraduate">Undergraduate</option>
                    <option value="master">Master's</option>
                    <option value="docotral">Doctoral(Ph.D)</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputEmail3">Student Faculty</label>
                  <select name="sfaculty" id='sfaculty' class="form-control" required='true'
                    onchange="updatePage(this.value)" oninput="storeFormData()">
                    <option value="" <?php if ($default):
                      echo "selected";
                    endif; ?>>Select Faculty</option>
                    <?php foreach ($faculties as $faculty): ?>
                      <option value="<?php echo $faculty->fid; ?>" <?php if (!$default):
                           if ($faculty->fid == $_GET['id']):
                             echo "selected";
                           endif;
                         endif; ?>>
                        <?php echo $faculty->fname ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputEmail3">Student Major</label>
                  <select name="smajor" id='smajor' class="form-control" required='true' oninput="storeFormData()">
                    <option value="">Select Major</option>
                    <?php foreach ($majors as $major): ?>
                      <option value="<?php echo $major->mid ?>">
                        <?php echo $major->mname ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Gender</label>
                  <select name="gender" id='gender' value="" class="form-control" required='true'
                    oninput="storeFormData()">
                    <option value="" selected>Choose Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Date of Birth</label>
                  <input type="date" name="bdate" id='bdate' value="" class="form-control" required='true'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Student Photo</label>
                  <input type="file" name="image" value="" class="form-control" required='true'>
                </div>

                

                <div class="form-group col-md-12">
                  <label for="exampleInputName1">Address</label>
                  <textarea name="address" id='address' class="form-control" oninput="storeFormData()"></textarea>
                </div>

                <!-- 
                    Section title
                  -->

                <h3 class="col-md-12">Emergency Contact</h3>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Emerency Contact Relation</label>
                  <input type="text" name="emcontact" id='emcontact' value="" class="form-control" required='true'
                    oninput="storeFormData()">
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Emergency Contact Number</label>
                  <input type="text" name="emcontactnum" id='emcontactnum' value="" class="form-control" required='true'
                    pattern="[0-9]+" oninput="storeFormData()">
                </div>


                <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>

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
  function updatePage(id) {
    if (id)
      window.location.href = '<?php echo $_SERVER['PHP_SELF'] ?>?id=' + id + '#mname';
  }
</script>


<script>
  // Function to store form data in local storage
  function storeFormData() {
    localStorage.setItem('sname', document.getElementById('sname').value);
    localStorage.setItem('bdate', document.getElementById('bdate').value);
    localStorage.setItem('address', document.getElementById('address').value);
    localStorage.setItem('phone', document.getElementById('phone').value);
    localStorage.setItem('semail', document.getElementById('semail').value);
    localStorage.setItem('sfaculty', document.getElementById('sfaculty').value);
    localStorage.setItem('smajor', document.getElementById('smajor').value);
    localStorage.setItem('gender', document.getElementById('gender').value);
    localStorage.setItem('academic', document.getElementById('academic').value);
    localStorage.setItem('nationality', document.getElementById('nationality').value);
    localStorage.setItem('ffname', document.getElementById('ffname').value);
    localStorage.setItem('flname', document.getElementById('flname').value);
    localStorage.setItem('mname', document.getElementById('mname').value);
    localStorage.setItem('emcontact', document.getElementById('emcontact').value);
    localStorage.setItem('alt_phone', document.getElementById('alt_phone').value);

  }

  // Function to retrieve form data from local storage
  function retrieveFormData() {
    document.getElementById('sname').value = localStorage.getItem('sname') || '';
    document.getElementById('bdate').value = localStorage.getItem('bdate') || '';
    document.getElementById('address').value = localStorage.getItem('address') || '';
    document.getElementById('phone').value = localStorage.getItem('phone') || '';
    document.getElementById('semail').value = localStorage.getItem('semail') || '';
    document.getElementById('sfaculty').value = localStorage.getItem('sfaculty') || '';
    document.getElementById('smajor').value = localStorage.getItem('smajor') || '';
    document.getElementById('gender').value = localStorage.getItem('gender') || '';
    document.getElementById('academic').value = localStorage.getItem('academic') || '';
    document.getElementById('nationality').value = localStorage.getItem('nationality') || '';
    document.getElementById('ffname').value = localStorage.getItem('ffname') || '';
    document.getElementById('flname').value = localStorage.getItem('flname') || '';
    document.getElementById('mname').value = localStorage.getItem('mname') || '';
    document.getElementById('emcontact').value = localStorage.getItem('emcontact') || '';
    document.getElementById('alt_phone').value = localStorage.getItem('alt_phone') || '';
  }



  // Call retrieveFormData() when the page loads to pre-fill the form
  window.onload = retrieveFormData;
</script>