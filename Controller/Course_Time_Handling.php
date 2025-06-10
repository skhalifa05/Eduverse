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
    if(isset($_GET['Delete_Course_Time'])){
        if($center->getType() == "SUPER-ADMIN"){
            $center->DeleteCourseTime($conn, $_GET['Course_Time_ID']);
            header("Location: ../Views/PHP/Center_Lectures.php");
        }else{
            header("Location: ../Views/PHP/Center_Lectures.php?Not-Authorized");
        }
    }
    if(isset($_POST['Insert-Course-Time'])){
        if(isset($_POST['Course_ID']) AND isset($_POST['Course_Day'])){
            $time = strtotime($_POST['Course_Time']);
            $period = strtotime($_POST['Course_Period']);
            $secs = $period-strtotime("00:00:00");
            $result = date("H:i:s",$time+$secs);
            $admin_id = $center->GetAdminIDByCourseID($conn, $_POST['Course_ID']);
            if($center->CheckCourseTime($conn, $_POST['Course_Day'], $_POST['Course_Time'], $result, $_POST['Course_ID'], $admin_id)){
                $center->InsertCourseTime($conn, $_POST['Course_ID'], $_POST['Course_Day'], $_POST['Course_Time'], $_POST['Course_Period']);
                header("Location: ../Views/PHP/Center_Lectures.php");
            }else{
                header("Location: ../Views/PHP/Center_Lectures.php?Time-Error");
            }
        }else{
            header("Location: ../Views/PHP/Center_Lectures.php?Missing-Data");
        }
    }
    if(isset($_POST['Edit-Course-Time'])){
        if(isset($_POST['Course_Day'])){
            $time = strtotime($_POST['Course_Time']);
            $period = strtotime($_POST['Course_Period']);
            $secs = $period-strtotime("00:00:00");
            $result = date("H:i:s",$time+$secs);
            $admin_id = $center->GetAdminIDByCourseID($conn, $_POST['Edit-Lecture-course-Id']);
            if($center->CheckCourseTime($conn, $_POST['Course_Day'], $_POST['Course_Time'], $result, $_POST['Edit-Lecture-course-Id'], $admin_id)){
                $center->EditCourseTime($conn, $_POST['Edit-Lecture-course-Id'], $_POST['Course_Day'], $_POST['Course_Time'], $_POST['Course_Period'], $_POST['Edit-Lecture-Id']);
                header("Location: ../Views/PHP/Center_Lectures.php");
            }else{
                header("Location: ../Views/PHP/Center_Lectures.php?Time-Error");
            }
        }else{
            header("Location: ../Views/PHP/Center_Lectures.php?Missing-Data");
        }
    }
}else{
    header("Location: ../Views/PHP/Center_Lectures.php");
}