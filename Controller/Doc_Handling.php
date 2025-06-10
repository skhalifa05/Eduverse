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
    if (isset($_GET['Delete_Doc'])) {
        if($center->getType() == "SUPER-ADMIN"){
            $center->DeleteDoctor($conn, $_GET['Admin_ID']);
            header("Location: ../Views/PHP/Center_Doc_List.php");
        }else{
            header("Location: ../Views/PHP/Center_Doc_List.php?Not-Authorized");
        }
    }else{
        header("Location: ../Views/PHP/Center_Doc_List.php");
    }
}else{
    header("Location: ../Views/PHP/Center_Doc_List.php");
}