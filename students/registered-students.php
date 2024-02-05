
<?php include_once "../includes/header.php"; ?>

<?php 

    if (!isset($_SESSION['id'])) {
      header("location: " . APPURL);
    }

    $searched = false;

    if (isset($_POST['submit'])){
        if (empty($_POST['sid'])){
            echo "<script>alert('Enter an ID')</script>";
        }
        else{

            $sid = $_POST['sid'];
        
            $getStudent = $conn->prepare("SELECT * FROM Student WHERE sid=:sid");

            $getStudent->bindParam(':sid', $sid, PDO::PARAM_INT);

            $getStudent->execute();

            if($getStudent->rowCount() == 0){
                echo "<script>alert('No Student with id=$sid was found')</script>";
            } else{
                header("location: ".$_SERVER['PHP_SELF']."?id=$sid");
            }
        }
    }

    if (isset($_GET['id'])){
        $searched = true;

        //fetch all the courses that the student's major can register in
        $getCourses = $conn->prepare("SELECT * 
                                    FROM Student AS s, StudentCourses AS sc, Course AS c
                                    WHERE s.sid = :sid AND sc.student = s.sid AND sc.course = c.cid
        ");

        $getCourses->bindParam(':sid', $_GET['id'], PDO::PARAM_INT);

        $getCourses->execute();

        $courses = $getCourses->fetchAll(PDO::FETCH_OBJ);

    }


?>








<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Registered Student </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $_SERVER['PHP_SELF'];?>"> Registered Student</a></li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1"><?php if(!$searched): echo "Enter "; endif; ?>Student ID</label>
                  <input type="text" name="sid" value="<?php if($searched): echo $_GET['id']; endif; ?>" 
                  class="form-control" required='true' <?php if($searched): echo "readonly='true'"; endif; ?>>
                </div>

                <div class="form-group col-md-12">

                    <?php if($searched): ?>
                    <?php foreach($courses as $course): ?>
                        <div class="form-group col-md-6">
                            <div class="form-check" style="margin-left: 10px;">
                                <input type="checkbox" name="course" value="<?php echo $course->cid; ?>" class="form-check-input"
                                disabled >
                                <label class="form-check-label" for="exampleCheck1"><?php echo htmlentities($course->cname); ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                
                </div>

                <?php if(!$searched): ?>
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </div>
                <?php echo "</form>"; 
                
                else: 
                    echo "</form>";?>
                    <button  class="btn btn-primary mr-2" onclick="goBack()">Go Back</button>
                <?php endif; ?>

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

<script>
    function goBack(){
        window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>";
    }
</script>