<?php
include('../includes/header.php');
if (!isset($_SESSION["id"])) {
  header("location: " . APPURL . "/");
}

$data = $conn->query("SELECT * FROM MajorCourses, Course, Major WHERE MajorCourses.mid = Major.mid AND MajorCourses.cid = Course.cid")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if ($_GET["delid"]) {
  $id = $_GET["delid"];
  $deleteQ = $conn->query("DELETE FROM MajorCourses WHERE id='$id'");
  header("location: " . APPURL . "/courses/registered-courses.php");
}


?>



<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Registered Courses </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Registered Courses</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Registered Courses List</h4>

              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">Registration ID</th>
                      <th class="font-weight-bold">Courses</th>
                      <th class="font-weight-bold">Majors</th>
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
                          <?php echo $item->cname; ?>
                        </td>
                        <td>
                          <?php echo $item->mname; ?>
                        </td>

                        <td>
                          <a href="edit-registered-course.php?editid=<?php echo $item->id; ?>"
                            class="btn btn-primary btn-sm"><i class="icon-pencil"></i></a>
                          <a href="registered-courses.php?delid=<?php echo $item->id; ?>"
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