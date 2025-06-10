<?php
header("Location: ../index.php");
require_once "../DB/attendance_db.php";
require_once "../Models/Reader.php";
require_once "../Models/Center.php";

$reader = new Reader();
$center = new Center();

if(isset($_POST['ID']) && isset($conn)){
    $device_id = $_POST['Device_ID'];
    $user_id = $_POST['ID'];
    if($reader->CheckReaderExist($conn, $device_id)){
        $lecture_id = $center->getLectureID_ByReaderID($conn, $device_id);
        $time = date("h:i:s");
        if($reader->Attend_Lecture($conn, $lecture_id, $user_id, $time)){
            echo "200";
        }else{
            echo "400";
        }
    }else{
        echo "400";
    }
}

if(isset($_POST['Device']) && isset($conn)){
    $device_id = $_POST['Device_ID'];
    $device_state = $_POST['Device'];
    $device_name = $_POST['Device_Name'];
    if($device_state === "START"){
        $reader->AddReader($conn, $device_id, $device_name);
        echo "200";
    }else if($device_state === "SHUT_DOWN"){
        $reader->RemoveReader($conn, $device_id);
        echo "200";
    }else{
        echo "400";
    }
}

echo "400";