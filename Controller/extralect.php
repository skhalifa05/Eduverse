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
    if(isset($_POST['Insert-Extra-Time'])){
        if(isset($_POST['date']) AND isset($_POST['Course_ID'])){
            $id = $center->getCTid($conn, $_POST['Course_ID']);
            while ($row = $id->fetch_assoc()){
                $center->AddLecture($conn, $row['Course_Time_ID'], '-1', $_POST['date'].' '.'X', "NOT-STARTED");
                 header("Location: ../Views/PHP/Center_Home.php");  
            }
        }else{
            header("Location: ../Views/PHP/Center_Home.php");  
        }
        
    }else{
            header("Location: ../Views/PHP/Center_Home.php");
    }
}else{
    header("Location: ../Views/PHP/Center_Home.php");
}