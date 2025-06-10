<?php

class Reader
{
    /**
     * @param mysqli $conn
     * @param String $device_id
     * @param String $device_name
     */
    public function AddReader(mysqli $conn, String $device_id, String $device_name)
    {
        if($this->CheckReaderExist($conn, $device_id)){
            $stmt = $conn->prepare("INSERT INTO available_devices (Device_Number, Device_Name) VALUES ( ?, ?)");
            $stmt->bind_param("ss", $device_id, $device_name);
            $stmt->execute();
        }
    }

    /**
     * @param mysqli $conn
     * @param String $device_id
     */
    public function RemoveReader(mysqli $conn, String $device_id)
    {
        $stmt = $conn->prepare("DELETE FROM available_devices 
            WHERE available_devices.Device_Number = ?;");
        $stmt->bind_param("s", $device_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param String $device_id
     * @return bool
     */
    public function CheckReaderExist(mysqli $conn, String $device_id):bool
    {
        $stmt = $conn->prepare("SELECT available_devices.Device_Number 
            FROM available_devices
            WHERE available_devices.Device_Number = ?");
        $stmt->bind_param("s", $device_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $Lecture_ID
     * @param int $User_ID
     * @param String $Arrival_Time
     * @return bool
     */

    public function Attend_Lecture(mysqli $conn, int $Lecture_ID, int $User_ID, String $Arrival_Time):bool
    {
        if($this->CheckUserEnroll($conn, $User_ID, $Lecture_ID)){
            $stmt = $conn->prepare("INSERT INTO attendance_list 
            (attendance_list.User_ID,attendance_list.Lecture_ID,attendance_list.State,attendance_list.Arrival_Time) 
            VALUES (?,?,'attended',?);");
            $stmt->bind_param("iis",$User_ID,$Lecture_ID,$Arrival_Time);
            $stmt->execute();
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $conn
     * @param $user_id
     * @param $lecture_id
     * @return bool
     */
    public function CheckUserEnroll($conn, $user_id, $lecture_id):bool
    {
        $stmt = $conn->prepare("SELECT student.Student_ID FROM time_table
            LEFT JOIN course_time ON time_table.Course_Time_ID = course_time.Course_Time_ID
            LEFT JOIN student ON student.Student_ID = time_table.User_ID
            LEFT JOIN lectures ON course_time.Course_Time_ID = lectures.Course_Time_ID
            WHERE lectures.Lecture_ID = ? AND student.Student_ID = ?");
        $stmt->bind_param("ii", $lecture_id, $user_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows == 1) {
            return true;
        }else{
            return false;
        }
    }
}