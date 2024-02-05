<?php
include('../includes/header.php');
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

$faculties = $conn->query("SELECT * FROM Faculty")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if ($_GET["delid"]) {
  $id = $_GET["delid"];
  $deleteQ = $conn->query("DELETE FROM Faculty WHERE fid='$id'");
  header("location: " . APPURL . "/faculties/manage-faculties.php");
}


?>



<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Manage Faculties </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Manage Faculties</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Faculties List</h4>

              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">ID</th>
                      <th class="font-weight-bold">Faculty Name</th>
                      <th class="font-weight-bold">Total Departments</th>
                      <th class="font-weight-bold">OPS</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($faculties as $faculty): ?>
                      <tr>

                        <td>
                          <?php echo $faculty->fid; ?>
                        </td>
                        <td>
                          <?php echo $faculty->fname; ?>
                        </td>
                        <td>
                          <?php echo $faculty->total_departments; ?>
                        </td>
                        <td>
                          <a href="edit-faculty.php?editid=<?php echo $faculty->fid; ?>" class="btn btn-primary btn-sm"><i
                              class="icon-pencil"></i></a>
                          <a href="manage-faculties.php?delid=<?php echo $faculty->fid; ?>"
                            onclick="return confirm('Do you really want to delete this faculty ?');"
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