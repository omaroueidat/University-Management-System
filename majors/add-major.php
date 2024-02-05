<?php
include "../includes/header.php";



if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}


?>

<?php

    $getFaculties = $conn->query("SELECT * FROM Faculty");

    $faculties = $getFaculties->fetchAll(PDO::FETCH_OBJ);

    if (isset($_POST['submit'])) {
        if (empty($_POST['mname']) OR $_POST['faculty']=='' OR empty($_POST['req_sems'])){
            echo "<script>alert('Some of the inputs are empty!');</script>";
        }
        else{

            //get the inputs from the user

            $mname = $_POST['mname'];
            $req_sems = $_POST['req_sems'];
            $fid = $_POST['faculty'];


            //prepare the insert sql
            $insert = $conn->prepare("INSERT INTO Major(mname, req_sems, fid) VALUES 
                                    (:mname, :req_sems, :fid);
            ");

            //execute the sql statment
            $insert->execute([
                ":mname" => $mname,
                ":req_sems" => $req_sems,
                ":fid" => $fid
            ]);

            header("location: ".APPURL."/majors/manage-majors.php");
        }
    }


?>





<div class="container-fluid page-body-wrapper">

  <?php include "../includes/sidebar.php"; ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Major </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL ?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Add Major</li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">


              <form class="forms-sample row" method="POST">

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Major Name</label>
                  <input type="text" name="mname" value="" class="form-control" required='true'>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Required Semesters</label>
                  <input type="text" name="req_sems" value="" class="form-control" required='true'>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Faculty</label>
                  <select name="faculty" class="form-control" required onchange="">
                    <option value=''>
                      Select Faculty
                    </option>
                    <?php foreach ($faculties as $faculty): ?>
                      <option value='<?php echo $faculty->fid; ?>'>
                        <?php echo $faculty->fname; ?>
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