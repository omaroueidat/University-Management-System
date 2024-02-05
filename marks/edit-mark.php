<?php include_once "../includes/header.php"; ?>

<?php 

    if (!isset($_SESSION['id'])) {
      header("location: " . APPURL);
    }

    
    if (isset($_GET['xid']) AND isset($_GET['sid'])){

        //get the values of xid and sid
        $xid = $_GET['xid'];
        $sid = $_GET['sid'];


        //select from the MarkRegister Table the values of xid and sid to be viewed
        $getStudent = $conn->prepare("SELECT *
                                      FROM MarkRegister AS mc, Student AS s
                                      WHERE mc.xid = :xid AND mc.sid=:sid AND s.sid=mc.sid
        ");
        $getStudent->execute([
            ":xid" => $xid,
            ":sid" => $sid
        ]);

        if($getStudent->rowCount() == 0){
            echo "<script>
                    confrim('No Mark Was Found!');
                    window.location.href='manage-marks.php';
                </script>";
            exit;
        }

        //fetch the student
        $student = $getStudent->fetch(PDO::FETCH_OBJ);


        //put the values in the frontend


        //if user posts update
        if(isset($_POST['update'])){
            //get the mark inputed
            $mark = $_POST['mark'];

            //check condition for mark
            if($mark<0 OR $mark>100){
                echo "<script>alert('Enter Mark Between 0 and 100')</script>";
            } else{
                
                //update query set mark = mark
                $update = $conn->prepare("UPDATE MarkRegister
                                          SET mark=:mark
                                          WHERE sid=:sid AND xid=:xid
                ");

                $update->execute([
                    ":sid" => $sid,
                    ":xid" => $xid,
                    ":mark" => $mark
                ]);
    
                //redirect the user to the view marks with the xid=current xid
                header("location: manage-marks.php?id=$xid");

            }
        }
    }
?>








<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Edit Mark </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page" > Edit Mark </li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample row" method="POST">

                

                <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">Student ID</th>
                      <th class="font-weight-bold">Student Name</th>
                      
                      <th class="font-weight-bold">Mark</th>

                    </tr>
                  </thead>
                  <tbody>

                    <tr>

                        <td>
                            <?php echo htmlentities($student->sid); ?>
                        </td>

                        <td>
                            <?php echo htmlentities($student->sname); ?>
                        </td>

                        <td>
                            <div class="form-group col-md-6">
                                <label for="exampleInputName1">Mark</label>
                                <input type="text" name="mark" id='' value="<?php echo htmlentities($student->mark); ?>" class="form-control" required='true'>
                            </div>
                        </td>

                    </tr>
                

                    </tbody>
                </table>
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="update">Update</button>
                </div>
            </form>
            </div>





                


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