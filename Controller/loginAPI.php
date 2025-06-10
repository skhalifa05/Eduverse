<?php

require_once "../Models/User.php";
require_once "../Models/Student.php";
require_once "../Models/Center.php";
require_once "../Models/Doctor.php";
require_once "../DB/attendance_db.php";

$user = new User();

session_start();

if (isset($conn)){
    if(isset($_GET['Login-Form'])){
        $encodedData = file_get_contents('php://input');
        $decodedData = json_decode($encodedData,true);
        $email = $decodedData['LoginEmail'];
        $password = $decodedData['LoginPassword'];
        $err = $user->Login($conn, $email, $password);
        if ($err == 202) {
            $data = $user->getStudentArray();
            if($data['Verify']){
                $fname = $data['F_Name'];
                $Lname = $data['L_Name'];
                $email = $data['Email'];
                $ID = $data['Student_ID'];
                $school = $data['School_Name'];
                $gaurdt = $data['Relation_Name'];
                $gaurdp = $data['Relation_Phone'];
                $name = $data['F_Name'] . " " . $data['M_Name'] . " " . $data['L_Name'];
                $student = new Student($name, $data['Password'], $data['Email'], $data['Phone'], $data['School_Name'], $data['Relation_Name'], $data['Parent_Name'], $data['Relation_Phone'], $data['Student_ID'], $data['Grade'], $data['Age']);
                $_SESSION['Student-Attendance-System-1']=serialize($student);
                $message = "Login";
            }else{
                $message = "invalid";
            }
        }elseif($err == 201){
            $data = $user->getAdminArray();
            $school_data = $user->GetAllSchoolForDoctor($conn, $data['Admin_ID']);
            $grade_data = $user->GetAllGradesForDoctor($conn, $data['Admin_ID']);
            $fname = $data['F_Name'];
            $Lname = $data['L_Name'];
            $doctor = new Doctor($name, $data['Password'], $data['Email'], $data['Phone'], $data['Subject'], $school_data, $grade_data, $data['Admin_ID']);
            $_SESSION['Doctor-Attendance-System-1']=serialize($doctor);
            $message = "Login"."".$name;
        }elseif($err == 200){
            $center = new Center();
            $data = $user->getCenterArray();
            $fname = $data['F_Name'];
            $Lname = $data['L_Name'];
            $name = $data['F_Name'] . " " . $data['M_Name'] . " " . $data['L_Name'];
            $center->setName($name);
            $center->setType($data['Type']);
            $_SESSION['Center-Attendance-System-1']=serialize($center);
            $message = "Login";
        }elseif($err == 400){
            $message = "invalid";
        }
    } else {
        $message = "ok";
    }
}
$response[] = array("Status"=>$message);
$response[] = array("Fname"=>$fname);
$response[] = array("Lname"=>$Lname);
$response[] = array("ID"=>$ID);
$response[] = array("GaurdianT"=>$gaurdt);
$response[] = array("GaurdianP"=>$gaurdp);
$response[] = array("School"=>$school);
$response[] = array("Email"=>$email);
echo(json_encode($response));
?>