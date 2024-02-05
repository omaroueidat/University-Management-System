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

            //see if the st in StudentExamReg is 1 "marks were inserted", to view it should be 1
            $checkst = $conn->query("SELECT st FROM StudentExamReg WHERE xid='$xid' ");
            $checkst = $checkst->fetch(PDO::FETCH_OBJ);
            //if statement
            if($checkst->st == '0'){
                echo "<script>confrim('You Cant View Marks Since Marks Are Not Added Yet!');
                              window.location.href = 'add-mark.php';
                </script>";
                exit;
            }



            //we want to get the students and their marks and details from MarkRegister
            $getStudents = $conn->prepare("SELECT * 
                                           FROM MarkRegister AS mr, Student AS s
                                           WHERE mr.xid=:xid AND s.sid = mr.sid
            ");

            $getStudents->bindParam(':xid',$xid,PDO::PARAM_INT);

            $getStudents->execute();

            //fetch the students
            $students = $getStudents->fetchAll(PDO::FETCH_OBJ);



            //do a loop in the frontend and diplay the marks

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
        <h3 class="page-title"> View Marks </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page" > View Marks </li>
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
              <h4 class="card-title mb-sm-0">Viewing Marks for <?php echo htmlentities($exam->xlabel) ?> Exam in the Course <?php echo htmlentities($exam->cname) ?></h4>
              </div>

                <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">Student ID</th>
                      <th class="font-weight-bold">Student Name</th>
                      
                      <th class="font-weight-bold">Mark</th>
                      <th class="font-weight-bold">Action</th>

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
                            <?php echo htmlentities($student->mark); ?>
                        </td>

                        <td>
                          <a href="edit-mark.php?xid=<?php echo $exam->xid; ?>&sid=<?php echo $student->sid; ?>" class="btn btn-primary btn-sm"><i
                              class="icon-pencil"></i></a>
                        </td>

                    </tr>
                

                
                    <?php endforeach; ?>
                    </tbody>
                </table>
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