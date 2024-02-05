<?php
include('includes/dbconnection.php');
include('includes/header.php');

if (!isset($_SESSION["id"])) {
    header("location: " . APPURL . "/");
} else {
    // Search
    if (isset($_POST['search'])) {
        $sdata = $_POST['searchdata'];
    }

    
    $query = $conn->prepare("SELECT * FROM Student, Major WHERE sname LIKE CONCAT('%', :sdata, '%') AND Student.smajor = Major.mid");
    $query->bindParam(':sdata', $sdata, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>
  

<div class="container-fluid page-body-wrapper">
   <?php include_once('includes/sidebar.php'); ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Search Results </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Search Results</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <h4 align="center">Result against "<?php echo $sdata; ?>" keyword</h4>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold">Student ID</th>
                                            <th class="font-weight-bold">Student Name</th>
                                            <th class="font-weight-bold">Birth Date</th>
                                            <th class="font-weight-bold">Email</th>
                                            <th class="font-weight-bold">Phone</th>
                                            <th class="font-weight-bold">Address</th>
                                            <th class="font-weight-bold">Gender</th>
                                            <th class="font-weight-bold">Nationality</th>
                                            <th class="font-weight-bold">Major</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) : ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row->sid); ?></td>
                                                    <td><?php echo htmlentities($row->sname); ?></td>
                                                    <td><?php echo htmlentities($row->bdate); ?></td> 
                                                    <td><?php echo htmlentities($row->semail); ?></td>
                                                    <td><?php echo htmlentities($row->phone); ?></td>
                                                    <td><?php echo htmlentities($row->address); ?></td>
                                                    <td><?php echo htmlentities($row->gender); ?></td>
                                                    <td><?php echo htmlentities($row->nationality); ?></td>
                                                    <td><?php echo htmlentities($row->mname); ?></td>
                                                   
                                                   
                                                </tr>
                                        <?php endforeach; ?>
                                        <?php
                                        } else { ?>
                                            <tr>
                                                <td colspan="6"> No record found against this search</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php include_once('includes/footerText.php'); ?>
                    </div>
                </div>
            </div>
        </div>
       
        <?php include_once('includes/footer.php'); ?>
       
    </div>
 
</div>

</div>


