<?php include_once "../includes/header.php"; ?>

<?php 

    if (!isset($_SESSION['id'])) {
      header("location: " . APPURL);
    }

    $searched = false;

    if (!$searched AND isset($_POST['submit'])){
        if (empty($_POST['xid'])){
            echo "<script>alert('Enter an Exam ID')</script>";
        }
        else{

            $xid = $_POST['xid'];
        
            $getExam = $conn->prepare("SELECT * FROM Exam WHERE xid=:xid");

            $getExam->bindParam(':xid', $xid, PDO::PARAM_INT);

            $getExam->execute();

            if($getExam->rowCount() == 0){
                echo "<script>alert('No Exam with id=$xid was found')</script>";
            } else{
                //we have to check if the exam is expired, otherwise we can't add a mark

                //fetch the exam
                $exam = $getExam->fetch(PDO::FETCH_OBJ);

                //check if the exam is expired, if it is then redirect with GET 
                if($exam->status == 'expired'){
                    header("location: ".$_SERVER['PHP_SELF']."?id=$xid");
                }

                //else alert the error
                else{
                    echo "<script>alert('Exam with id=$xid is $exam->status')</script>";
                }

            }
        }
    }

    if (isset($_GET['id'])){

        //we have to make searched true
        $searched = true;

        $xid = $_GET['id'];
        //check if the user didn't pass by the previous page, by rechecking the status of the exam
        //first we have to get the exam again from the database
        $examChosen = $conn->prepare("SELECT * 
                                      FROM Exam AS e, Course AS c
                                      WHERE xid=:xid AND e.cid = c.cid
        ");

        $examChosen->bindParam(':xid', $xid, PDO::PARAM_INT);

        $examChosen->execute();

        if($examChosen->rowCount() == 0){
            echo "<script>alert('No Exam with id=$xid was found')</script>";
            header("location: ".$_SERVER['PHP_SELF']);
            exit;
        }


        $exam = $examChosen->fetch(PDO::FETCH_OBJ);

        //now check if the exam is expired
        if($exam->status == 'expired'){

            //see if the st in StudentExamReg is 1 "marks were inserted", to insert marks it should be 0
            $checkst = $conn->query("SELECT st FROM StudentExamReg WHERE xid='$xid' ");
            $checkst = $checkst->fetch(PDO::FETCH_OBJ);
            //if statement
            if($checkst->st == '1'){
                echo "<script>alert('You Cant Add Marks To This Exam Because It Already Have Marks!')</script>";
                header("location: ".$_SERVER['PHP_SELF']);
                exit;
            }



            //we want to get all the students eligible to do an exam with there details
            $getStudents = $conn->prepare("SELECT * 
                                           FROM StudentExamReg AS ser, Student AS s
                                           WHERE ser.xid=:xid AND s.sid = ser.sid
            ");

            $getStudents->bindParam(':xid',$xid,PDO::PARAM_INT);

            $getStudents->execute();

            //fetch the eligible students
            $students = $getStudents->fetchAll(PDO::FETCH_OBJ);



            //do a loop in the frontend, to display multiple inputs depending on the number of students



            
            //we have to start getting the marks from the POST if the user posts them
            if(isset($_POST['save'])){
                //get the marks from the post as an array 
                $marks = $_POST['mark'];
                //the array is named mark and it contains as key the sid and value the mark
                //loop in the array mark and insert each value

                foreach($marks as $student => $mark){
                    $insert = $conn->prepare("INSERT INTO MarkRegister(sid, xid, mark)
                                              VALUES (:sid,:xid,:mark)
                    ");

                    $insert->execute([
                        ":sid" => $student,
                        ":xid" => $xid,
                        ":mark" => $mark
                    ]);
                }

                //update the StudentExamReg and set the st into 1 "meaning marks are inserted"
                $update = $conn->prepare("UPDATE StudentExamReg
                                          SET st='1'
                                          WHERE xid=:xid
                ");
                $update->bindParam(":xid",$xid,PDO::PARAM_INT);
                $update->execute();

                //redirect to the manage marks
                header("location: manage-marks.php");

            }
        } else{
            //if it wasn't expired
            echo "<script>alert('Exam with id=$xid is $exam->status')</script>";
            header("location: ".$_SERVER['PHP_SELF']);
            exit;
        }

    }


?>








<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Marks </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page" > Add Marks </li>
          </ol>
        </nav>
      </div>
      <div class="row">

        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample row" method="POST">

              <?php if(!$searched): ?>

                <div class="form-group col-md-6">
                  <label for="exampleInputName1">Enter Exam ID</label>
                  <input type="text" name="xid" value="" placeholder="Exam ID" class="form-control" required='true'>
                </div>

                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </div>
              </form>

            <?php else: ?>

                
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Marks for <?php echo htmlentities($exam->xlabel) ?> Exam in the Course <?php echo htmlentities($exam->cname) ?></h4>
              </div>

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

                  <?php //do a loop to add all the students 
                    foreach($students as $student):
                  ?>

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
                                <input type="text" name="mark[<?php echo $student->sid ?>]" id='' value="" class="form-control" required='true'>
                            </div>
                        </td>

                    </tr>
                

                
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary mr-2" name="save">Save</button>
                </div>
            </form>
            </div>
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






