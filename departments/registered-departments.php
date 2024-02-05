<?php
include('../includes/header.php');
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

$data = $conn->query("SELECT * FROM FacDepReg, Department, Faculty WHERE FacDepReg.fid = Faculty.fid AND FacDepReg.did = Department.did")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if ($_GET["delid"]) {
  $id = $_GET["delid"];
  $deleteQ = $conn->query("DELETE FROM FacDepReg WHERE id='$id'");
  header("location: " . APPURL . "/departments/registered-departments.php");
}


?>



<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Registered Departments </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Registered Departments</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Registered Departments List</h4>

              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">Registration ID</th>
                      <th class="font-weight-bold">Department</th>
                      <th class="font-weight-bold">Faculty</th>
                      <th class="font-weight-bold">OPS</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data as $item): ?>
                      <tr>
                        <td>
                          <?php echo $item->id; ?>
                        </td>

                        <td>
                          <?php echo $item->dname; ?>
                        </td>
                        <td>
                          <?php echo $item->fname; ?>
                        </td>

                        <td>
                          <a href="edit-registered-department.php?editid=<?php echo $item->id; ?>"
                            class="btn btn-primary btn-sm"><i class="icon-pencil"></i></a>
                          <a href="registered-departments.php?delid=<?php echo $item->id; ?>"
                            onclick="return confirm('Do you really want to delete this registration ?');"
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