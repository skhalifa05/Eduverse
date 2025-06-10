<?php


require_once "../DB/attendance_db.php";
require_once "../Models/Center.php";

session_start();


if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)) {
    $courses = array();
    if (isset($_GET['Year'])){
        $primData = $center->RetSOldCourse($conn, $_POST['ID'], $_GET['Year']);
    }else{
        $primData = $center->RetSCourse($conn, $_POST['ID']);
    }
    if ($primData != null) {
        while($primary_row = $primData->fetch_assoc()){
            $courses[] = $primary_row['Course_ID'];

        }



        $cust = $courses;
        echo json_encode($cust);

    } else {
        printf('No record found.<br />');
    }
}
else {
    header("Location: ../Views/PHP/dashboard.php");
}