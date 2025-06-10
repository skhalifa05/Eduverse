<?php

class Doctor
{
    /**
     * @var String
     */
    /**
     * @var String
     */
    /**
     * @var String
     */
    /**
     * @var String
     */
    /**
     * @var String
     */
    private String $Name,$Password,$Email,$Phone,$Subject;
    /**
     * @var array
     */
    /**
     * @var array
     */
    private array $School_Names,$Grades;
    /**
     * @var int
     */
    private int $ID;

    /**
     * @param String $Name
     * @param String $Password
     * @param String $Email
     * @param String $Phone
     * @param String $Subject
     * @param array $School_Names
     * @param array $Grades
     * @param int $ID
     */
    public function __construct(string $Name, string $Password, string $Email, string $Phone, string $Subject, array $School_Names, array $Grades, int $ID)
    {
        $this->setName($Name);
        $this->setPassword($Password);
        $this->setEmail($Email);
        $this->setPhone($Phone);
        $this->setSchoolNames($School_Names);
        $this->setID($ID);
        $this->setGrades($Grades);
        $this->setSubject($Subject);
    }

    /**
     * @return String
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param String $Name
     */
    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    /**
     * @return String
     */
    public function getPassword(): string
    {
        return $this->Password;
    }

    /**
     * @param String $Password
     */
    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
    }

    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @param String $Email
     */
    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @return String
     */
    public function getPhone(): string
    {
        return $this->Phone;
    }

    /**
     * @param String $Phone
     */
    public function setPhone(string $Phone): void
    {
        $this->Phone = $Phone;
    }

    /**
     * @return String
     */
    public function getSubject(): string
    {
        return $this->Subject;
    }

    /**
     * @param String $Subject
     */
    public function setSubject(string $Subject): void
    {
        $this->Subject = $Subject;
    }

    /**
     * @return array
     */
    public function getSchoolNames(): array
    {
        return $this->School_Names;
    }

    /**
     * @param array $School_Names
     */
    public function setSchoolNames(array $School_Names): void
    {
        $this->School_Names = $School_Names;
    }

    /**
     * @return array
     */
    public function getGrades(): array
    {
        return $this->Grades;
    }

    /**
     * @param array $Grades
     */
    public function setGrades(array $Grades): void
    {
        $this->Grades = $Grades;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @param int $ID
     */
    public function setID(int $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @param mysqli $conn
     * @param String $time
     * @param String $day
     * @return array|bool
     */
    public function GetCourseNameByTime(mysqli $conn, String $time, String $day):array|bool
    {
        $stmt = $conn->prepare("SELECT courses.Name,course_time.Period FROM course_time 
            LEFT JOIN courses ON course_time.Course_ID = courses.Course_ID
            LEFT JOIN doctor ON courses.Admin_ID = doctor.Admin_ID
            WHERE doctor.Admin_ID = ? AND course_time.Time = ? AND course_time.Day = ?");
        $id = $this->getID();
        $stmt->bind_param("iss", $id, $time, $day);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function ReturnAllLectures(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT lectures.Lecture_ID, lectures.Name AS L_Name, course_time.Day, course_time.Time, course_time.Period, courses.Name AS C_Name FROM lectures
            LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
            LEFT JOIN courses ON course_time.Course_ID = courses.Course_ID
            WHERE courses.Admin_ID = ? AND lectures.State = 'FINISHED';");
        $id = $this->getID();
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     * @return mysqli_result
     */
    public function GetUserCountsForLecture(mysqli $conn, int $lecture_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT COUNT(attendance_list.User_ID) AS Counter, attendance_list.State FROM attendance_list
            WHERE attendance_list.Lecture_ID = ?
            GROUP BY attendance_list.State;");
        $stmt->bind_param("i", $lecture_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     * @return mysqli_result
     */
    public function GetAttendanceListForLectureByID(mysqli $conn, int $lecture_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT attendance_list.State, attendance_list.Arrival_Time, student.F_Name, student.M_Name, student.L_Name, lectures.Name AS L_NAme, courses.Name AS C_Name,lectures.Lecture_ID, student.Student_ID FROM attendance_list
            LEFT JOIN student ON student.Student_ID = attendance_list.User_ID
            LEFT JOIN lectures ON lectures.Lecture_ID = attendance_list.Lecture_ID
            LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE attendance_list.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param String $old
     * @param String $new
     * @return int
     */
    public function UpdatePassword(mysqli $conn, String $old, String $new):int
    {
        if($old == $this->getPassword()){
            $stmt = $conn->prepare("UPDATE doctor SET doctor.Password = ? WHERE doctor.Admin_ID = ?");
            $id = $this->getID();
            $stmt->bind_param("si", $new, $id);
            $stmt->execute();
            $this->setPassword($new);
            return 200;
        }else{
            return 400;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     * @param int $student_id
     */
    public function ChangeFromAttendToAbsent(mysqli $conn, int $lecture_id, int $student_id)
    {
        $stmt = $conn->prepare("UPDATE attendance_list SET attendance_list.State = 'ABSENT',attendance_list.Arrival_Time = NULL WHERE attendance_list.Lecture_ID = ? AND attendance_list.User_ID = ?");
        $stmt->bind_param("ii", $lecture_id, $student_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     * @param int $student_id
     */
    public function ChangeFromAbsentToAttend(mysqli $conn, int $lecture_id, int $student_id)
    {
        $stmt = $conn->prepare("UPDATE attendance_list SET attendance_list.State = 'ATTENDED',attendance_list.Arrival_Time = NULL WHERE attendance_list.Lecture_ID = ? AND attendance_list.User_ID = ?");
        $stmt->bind_param("ii", $lecture_id, $student_id);
        $stmt->execute();
    }
}
