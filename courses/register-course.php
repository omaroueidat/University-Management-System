<?php
include('../includes/header.php');
include('../includes/dbconnection.php');

if (!isset($_SESSION["id"])) {
    header("location: " . APPURL . "/");
}

$allCourses = $conn->query("SELECT * FROM Course")->fetchAll(PDO::FETCH_OBJ);
$allMajors = $conn->query("SELECT * FROM Major")->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if (isset($_POST['submit'])) {
    if (empty($_POST["CourseId"]) || empty($_POST["MajorId"])) {
        echo "<script>alert('Some of the inputs are empty!');</script>";
    } else {
        $CourseId = $_POST["CourseId"];
        $MajorId = $_POST["MajorId"];

        $query = $conn->prepare("INSERT INTO MajorCourses (mid, cid) VALUES (:CourseId, :MajorId)");
        $query->execute([
            ":CourseId" =>  $CourseId,
            ":MajorId" => $MajorId,
        ]);

        if ($query->rowCount() > 0) {
            echo "<script>alert('Course registered in major successfully!')</script>";
            header("location: " . APPURL . "/courses/registered-courses.php");
        } else {
            echo "<script>alert('Failed to register course in major!');</script>";
        }
    }
}
?>

<div class="container-fluid page-body-wrapper">
    <?php include_once('../includes/sidebar.php'); ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Register Course in Major </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Register Courset</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample row" method="POST">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Major</label>
                                    <select name="CourseId" class="form-control" required>
                                        <?php foreach ($allMajors as $Major) : ?>
                                            <option value='<?php echo $Major->mid; ?>'><?php echo $Major->mname; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Course</label>
                                    <select name="MajorId" class="form-control" required>
                                        <?php foreach ($allCourses as $Course) : ?>
                                            <option value='<?php echo $Course->cid; ?>'><?php echo $Course->cname; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Register</button>
                                </div>
                            </form>
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
