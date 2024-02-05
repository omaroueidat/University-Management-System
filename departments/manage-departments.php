<?php
include('../includes/header.php');
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

$departments = $conn->query("SELECT * FROM Department")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if ($_GET["delid"]) {
  $id = $_GET["delid"];

  $deleteQ1 = $conn->query("DELETE FROM Teacher WHERE did='$id'");
  $deleteQ2 = $conn->query("DELETE FROM FacDepReg WHERE did='$id'");
  $deleteQ3 = $conn->query("DELETE FROM Department WHERE did='$id'");

  header("location: " . APPURL . "/departments/manage-departments.php");
}


?>



<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Manage Departments </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Manage Departments</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Departments List</h4>

              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">ID</th>
                      <th class="font-weight-bold">Department Name</th>
                      <th class="font-weight-bold">Total Teachers</th>
                      <th class="font-weight-bold">OPS</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($departments as $department): ?>
                      <tr>

                        <td>
                          <?php echo $department->did; ?>
                        </td>
                        <td>
                          <?php echo $department->dname; ?>
                        </td>
                        <td>
                          <?php echo $department->total_teachers; ?>
                        </td>

                        <td>
                          <a href="edit-department.php?editid=<?php echo $department->did; ?>" class="btn btn-primary btn-sm"><i
                              class="icon-pencil"></i></a>
                          <a href="manage-departments.php?delid=<?php echo $department->did; ?>"
                            onclick="return confirm('Do you really want to delete this department ?');"
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