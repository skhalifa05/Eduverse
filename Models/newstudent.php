<?php

class Newstudent{
    public function ReturnCourses(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT * FROM courses");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function GetDoctorName(mysqli $conn, int $course_id):String
    {
        $stmt = $conn->prepare("SELECT doctor.F_Name,doctor.L_Name, doctor.M_Name FROM courses
            LEFT JOIN doctor ON doctor.Admin_ID = courses.Admin_ID
            WHERE courses.Course_ID = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $stmt = $stmt->fetch_assoc();
        return $stmt['F_Name'] . " " . $stmt['M_Name'] . " " . $stmt['L_Name'];
    }

    public function checkcourseconflict(mysqli $conn, String $day, String $start_time, String $end_time, int $course2):bool
    {
        $stmt = $conn->prepare("SELECT course_time.Course_ID FROM course_time
            WHERE course_time.Day = ? AND
            ((? >= course_time.Time AND ? < ADDTIME(course_time.Period, course_time.Time))
            OR (? > course_time.Time AND ? <= ADDTIME(course_time.Period, course_time.Time)))
            AND course_time.Course_Time_ID IN (SELECT course_time.Course_Time_ID FROM course_time WHERE course_time.Course_ID = ?);");
        $stmt->bind_param("sssssi", $day, $start_time, $start_time, $end_time, $end_time, $course2);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return true;
        }else{
            return false;
        }
    }

    public function GetCourseTimeInfo(mysqli $conn, int $courseID):array
    {
        $stmt = $conn->prepare("SELECT course_time.Day,course_time.Time,course_time.Period FROM course_time WHERE course_time.Course_ID = ?");
        $stmt->bind_param("i", $courseID);
        $stmt->execute();
        $stmt = $stmt->get_result();
        return $stmt->fetch_assoc();
    }
}