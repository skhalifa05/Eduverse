<?php


require_once "../DB/ramy_db.php";
require_once "../Models/Center.php";
require_once "../Models/User.php";
require_once "../Models/Email.php";

session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)){
    $email = new Email("codeology.com2023@brightside-edu.com", "Codeology Commercials", "Dev@2707");


    //$email->ramyattend("Maria","maria.adeeb@uofcanada.edu.eg");
    //if($email) {
      //  echo 'succ';
    //}
    //else{
      //  echo 'fail';
    //}
    $data = $center->ramydata($conn);
    $i=1;
    while($row = $data->fetch_assoc()){
        $email->ramyattend($row['Fname'],$row['email']);
        if($email) {
            echo 'succ';
            echo nl2br($i.' '.$row['Fname'].' '.$row['email'].'\n');
            $i+=1;
        }
        else{
            echo 'fail';
            echo nl2br($i.' '.$row['Fname'].' '.$row['email'].'\n');
            $i+=1;
        }
    }
}else {
    header("Location: ../Views/PHP/dashboard.php");
}