<?php

require_once "../DB/attendance_db.php";
require_once "../Models/Center.php";
require_once "../Models/Email.php";

/**
 * @param Center $center
 * @param mysqli $conn
 * @return bool
 */
function time_table_handle(Center $center, mysqli $conn):bool
{
    $fail = false;
    $course_name = "Course";
    $user_id = $center->GetStudentID($conn, $_POST['Email']);
    $course_id = $center->GetCourseIdByCourseTimeID($conn,  $_POST['Course']);
    if($center->CheckIfCourseTaken($conn, $_POST['Course'], $user_id)){
        $data_array = $center->GetCourseTimeInfo($conn, $_POST['Course']);
        $time = strtotime($data_array['Time']);
        $period = strtotime($data_array['Period']);
        $secs = $period-strtotime("00:00:00");
        $result = date("H:i:s",$time+$secs);
        if($center->CheckIfCourseTime($conn, $data_array['Day'], $data_array['Time'], $result, $user_id)){
            $center->AddCourseToStudent($conn, $user_id, $_POST['Course']);
        }else{
            $fail = true;
        }
    }else{
        $fail = true;
    }
    if(isset($_POST['Course1'])){
        $number = 1;
        $id_name = $course_name . $number;
        while(isset($_POST[$id_name])){
            $course_id = $center->GetCourseIdByCourseTimeID($conn,  $_POST[$id_name]);
            if($center->CheckIfCourseTaken($conn, $_POST[$id_name], $user_id)){
                $data_array = $center->GetCourseTimeInfo($conn, $_POST[$id_name]);
                $time = strtotime($data_array['Time']);
                $period = strtotime($data_array['Period']);
                $secs = $period-strtotime("00:00:00");
                $result = date("H:i:s",$time+$secs);
                if($center->CheckIfCourseTime($conn, $data_array['Day'], $data_array['Time'], $result, $user_id)){
                    $center->AddCourseToStudent($conn, $user_id, $_POST[$id_name]);
                }else{
                    $fail = true;
                }
            }else{
                $fail = true;
            }
            $number++;
            $id_name = $course_name . $number;
        }
    }
    return $fail;
}

session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)){
    $email = new Email("CodeologyEdu@brightside-edu.com", "Codeology Education", "Codeologyedu@2022");
    if(isset($_POST['Add_Student'])){
        if(isset($_POST['Course'])){
            if(!$center->CheckEmailExist($conn, $_POST['Email'])){
                $fail = false;
                $center->AddStudent($conn, $_POST['F_Name'], $_POST['M_Name'], $_POST['L_Name'], $_POST['Email'], $_POST['Phone'], $_POST['Phone'], $_POST['School_Name'], $_POST['Grade'], $_POST['Age'], $_POST['Relation_Name'], $_POST['Parent_Name'], $_POST['Parent_Phone']);
                $email->SendStudentVerificationEmail($_POST['Email'],$_POST['F_Name'] . " " . $_POST['M_Name'] . " " . $_POST['L_Name'], $center->GetStudentID($conn, $_POST['Email']));
                $fail = time_table_handle($center, $conn);
                if($fail){
                    header("Location: ../Views/PHP/Center_Add_Student.php?Time-Interferes234");
                }else{
                    header("Location: ../Views/PHP/Center_Student_List.php");
                }
            }else{
                header("Location: ../Views/PHP/Center_Add_Student.php?Email-Exist");
            }
        }else{
            header("Location: ../Views/PHP/Center_Add_Student.php?Missing-Data");
        }
    }else if(isset($_POST['Edit_Student'])){
        if($_POST['Old_Email'] != $_POST['Email']){
            if(!$center->CheckEmailExist($conn, $_POST['Email'])){
                $center->EditStudent($conn, $_POST['F_Name'], $_POST['M_Name'], $_POST['L_Name'], $_POST['Email'], $_POST['Phone'], $_POST['School_Name'], $_POST['Grade'], $_POST['Age'], $_POST['Relation_Name'], $_POST['Parent_Name'], $_POST['Parent_Phone'], $_POST['Student_ID']);
                $center->DropStudentTimeTable($conn, $_POST['Student_ID']);
                $fail = false;
                $fail = time_table_handle($center, $conn);
                $center->CancelStudentVerify($conn, $_POST['Student_ID']);
                $email->SendStudentVerificationEmail($_POST['Email'],$_POST['F_Name'] . " " . $_POST['M_Name'] . " " . $_POST['L_Name'], $_POST['Student_ID']);
                if($fail){
                    header("Location: ../Views/PHP/Center_Add_Student.php?Time-Interferes999");
                }else{
                    header("Location: ../Views/PHP/Center_Student_List.php");
                }
            }else{
                header("Location: ../Views/PHP/Center_Student_List.php?Email-Exist");
            }
        }else{
            $center->EditStudent($conn, $_POST['F_Name'], $_POST['M_Name'], $_POST['L_Name'], $_POST['Email'], $_POST['Phone'], $_POST['School_Name'], $_POST['Grade'], $_POST['Age'], $_POST['Relation_Name'], $_POST['Parent_Name'], $_POST['Parent_Phone'], $_POST['Student_ID']);
            $center->DropStudentTimeTable($conn, $_POST['Student_ID']);
            $fail = false;
            $fail = time_table_handle($center, $conn);
            if($fail){
                header("Location: ../Views/PHP/Center_Add_Student.php?Time-Interferes111");
            }else{
                header("Location: ../Views/PHP/Center_Student_List.php");
            }
        }
    }else if(isset($_POST['Submit_Request'])) {
        if(isset($_POST['Course'])){
            if(!$center->CheckEmailExist($conn, $_POST['Email'])){
                $fail = false;
                $center->AddStudent($conn, $_POST['F_Name'], $_POST['M_Name'], $_POST['L_Name'], $_POST['Email'], $_POST['Phone'], $_POST['Phone'], $_POST['School_Name'], $_POST['Grade'], $_POST['Age'], $_POST['Relation_Name'], $_POST['Parent_Name'], $_POST['Parent_Phone']);
                $email->SendStudentVerificationEmail($_POST['Email'],$_POST['F_Name'] . " " . $_POST['M_Name'] . " " . $_POST['L_Name'], $center->GetStudentID($conn, $_POST['Email']));
                $center->deleteRequest($conn, $_POST['Student_ID']);
                $fail = time_table_handle($center, $conn);
                if($fail){
                    header("Location: ../Views/PHP/Center_Add_Student.php?Time-Interferes234");
                }else{
                    header("Location: ../Views/PHP/Center_Student_List.php");
                }
            }else{
                header("Location: ../Views/PHP/Center_Add_Student.php?Email-Exist");
            }
        }else{
            header("Location: ../Views/PHP/Center_Add_Student.php?Missing-Data");
        }
    }else{
        header("Location: ../Views/PHP/Center_Add_Student.php");
    }
}else{
    header("Location: ../Views/PHP/Center_Add_Student.php");
}