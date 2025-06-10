<?php

require_once "../Models/User.php";
require_once "../Models/Student.php";
require_once "../Models/Center.php";
require_once "../Models/Doctor.php";
require_once "../DB/attendance_db.php";

$user = new User();

session_start();

if (isset($conn)){
    if(isset($_POST['Login-Form'])){
        $email = $_POST['Login-Email'];
        $password = $_POST['Login-Password'];
        $err = $user->Login($conn, $email, $password);
        if ($err == 202) {
            $data = $user->getStudentArray();
            if($data['Verify']){
                $name = $data['F_Name'] . " " . $data['M_Name'] . " " . $data['L_Name'];
                $student = new Student($name, $data['Password'], $data['Email'], $data['Phone'], $data['School_Name'], $data['Relation_Name'], $data['Parent_Name'], $data['Relation_Phone'], $data['Student_ID'], $data['Grade'], $data['Age']);
                $_SESSION['Student-Attendance-System-1']=serialize($student);
                header("Location:../Views/PHP/profile.php");
            }else{
                header("Location:../index.php?User-Not-Authorized");
            }
        }elseif($err == 201){
            $data = $user->getAdminArray();
            $school_data = $user->GetAllSchoolForDoctor($conn, $data['Admin_ID']);
            $grade_data = $user->GetAllGradesForDoctor($conn, $data['Admin_ID']);
            $name = $data['F_Name'] . " " . $data['M_Name'] . " " . $data['L_Name'];
            $doctor = new Doctor($name, $data['Password'], $data['Email'], $data['Phone'], $data['Subject'], $school_data, $grade_data, $data['Admin_ID']);
            $_SESSION['Doctor-Attendance-System-1']=serialize($doctor);
            header("Location:../Views/PHP/Doctor_Profile.php");
        }elseif($err == 200){
            $center = new Center();
            $data = $user->getCenterArray();
            $name = $data['F_Name'] . " " . $data['M_Name'] . " " . $data['L_Name'];
            $center->setName($name);
            $center->setType($data['Type']);
            $_SESSION['Center-Attendance-System-1']=serialize($center);
            header("Location:../Views/PHP/dashboard.php");
        }elseif($err == 400){
            header("Location:../index.php?Data-is-incorrect");
        }elseif($err == 401){
            header("Location:../index.php?Missing-Input-Data");
        }else{
            header("Location:../index.php");
        }
    }else{
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}