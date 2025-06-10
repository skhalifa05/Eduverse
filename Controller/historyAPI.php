<?php
require_once "../Models/User.php";
require_once "../Models/Student.php";
require_once "../Models/Center.php";
require_once "../Models/Doctor.php";
require_once "../DB/attendance_db.php";

$user = new User();

session_start();
if (isset($conn)) {
    $stmt = $conn->prepare("SELECT courses.Course_ID,courses.Name FROM time_table
            LEFT JOIN course_time ON course_time.Course_Time_ID = time_table.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID WHERE time_table.User_ID = ?;");
    $encodedData = file_get_contents('php://input');
    $decodedData = json_decode($encodedData, true);
    $id = $decodedData['ID'];
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $courses = $stmt->get_result();
    while($primary_row = $courses->fetch_assoc()) {
        $course_id = $primary_row['Course_ID'];
        $stmt = $conn->prepare("SELECT COUNT(attendance_list.User_ID) AS Counter, attendance_list.State FROM attendance_list
            LEFT JOIN lectures ON attendance_list.Lecture_ID = lectures.Lecture_ID
            LEFT JOIN course_time ct ON lectures.Course_Time_ID = ct.Course_Time_ID 
            LEFT JOIN courses c ON c.Course_ID = ct.Course_ID
            WHERE attendance_list.User_ID = ? AND c.Course_ID = ?
            GROUP BY attendance_list.State;");
        $stmt->bind_param("ii", $id, $course_id);
        $stmt->execute();
        $attendance_data = $stmt->get_result();
        if($attendance_data->num_rows == 1){
            $row_attendance = $attendance_data->fetch_assoc();
            if($row_attendance['State'] == "ATTENDED"){
                $attended = $row_attendance['Counter'];
                $absent = 0;
            }else{
                $absent = $row_attendance['Counter'];
                $attended = 0;
            }
        }else if($attendance_data->num_rows == 0){
            $absent=0;
            $attended=0;
        }else if($attendance_data->num_rows == 2){
            while($row_attendance = $attendance_data->fetch_assoc()){
                if($row_attendance['State'] == "ABSENT"){
                    $absent = $row_attendance['Counter'];
                }else if($row_attendance['State'] == "ATTENDED"){
                    $attended = $row_attendance['Counter'];
                }
            }
        }
        $response[] = array("Courses" => $primary_row['Name'],"ATT"=>$attended,"ABS"=>$absent);
    }
    echo(json_encode($response));
}else{
    echo ("bye");
}