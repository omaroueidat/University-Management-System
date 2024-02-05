<?php
include('../includes/header.php');
include('../includes/dbconnection.php');

if (!isset($_SESSION["id"])) {
    header("location: " . APPURL . "/");
}

$courses = $conn->query("SELECT Course.*, Teacher.tname
FROM Course, Teacher
WHERE Course.teacher = Teacher.tid
UNION
SELECT Course.*, NULL AS tname
FROM Course
WHERE Course.teacher IS NULL")->fetchAll(PDO::FETCH_OBJ);


?>

<?php


// Delete Course
if (isset($_GET["delid"])) {
    $id = $_GET["delid"];
    $deleteQ = $conn->prepare("DELETE FROM Course WHERE cid = :cid");
    $deleteQ->bindParam(":cid", $id);
    $deleteQ->execute();
    header("location: " . APPURL . "/courses/manage-courses.php");
}

?>



<div class="container-fluid page-body-wrapper">
    <?php include_once('../includes/sidebar.php'); ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Manage Courses </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Manage Courses</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <h4 class="card-title mb-sm-0">Course List</h4>

                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold">ID</th>
                                            <th class="font-weight-bold">Course Code</th>
                                            <th class="font-weight-bold">Course Name</th>
                                            <th class="font-weight-bold">Teacher</th>
                                            <th class="font-weight-bold">Course Hours</th>
                                            <th class="font-weight-bold">Course Credits</th>
                                            <th class="font-weight-bold">OPS</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($courses as $course): ?>
                                            <tr>

                                                <td>
                                                    <?php echo $course->cid; ?>
                                                </td>
                                                <td>
                                                    <?php echo $course->ccode; ?>
                                                </td>
                                                <td>
                                                    <?php echo $course->cname; ?>
                                                </td>
                                                <td>
                                                    <?php echo $course->tname; ?>
                                                </td>
                                                <td>
                                                    <?php echo $course->hours; ?>
                                                </td>
                                                <td>
                                                    <?php echo $course->credits; ?>
                                                </td>
                                                <td>
                                                    <a href="edit-course.php?editid=<?php echo $course->cid; ?>"
                                                        class="btn btn-primary btn-sm"><i class="icon-pencil"></i></a>
                                                    <a href="manage-courses.php?delid=<?php echo $course->cid; ?>"
                                                        onclick="return confirm('Do you really want to delete this course ?');"
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