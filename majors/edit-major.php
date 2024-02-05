<?php include('../includes/header.php'); ?>


<?php
    if (!isset($_SESSION["id"])) {
        header("location: " . APPURL . "/");
    } 

    //get all the faculties to put them in the select
    $getFaculties = $conn->query("SELECT * FROM Faculty");

    $faculties = $getFaculties->fetchAll(PDO::FETCH_OBJ);

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        //get the major from the database according to the given data
        $getMajor = $conn->prepare("SELECT * 
                                    FROM Major AS m, Faculty as f
                                    WHERE m.mid=:id AND m.fid=f.fid
        ");
        $getMajor->bindParam(':id', $id, PDO::PARAM_INT);
        $getMajor->execute();

        //fetch the result from the database
        $major = $getMajor->fetch(PDO::FETCH_OBJ);

    }
    
  
    if (isset($_POST['submit'])) {
        if (0) {
            echo "<script>alert('Some of the inputs are empty!');</script>";
        } else {
            //update the major
            //get the inputs
            $mname = $_POST['mname'];
            $req_sems = $_POST['req_sems'];
            $fid = $_POST['fid'];
            
            $update = $conn->prepare("UPDATE Major
                                      SET mname=:mname, req_sems=:req_sems, fid=:fid
                                      WHERE mid=:id
            
            ");

            $update->execute([
                ":mname" => $mname,
                ":req_sems" => $req_sems,
                ":fid" => $fid,
                ":id" => $id
            ]);

        if ($update->rowCount() > 0) {
            echo "<script>alert('Major updated successfully!')</script>";
            header("location: " . APPURL . "/Majors/manage-majors.php");
        } else {
            echo "<script>alert('Failed to update the Major!')</script>";
        }
    }



    }

?>


<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Edit Department </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL ?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo APPURL ?>/manage-majors.php">Manage Majors</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit Major</li>
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
                  <input type="text" name="mname" value="<?php echo htmlentities($major->mname); ?>" class="form-control" required='true'>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1"> Required Semesters</label>
                  <input type="text" name="req_sems" value="<?= $major->req_sems ?>" class="form-control" required='true'>
                </div>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Faculty</label>
                  <select name="fid" class="form-control" required>
                    <?php foreach ($faculties as $faculty): ?>
                      <option value='<?php echo $faculty->fid; ?>' <?php if($faculty->fid == $major->fid): echo "selected"; endif; ?>>
                        <?php echo $faculty->fname; ?>
                      </option>
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