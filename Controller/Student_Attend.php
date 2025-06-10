<?php


require_once "../DB/attendance_db.php";
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
    $email = new Email("CodeologyEdu@brightside-edu.com", "Codeology Education", "Codeologyedu@2022");
    if(isset($_GET['Student_attend'])){
        $data = $center->GetAllStartedLectures($conn);
        if($center->CheckUserByID($conn, $_GET['user_id'])){
            $student_data = $center->GetStudentData($conn, $_GET['user_id']);
            if($student_data['Verify']){
                $lecture_found = false;
                $i=0;
                while($lectures_data = $data->fetch_assoc()){
                    $i++;
                    if($center->CheckUserEnrollByLectureID($conn, $_GET['user_id'], $lectures_data['Lecture_ID'])){
                        if(!$center->CheckIfUserAttend($conn, $_GET['user_id'], $lectures_data['Lecture_ID'])){
                            date_default_timezone_set('Africa/Cairo');
                            $arrival_time = date("H:i:s");
                            $center->AttendUser($conn, $_GET['user_id'], $lectures_data['Lecture_ID'], $arrival_time);
                            $course_name = $center->CourseNameByLectureID($conn, $lectures_data['Lecture_ID']);
                            $lecture_found = true;
                            $lecture_name_data = $center->CourseNameAndLectureName($conn, $lectures_data['Lecture_ID']);
                            $email->StudentAttendNotification($lecture_name_data['Lecture_Name'], $lecture_name_data['Course_Name'], $lecture_name_data['Time'], $student_data['F_Name'] . " " . $student_data['M_Name'] . " " . $student_data['L_Name'], $student_data['Email'], $arrival_time);
                            header("Location: ../Views/PHP/dashboard.php?success&" . $course_name . " " . $lectures_data['Name']);
                        }else{
                            $lecture_found = true;
                            header("Location: ../Views/PHP/dashboard.php?User_State_Taken");
                        }
                    }
                }
                if(!$lecture_found){
                    if($i == 0){
                        header("Location: ../Views/PHP/dashboard.php?No_Active_Lecture");
                    }else{
                        header("Location: ../Views/PHP/dashboard.php?User_Not_Enrolled");
                    }
                }
            }else{
                header("Location: ../Views/PHP/dashboard.php?User-Not-Authorized");
            }
        }else{
            header("Location: ../Views/PHP/dashboard.php?User_ID_Not_Found");
        }
    }else{
        header("Location: ../Views/PHP/dashboard.php");
    }
}else {
    header("Location: ../Views/PHP/dashboard.php");
}