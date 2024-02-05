<?php
if (!APPURL) {
  define("APPURL", "http://localhost/db-uni-project");
}
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav mt-3">


    <li class="nav-item">
      <a class="nav-link" href="<?php echo APPURL; ?>/dashboard.php">
        <i class="icon-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>

      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-home menu-icon"></i>
        <span class="menu-title">Faculties</span>
      </a>
      <div class="collapse" id="ui-basic2">
        <ul class="nav flex-column sub-menu m-2">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/faculties/add-faculty.php">Add Faculty</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/faculties/manage-faculties.php">Manage Faculties</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic4" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-home menu-icon"></i>
        <span class="menu-title">Departments</span>
      </a>
      <div class="collapse " id="ui-basic4">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/departments/add-department.php">Add Department</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/departments/manage-departments.php">Manage Departments</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/departments/register-department.php">Register Department</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/departments/registered-departments.php">Registered Departments</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic0" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-people menu-icon"></i>
        <span class="menu-title">Teachers</span>
      </a>
      <div class="collapse" id="ui-basic0">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/teachers/add-teacher.php">Add Teacher</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/teachers/manage-teachers.php">Manage Teachers</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
        <i class="icon-people menu-icon"></i>
        <span class="menu-title">Students</span>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/students/add-student.php">Add Student</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/students/manage-students.php">Manage Students</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/students/register-student.php">Register Student</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/students/registered-students.php">Registered Students</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic1">
        <i class="icon-people menu-icon"></i>
        <span class="menu-title">Admins</span>
      </a>
      <div class="collapse" id="ui-basic3">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/admins/add-admin.php">Add Admin</a>
          </li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/admins/manage-admins.php">Manage
              Admins</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-layers menu-icon"></i>
        <span class="menu-title">Courses</span>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/courses/add-course.php">Add Course</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/courses/manage-courses.php">Manage Courses</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/courses/register-course.php">Register Course</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/courses/registered-courses.php">Registered Courses</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic7" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-layers menu-icon"></i>
        <span class="menu-title">Majors</span>
      </a>
      <div class="collapse" id="ui-basic7">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/majors/add-major.php">Add Major</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/majors/manage-majors.php">Manage Majors</a></li>

        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic9" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-doc menu-icon"></i>
        <span class="menu-title">Exams</span>
      </a>
      <div class="collapse" id="ui-basic9">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/exams/add-exam.php">Add Exam</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/exams/manage-exams.php">Manage Exams</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic8" aria-expanded="false" aria-controls="ui-basic">
        <i class="icon-doc menu-icon"></i>
        <span class="menu-title">Marks</span>
      </a>
      <div class="collapse" id="ui-basic8">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/marks/add-mark.php">Add Mark</a></li>
          <li class="nav-item"> <a class="nav-link p-3" href="<?php echo APPURL; ?>/marks/manage-marks.php">Manage Marks</a></li>
        </ul>
      </div>
    </li>






    <li class="nav-item">
      <a class="nav-link" href="<?php echo APPURL; ?>/search.php">
        <i class="icon-magnifier menu-icon"></i>
        <span class="menu-title">Search</span>
      </a>
    </li>
    </li>




  </ul>
</nav>