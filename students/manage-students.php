
<?php include_once('../includes/header.php'); ?>

<?php

if (!isset($_SESSION['id'])) {
  header("location: " . APPURL);
} else {
  if (isset($_GET['delid'])) {
    $sid = $_GET['delid'];

    $getStudent = $conn->prepare("SELECT * FROM Student WHERE sid=:sid");

    $getStudent->bindParam(':sid', $sid, PDO::PARAM_INT);

    $getStudent->execute();

    if ($getStudent->rowCount() == 0) {
      header("location: " . $_SERVER['PHP_SELF']);
    } else {
      $deleteStudent = $conn->prepare("EXEC DeleteStudent @sid=:sid");

      $deleteStudent->bindParam(':sid', $sid, PDO::PARAM_INT);

      $deleteStudent->execute();

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
        <h3 class="page-title"> Manage Students </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Manage Students</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Manage Students</h4>
                <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> View all Students</a>
              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">S.No</th>
                      <th class="font-weight-bold">Student ID</th>
                      <th class="font-weight-bold">Faculty</th>
                      <th class="font-weight-bold">Major</th>
                      <th class="font-weight-bold">Student Name</th>
                      <th class="font-weight-bold">Student Email</th>
                      <th class="font-weight-bold">Admission Date</th>
                      <th class="font-weight-bold">Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['pageno'])) {
                      $pageno = $_GET['pageno'];
                    } else {
                      $pageno = 1;
                    }
                    // Formula for pagination
                    $no_of_records_per_page = 10;
                    $offset = ($pageno - 1) * $no_of_records_per_page;

                    //calculating the number of pages
                    $ret = "SELECT sid FROM Student";
                    $query1 = $conn->prepare($ret);
                    $query1->execute();
                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                    $total_rows = $query1->rowCount();
                    $total_pages = ceil($total_rows / $no_of_records_per_page);


                    $sql = "SELECT *
                      FROM (
                          SELECT *, ROW_NUMBER() OVER (ORDER BY sid) AS RowNum
                          FROM Student
                      ) AS Subquery
                      WHERE RowNum BETWEEN ($offset + 1) AND ($offset + $no_of_records_per_page);";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0):
                      foreach ($results as $row): ?>
                        <tr>

                          <td>
                            <?php echo htmlentities($cnt); ?>
                          </td>
                          <td>
                            <?php echo htmlentities($row->sid); ?>
                          </td>
                          <td>

                            <?php echo htmlentities($row->sfaculty); ?>
                          </td>
                          <td>
                            <?php echo htmlentities($row->smajor); ?>
                          </td>
                          <td>
                            <?php echo htmlentities($row->sname); ?>
                          </td>
                          <td>
                            <?php echo htmlentities($row->semail); ?>
                          </td>
                          <td>
                            <?php echo htmlentities($row->admission_date); ?>
                          </td>
                          <td>
                            <a href="view-student-detail.php?id=<?php echo htmlentities($row->sid); ?>"
                              class="btn btn-warning btn-sm"><i class="icon-eye"></i></a>

                            <a href="edit-student-detail.php?id=<?php echo htmlentities($row->sid); ?>&fid=<?php echo $row->sfaculty ?>"
                              class="btn btn-primary btn-sm"><i class="icon-pencil"></i></a>

                            <a href="manage-students.php?delid=<?php echo ($row->sid); ?>"
                              onclick="return confirm('Do you really want to Delete ?');" class="btn btn-danger btn-sm"> <i
                                class="icon-trash"></i></a>
                          </td>
                        </tr>
                        <?php $cnt = $cnt + 1;
                      endforeach;
                    endif; ?>
                  </tbody>
                </table>
              </div>
              <div align="left">
                <ul class="pagination">
                  <li><a href="?pageno=1"><strong>First</strong></a></li>
                  <li class="<?php if ($pageno <= 1) {
                    echo 'disabled';
                  } ?>">
                    <a href="<?php if ($pageno <= 1) {
                      echo '#';
                    } else {
                      echo "?pageno=" . ($pageno - 1);
                    } ?>"><strong style="padding-left: 10px;">&lt;</strong></a>
                  </li>
                  <li class="<?php if ($pageno >= $total_pages) {
                    echo 'disabled';
                  } ?>">
                    <a href="<?php if ($pageno >= $total_pages) {
                      echo '#';
                    } else {
                      echo "?pageno=" . ($pageno + 1);
                    } ?>"><strong style="padding-left: 10px">></strong></a>
                  </li>
                  <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends --><!--  Orginal Author Name: Mayuri.K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mdkhairnar92@gmail.com  
 Visit website : https://mayurik.com -->
    <!-- partial:partials/_footer.html -->
    <?php include_once('../includes/footer.php'); ?>
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->