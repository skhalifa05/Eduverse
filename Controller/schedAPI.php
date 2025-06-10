<?php
require_once "../Models/User.php";
require_once "../Models/Student.php";
require_once "../Models/Center.php";
require_once "../Models/Doctor.php";
require_once "../DB/attendance_db.php";

$user = new User();

session_start();
if (isset($conn)) {
    $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Period, course_time.Time, course_time.Day FROM time_table 
            LEFT JOIN course_time ON course_time.Course_Time_ID = time_table.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE time_table.User_ID = ? AND courses.stat = '1'");
    $encodedData = file_get_contents('php://input');
    $decodedData = json_decode($encodedData, true);
    $id = $decodedData['ID'];
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($dd = $result->fetch_assoc()) {
        $response[] = array("Course" => $dd['Name'],"Time"=>$dd['Time'],"Day"=>$dd['Day'],"Dur"=>$dd['Period'],"ID"=>$dd['Course_ID']);

        }
    }else{
        echo "None";
    }
}else{
echo "bye";
}
echo(json_encode($response));