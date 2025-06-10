<?php

require_once "../DB/attendance_db.php";
require_once "../Models/Center.php";
require_once "../Models/User.php";

session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)){
    if(isset($_POST['Insert-Room'])){
        if(isset($_POST['Device_ID']) AND isset($_POST['Course_Time_ID'])){
            if(isset($_POST['Start-on-insert'])){
                $center->AddLecture($conn, $_POST['Course_Time_ID'], $_POST['Device_ID'], $_POST['Lecture_Name'], "STARTED");
            }else{
                $center->AddLecture($conn, $_POST['Course_Time_ID'], $_POST['Device_ID'], $_POST['Lecture_Name'], "NOT-STARTED");
            }
            header("Location: ../Views/PHP/Center_Home.php");
        }else{
            header("Location: ../Views/PHP/Center_Home.php?Missing-Data");
        }
    }
    if(isset($_GET['State_Button_Clicked'])){
        if($_GET['State'] === "1"){
            $center->FinishLecture($conn, $_GET['Lecture_ID']);
            $center->AbsentRemainStudent($conn, $_GET['Lecture_ID']);
        }else if($_GET['State'] === "2"){
            $center->StartLecture($conn, $_GET['Lecture_ID']);
        }else if($_GET['State'] === "3"){
            $center->CancelLect($conn, $_GET['Lecture_ID']);
            $center->CancelAllStu($conn, $_GET['Lecture_ID']);
        }
        header("Location: ../Views/PHP/Center_Home.php");
    }
    if(isset($_GET['Lecture_Delete'])){
        if($center->getType() == "SUPER-ADMIN"){
            $center->RemoveLecture($conn, $_GET['Lecture_ID']);
            header("Location: ../Views/PHP/Center_Home.php");
        }else{
            header("Location: ../Views/PHP/Center_Home.php?Not-Authorized");
        }
    }
}else{
    header("Location: ../Views/PHP/Center_Home.php");
}