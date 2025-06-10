<?php
require_once "../DB/attendance_db.php";
require_once "../Models/Center.php";

session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)){
    if(isset($_GET['Delete_Course'])){
        if($center->getType() == "SUPER-ADMIN"){
            $center->DeleteCourse($conn, $_GET['Course_ID']);
            header("Location: ../Views/PHP/Center_course.php");
        }else{
            header("Location: ../Views/PHP/Center_course.php?Not-Authorized");
        }
    }
    if(isset($_GET['Disable_Course'])){
        if($center->getType() == "SUPER-ADMIN"){
            $center->DisableCourse($conn, $_GET['Course_ID']);
            header("Location: ../Views/PHP/Center_course.php");
        }else{
            header("Location: ../Views/PHP/Center_course.php?Not-Authorized");
        }
    }
    if(isset($_GET['Enable_Course'])){
        if($center->getType() == "SUPER-ADMIN"){
            $center->Enablecourse($conn, $_GET['Course_ID']);
            header("Location: ../Views/PHP/Center_course.php");
        }else{
            header("Location: ../Views/PHP/Center_course.php?Not-Authorized");
        }
    }
    if(isset($_POST['Insert-Course'])){
        if(isset($_POST['Admin_ID'])){
            $coursename = $_POST['Course_Name'].'-'.$_POST['Course_Level'].'-'.$_POST['Course_Session'].'-'.$_POST['Course_Year'];
            if(!$center->CheckCourseExist($conn, $coursename, $_POST['Admin_ID'])){
                $center->AddCourse($conn, $coursename, $_POST['Admin_ID']);
                header("Location: ../Views/PHP/Center_course.php");
            }else{
                header("Location: ../Views/PHP/Center_course.php?Already-Exist");
            }
        }else{
            header("Location: ../Views/PHP/Center_course.php?Missing-Data");
        }
    }
}else{
    header("Location: ../Views/PHP/Center_course.php");
}