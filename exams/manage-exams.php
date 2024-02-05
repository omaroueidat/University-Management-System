<?php
include('../includes/header.php');
include('../includes/dbconnection.php');

if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

$exams = $conn->query("SELECT * FROM Exam, Course WHERE Exam.cid = Course.cid")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if ($_SESSION["error"]) {
  echo "<script>alert('From hour should be less than To hour')</script>";
  unset($_SESSION["error"]);
}
// Delete Exam
if (isset($_GET["delid"])) {
  $id = $_GET["delid"];
  $examQ = $conn->query("SELECT * FROM Exam WHERE Exam.xid = '$id'")->fetch(PDO::FETCH_OBJ);
  if ($examQ->status == "active" || $examQ->status == "expired") {
    header("location: " . APPURL . "/exams/manage-exams.php");
  } else {
    $conn->query("DELETE FROM Exam WHERE xid = '$id'");
    header("location: " . APPURL . "/exams/manage-exams.php");
  }




}



?>



<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Manage Exams </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Manage Exams</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Exams List</h4>

              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">ID</th>
                      <th class="font-weight-bold">Course</th>
                      <th class="font-weight-bold">Label</th>
                      <th class="font-weight-bold">From Hour</th>
                      <th class="font-weight-bold">To Hour</th>
                      <th class="font-weight-bold">Date</th>
                      <th class="font-weight-bold">Status</th>
                      <th class="font-weight-bold">OPS</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($exams as $exam): ?>
                      <tr>

                        <td>
                          <?php echo $exam->xid; ?>
                        </td>
                        <td>
                          <?php echo $exam->cname; ?>
                        </td>
                        <td>
                          <?php echo $exam->xlabel; ?>
                        </td>
                        <td>
                          <?php echo $exam->fromhour; ?>
                        </td>
                        <td>
                          <?php echo $exam->tohour; ?>
                        </td>
                        <td>
                          <?php echo $exam->xdate; ?>
                        </td>
                        <td>
                          <?php echo $exam->status; ?>
                        </td>
                        <td>
                          <?php if ($exam->status == "active" || $exam->status == "expired")
                          : ?>
                            N/A
                          <?php else: ?>
                            <a href="edit-exam.php?xid=<?php echo $exam->xid; ?>" class="btn btn-primary btn-sm"><i
                                class="icon-pencil"></i></a>
                            <a href="manage-exams.php?delid=<?php echo $exam->xid; ?>"
                              onclick="return confirm('Do you really want to delete this label ?');"
                              class="btn btn-danger btn-sm"> <i class="icon-trash"></i></a>
                          <?php endif; ?>

                        </td>

                      </tr>
                    <?php endforeach; ?>

                  </tbody>
                </table>
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