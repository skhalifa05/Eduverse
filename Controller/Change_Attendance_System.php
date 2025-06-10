<?php

require_once "../DB/attendance_db.php";
require_once "../Models/Center.php";
require_once "../Models/Doctor.php";

session_start();

if(isset($conn) && isset($_GET['ChangeUserState'])){
    if($_GET['From'] == 1){
        $center = unserialize($_SESSION['Center-Attendance-System-1']);
        if($center instanceof Center){
            if($_GET['UserState'] == 1){
                $center->ChangeFromAttendToAbsent($conn, $_GET['Lecture_ID'], $_GET['Student_ID']);
            }else if($_GET['UserState'] == 2){
                $center->ChangeFromAbsentToAttend($conn, $_GET['Lecture_ID'], $_GET['Student_ID']);
            }
        }
        header("Location: ../Views/PHP/Center_Lecture_List.php");
    }else if($_GET['From'] == 2){
        $doctor = unserialize($_SESSION['Doctor-Attendance-System-1']);
        if($doctor instanceof Doctor){
            if($_GET['UserState'] == 1){
                $doctor->ChangeFromAttendToAbsent($conn, $_GET['Lecture_ID'], $_GET['Student_ID']);

            }else if($_GET['UserState'] == 2){
                $doctor->ChangeFromAbsentToAttend($conn, $_GET['Lecture_ID'], $_GET['Student_ID']);
            }
        }
        header("Location: ../Views/PHP/Doctor_Attendance.php");
    }
}else{
    header("Location: ../index.php");
}
