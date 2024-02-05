<?php
include('../includes/header.php');
include('../includes/dbconnection.php');

if (!isset($_SESSION["id"])) {
    header("location: " . APPURL . "/");
}


$Allteachers = $conn->query("SELECT * FROM Teacher")->fetchAll(PDO::FETCH_OBJ);
?>

<?php

if (isset($_GET["editid"])) {

    $courseId = $_GET["editid"];

    // Get the course information

    $courseInfo = $conn->query("SELECT * FROM Course WHERE Course.cid='$courseId'")->fetch(PDO::FETCH_OBJ);


    if (!$courseInfo) {
        echo "<script>alert('Course not found!')</script>";
        header("location: " . APPURL . "/");
    }




    if (isset($_POST['submit'])) {

        $ccode = $_POST["ccode"];
        $cname = $_POST["cname"];
        $hours = $_POST["hours"];
        $credits = $_POST["credits"];

        $teacherId = $_POST["teacher"];


        // Update the course information
        $queryUpdate = $conn->prepare("UPDATE Course SET ccode = :ccode, cname = :cname, hours = :hours, credits = :credits, teacher = :teacherId WHERE cid = '$courseId'");
        $queryUpdate->execute([
            ":ccode" => $ccode,
            ":cname" => $cname,
            ":hours" => $hours,
            ":credits" => $credits,
            ":teacherId" => $teacherId,

        ]);

        if ($queryUpdate->rowCount() > 0) {
            echo "<script>alert('Course updated successfully!')</script>";
            header("location: " . APPURL . "/courses/manage-courses.php");
        } else {
            echo "<script>alert('Failed to update the course!')</script>";
        }
    }
}
?>


<div class="container-fluid page-body-wrapper">
    <?php include_once('../includes/sidebar.php'); ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Edit Course </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="manage-courses.php">Manage Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Edit Course</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample row" method="POST">

                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Course Code</label>
                                    <input type="text" name="ccode" value="<?php echo $courseInfo->ccode; ?>"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Course Name</label>
                                    <input type="text" name="cname" value="<?php echo $courseInfo->cname; ?>"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Course Hours</label>
                                    <input type="text" name="hours" value="<?php echo $courseInfo->hours; ?>"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Course Credits</label>
                                    <input type="text" name="credits" value="<?php echo $courseInfo->credits; ?>"
                                        class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Teacher Name</label>
                                    <select name="teacher" class="form-control" required>
                                        <?php foreach ($Allteachers as $teacher): ?>
                                            <?php if ($teacher->tid === $courseInfo->teacher): ?>
                                                <option value='<?php echo $courseInfo->teacher; ?>' selected>
                                                    <?php echo $teacher->tname; ?>
                                                </option>

                                            <?php else: ?>
                                                <option value='<?php echo $teacher->tid; ?>'>
                                                    <?php echo $teacher->tname; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Save</button>
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