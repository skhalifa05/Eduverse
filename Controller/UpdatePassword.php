<?php

require_once "../DB/attendance_db.php";
require_once "../Models/Student.php";
require_once "../Models/Doctor.php";

session_start();

if(isset($conn)) {
    if(isset($_POST['Password_Change'])){
        $student = unserialize($_SESSION['Student-Attendance-System-1']);
        if($student instanceof Student){
            $err = $student->UpdatePassword($conn, $_POST['Old_Password'], $_POST['New_Password']);
            if($err == 200){
                $_SESSION['Student-Attendance-System-1'] = serialize($student);
                header("Location: ../Views/PHP/profile.php?success");
            }else{
                header("Location: ../Views/PHP/profile.php?fail");
            }
        }else{
            header("Location: ../Views/PHP/profile.php?fail2");
        }
    }else{
        if(isset($_POST['Password_Change_Doctor'])){
            $doctor = unserialize($_SESSION['Doctor-Attendance-System-1']);
            if($doctor instanceof Doctor){
                $err = $doctor->UpdatePassword($conn, $_POST['Old_Password'], $_POST['New_Password']);
                if($err == 200){
                    $_SESSION['Doctor-Attendance-System-1'] = serialize($doctor);
                    header("Location: ../Views/PHP/Doctor_Profile.php?success");
                }else{
                    header("Location: ../Views/PHP/Doctor_Profile.php?fail");
                }
            }else{
                header("Location: ../Views/PHP/Doctor_Profile.php?fail2");
            }
        }else{
            header("Location: ../Views/PHP/profile.php");
        }
    }
}else{
    header("Location: ../Views/PHP/profile.php");
}
