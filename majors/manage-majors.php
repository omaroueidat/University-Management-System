<?php include('../includes/header.php'); ?>

<?php
    if (!isset($_SESSION["id"])) {
        header("location: " . APPURL . "/");
    }

    $getMajors = $conn->query("SELECT * 
                               FROM Major AS m, Faculty AS f
                               WHERE m.fid = f.fid
    
    ");
    $majors = $getMajors->fetchAll(PDO::FETCH_OBJ);


    if ($_GET["delid"]) {
        $mid = $_GET["delid"];
        $errorMessage = "";

        $delete = $conn->prepare("{CALL DeleteMajor(@mid=:mid, @errorMessage=:errorMessage)}");
        $delete->bindParam(':mid',$mid,PDO::PARAM_INT);
        $delete->bindParam(':errorMessage', $errorMessage, PDO::PARAM_STR, 4000);
        $delete->execute();

        if ($errorMessage == "Cannot delete major since students are assigned to it") {
            echo "<script>
                    var confirmation = confirm('Error: " . $errorMessage . "');
                    if (confirmation) {
                        window.location.href = '".$_SERVER['PHP_SELF']."';
                    }
                  </script>";
        } else{
            echo "<script>
                        alert('Delete Was Successfull!'); 
                        window.location.href = '".$_SERVER['PHP_SELF']."';
                </script>";
        }
    }
    


?>



<div class="container-fluid page-body-wrapper">

  <?php include_once('../includes/sidebar.php'); ?>

  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Manage Majors </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo APPURL ?>/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Manage Majors</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-sm-flex align-items-center mb-4">
                <h4 class="card-title mb-sm-0">Majors List</h4>

              </div>
              <div class="table-responsive border rounded p-1">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="font-weight-bold">ID</th>
                      <th class="font-weight-bold">Major Name</th>
                      <th class="font-weight-bold">Faculty Name</th>
                      <th class="font-weight-bold">Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($majors as $major): ?>
                      <tr>

                        <td>
                          <?php echo $major->mid; ?>
                        </td>
                        <td>
                          <?php echo $major->mname; ?>
                        </td>

                        <td>
                            <?php echo $major->fname; ?>
                        </td>

                        <td>
                          <a href="edit-major.php?id=<?php echo $major->mid; ?>" class="btn btn-primary btn-sm"><i
                              class="icon-pencil"></i></a>
                          <a href="manage-majors.php?delid=<?php echo $major->mid; ?>"
                            onclick="return confirm('Do you really want to delete this major ?');"
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