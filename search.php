<?php
include('includes/dbconnection.php');
include('includes/header.php');

if (!isset($_SESSION["id"])) {
    header("location: " . APPURL . "/");
}
?>


<div class="container-fluid page-body-wrapper">
  
    <?php include_once('includes/sidebar.php'); ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Search Student </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Search Student</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form action="search-results.php" method="post">
                                <div class="form-group">
                                    <strong>Search Student:</strong>
                                    <input id="searchdata" type="text" name="searchdata" required="true" class="form-control"
                                        placeholder="Search by Student Name">
                                </div>
                                <button type="submit" class="btn btn-primary" name="search" id="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include_once('includes/footer.php'); ?>
 
    </div>
    
</div>

</div>

