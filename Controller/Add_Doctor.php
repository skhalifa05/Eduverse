<?php

require_once "../DB/attendance_db.php";
require_once "../Models/Center.php";

session_start();

/**
 * @param Center $center
 * @param mysqli $conn
 */
function school_name_grade_handle(Center $center, mysqli $conn)
{
    $garde_name = "Grade";
    $school_name = "School";
    $admin_id = $center->GetDoctorID($conn, $_POST['Email']);
    if(!$center->CheckDoctorGrade($conn, $_POST['Grade'], $admin_id)){
        $center->AddGradeToDoctor($conn, $_POST['Grade'], $admin_id);
    }
    if(!$center->CheckDoctorSchool($conn, $_POST['School'], $admin_id)){
        $center->AddSchoolNameToDoctor($conn, $_POST['School'], $admin_id);
    }
    if(isset($_POST['Grade1'])){
        $number = 1;
        $id_name = $garde_name . $number;
        while(isset($_POST[$id_name])){
            if(!$center->CheckDoctorGrade($conn, $_POST[$id_name], $admin_id)){
                $center->AddGradeToDoctor($conn, $_POST[$id_name], $admin_id);
            }
            $number++;
            $id_name = $garde_name . $number;
        }
    }
    if(isset($_POST['School1'])){
        $number = 1;
        $id_name = $school_name . $number;
        while(isset($_POST[$id_name])){
            if(!$center->CheckDoctorSchool($conn, $_POST[$id_name], $admin_id)){
                $center->AddSchoolNameToDoctor($conn, $_POST[$id_name], $admin_id);
            }
            $number++;
            $id_name = $garde_name . $number;
        }
    }
}

if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)){
    if(isset($_POST['Add_Doctor'])){
        if(isset($_POST['Grade'])){
            if(!$center->CheckEmailExist($conn, $_POST['Email'])){
                print_r($_POST);
                $center->AddDoctor($conn, $_POST['F_Name'], $_POST['M_Name'], $_POST['L_Name'], $_POST['Email'], $_POST['Phone'], $_POST['Phone'], $_POST['Subject']);
                school_name_grade_handle($center, $conn);
                header("Location: ../Views/PHP/Center_Doc_List.php");
            }else{
                header("Location: ../Views/PHP/Center_Add_Admin.php?Email-Exist");
            }
        }else{
            header("Location: ../Views/PHP/Center_Add_Admin.php?Missing-Data");
        }
    }else if(isset($_POST['Edit_Doctor'])){
        if($_POST['Old_Email'] != $_POST['Email']){
            if(!$center->CheckEmailExist($conn, $_POST['Email'])){
                $center->EditDoctor($conn, $_POST['F_Name'], $_POST['M_Name'], $_POST['L_Name'], $_POST['Email'], $_POST['Phone'], $_POST['Phone'], $_POST['Subject'], $_POST['Admin_ID']);
                $center->DropGradeDoctor($conn, $_POST['Admin_ID']);
                $center->DropSchoolDoctor($conn, $_POST['Admin_ID']);
                school_name_grade_handle($center, $conn);
                header("Location: ../Views/PHP/Center_Doc_List.php");
            }else{
                header("Location: ../Views/PHP/Center_Doc_List.php?Email-Exist");
            }
        }else{
            $center->EditDoctor($conn, $_POST['F_Name'], $_POST['M_Name'], $_POST['L_Name'], $_POST['Email'], $_POST['Phone'], $_POST['Phone'], $_POST['Subject'], $_POST['Admin_ID']);
            $center->DropGradeDoctor($conn, $_POST['Admin_ID']);
            $center->DropSchoolDoctor($conn, $_POST['Admin_ID']);
            school_name_grade_handle($center, $conn);
            header("Location: ../Views/PHP/Center_Doc_List.php");
        }
    }else{
        header("Location: ../Views/PHP/Center_Add_Admin.php");
    }
}else{
    header("Location: ../Views/PHP/Center_Add_Admin.php");
}
