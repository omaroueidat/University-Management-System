<?php
include('../includes/header.php');
include('../includes/dbconnection.php');

if (!isset($_SESSION["id"])) {
    header("location: " . APPURL . "/");
}
if (isset($_GET["xid"])) {
    $id = $_GET["xid"];
    $examQ = $conn->query("SELECT * FROM Exam WHERE Exam.xid = '$id'")->fetch(PDO::FETCH_OBJ);
    if ($examQ->status == "active" || $examQ->status == "expired") {
        header("location: " . APPURL . "/exams/manage-exams.php");
    }
}
$allCourses = $conn->query("SELECT * FROM Course")->fetchAll(PDO::FETCH_OBJ);
?>

<?php

if (isset($_GET["xid"])) {

    $examId = $_GET["xid"];

    // Get the exam information
    $queryFetch = $conn->query("SELECT * FROM Exam WHERE xid = '$examId'");


    $examInfo = $queryFetch->fetch(PDO::FETCH_ASSOC);

    if (!$examInfo) {
        echo "<script>alert('Exam not found!')</script>";
        header("location: " . APPURL . "/");
    }

    // Validate dates

    if (isset($_POST['update'])) {

        $xlabel = $_POST["xlabel"];
        $fromhour = $_POST["fromhour"];
        $tohour = $_POST["tohour"];
        $xdate = $_POST["xdate"];
        $cid = $_POST["cid"];


        // Update the course information
        $queryUpdate = $conn->prepare("EXEC UpdateExam @xid = ?, @xlabel = ?, @fromhour = ?, @tohour = ?, @xdate = ?, @cid = ?");


        $queryUpdate->bindParam(1, $examId, PDO::PARAM_INT);
        $queryUpdate->bindParam(2, $xlabel, PDO::PARAM_STR);
        $queryUpdate->bindParam(3, $fromhour, PDO::PARAM_STR);
        $queryUpdate->bindParam(4, $tohour, PDO::PARAM_STR);
        $queryUpdate->bindParam(5, $xdate, PDO::PARAM_STR);
        $queryUpdate->bindParam(6, $cid, PDO::PARAM_INT);



        $queryUpdate->execute();
        $fetch = $queryUpdate->fetch(PDO::FETCH_OBJ);
        if ($fetch->Result != "") {
            $_SESSION["error"] = $fetch->Result;
        }

        header("location: " . APPURL . "/exams/manage-exams.php");


    }
}

?>

<div class="container-fluid page-body-wrapper">
    <?php include_once('../includes/sidebar.php'); ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Edit Exam </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="manage-exams.php">Manage Exams</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Edit Exam</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample row" method="POST">

                                <div class="form-group col-12">
                                    <p>This label was scheduled from
                                        <?= $examInfo['fromhour'] ?> to
                                        <?= $examInfo['tohour'] ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Exam Type</label>
                                    <select name="xlabel" class="form-control" required="true">
                                        <?php
                                        if ($examInfo['xlabel'] === "Final"): ?>
                                            <option value="Final" selected>Final Exam</option>
                                            <option value="Midterm">Midterm Exam</option>
                                        <?php else: ?>
                                            <option value="Midterm" selected>Midterm Exam</option>
                                            <option value="Final">Final Exam</option>
                                        <?php endif; ?>


                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">From Hour</label>
                                    <input type="time" name="fromhour" value="<?= $examInfo['fromhour'] ?>"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">To Hour</label>
                                    <input type="time" name="tohour" value="<?= $examInfo['tohour'] ?>"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Exam Date</label>
                                    <input type="date" name="xdate" value="<?= $examInfo['xdate'] ?>"
                                        class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="exampleInputName1">Course Name</label>
                                    <select name="cid" class="form-control" required>
                                        <?php foreach ($allCourses as $course): ?>
                                            <?php if ($course->cid === $examInfo->cid): ?>
                                                <option value='<?php echo $examInfo->cid; ?>' selected>
                                                    <?php echo $course->cname; ?>
                                                </option>

                                            <?php else: ?>
                                                <option value='<?php echo $course->cid; ?>'>
                                                    <?php echo $course->cname; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary mr-2" name="update">Save</button>
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