<?php
include('../includes/header.php');
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

$teachers = $conn->query("SELECT * FROM Teacher")->fetchAll(PDO::FETCH_OBJ);
$departments = $conn->query("SELECT * FROM Department")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if ($_GET["delid"]) {
  $id = $_GET["delid"];

  $deleteQ2 = $conn->query("DELETE FROM Teacher WHERE tid='$id'");
  header("location: " . APPURL . "/teachers/manage-teachers.php");
}


?>



<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Manage Teachers </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Manage Teachers</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Teachers List</h4>

              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">ID</th>
                      <th class="font-weight-bold">Name</th>
                      <th class="font-weight-bold">Address</th>
                      <th class="font-weight-bold">Phone Number</th>
                      <th class="font-weight-bold">Speciality</th>
                      <th class="font-weight-bold">Department</th>
                      <th class="font-weight-bold">OPS</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($teachers as $teacher): ?>
                      <tr>

                        <td>
                          <?php echo $teacher->tid; ?>
                        </td>
                        <td>
                          <?php echo $teacher->tname; ?>
                        </td>
                        <td>
                          <?php echo $teacher->address; ?>
                        </td>
                        <td>
                          <?php echo $teacher->phone; ?>
                        </td>
                        <td>
                          <?php echo $teacher->speciality; ?>
                        </td>
                        <td>
                          <?php foreach ($departments as $department): ?>
                            <?php if ($department->did == $teacher->did): ?>
                              <?php echo $department->dname; ?>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </td>
                        <td>
                          <a href="edit-teacher.php?editid=<?php echo $teacher->tid; ?>" class="btn btn-primary btn-sm"><i
                              class="icon-pencil"></i></a>
                          <a href="manage-teachers.php?delid=<?php echo $teacher->tid; ?>"
                            onclick="return confirm('Do you really want to delete this teacher ?');"
                            class="btn btn-danger btn-sm"> <i class="icon-trash"></i></a>
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