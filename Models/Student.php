<?php

class Student
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
    /**
     * @var String
     */
    /**
     * @var String
     */
    private String $Name,$Password,$Email,$Phone,$School_Name,$Relation_Name,$Parent_Name,$Relation_Phone;

    /**
     * @return String
     */
    public function getParentName(): string
    {
        return $this->Parent_Name;
    }

    /**
     * @param String $Parent_Name
     */
    public function setParentName(string $Parent_Name): void
    {
        $this->Parent_Name = $Parent_Name;
    }
    /**
     * @var int
     */
    /**
     * @var int
     */
    /**
     * @var int
     */
    private int $ID,$Grade,$Age;

    /**
     * @param String $Name
     * @param String $Password
     * @param String $Email
     * @param String $Phone
     * @param String $School_Name
     * @param String $Relation_Name
     * @param String $Parent_Name
     * @param String $Relation_Phone
     * @param int $ID
     * @param int $Grade
     * @param int $Age
     */
    public function __construct(string $Name, string $Password, string $Email, string $Phone, string $School_Name, string $Relation_Name, String $Parent_Name, string $Relation_Phone, int $ID, int $Grade, int $Age)
    {
        $this->setName($Name);
        $this->setPassword($Password);
        $this->setEmail($Email);
        $this->setPhone($Phone);
        $this->setSchoolName($School_Name);
        $this->setRelationName($Relation_Name);
        $this->setRelationPhone($Relation_Phone);
        $this->setID($ID);
        $this->setGrade($Grade);
        $this->setAge($Age);
        $this->setParentName($Parent_Name);
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
    public function getSchoolName(): string
    {
        return $this->School_Name;
    }

    /**
     * @param String $School_Name
     */
    public function setSchoolName(string $School_Name): void
    {
        $this->School_Name = $School_Name;
    }

    /**
     * @return String
     */
    public function getRelationName(): string
    {
        return $this->Relation_Name;
    }

    /**
     * @param String $Relation_Name
     */
    public function setRelationName(string $Relation_Name): void
    {
        $this->Relation_Name = $Relation_Name;
    }

    /**
     * @return String
     */
    public function getRelationPhone(): string
    {
        return $this->Relation_Phone;
    }

    /**
     * @param String $Relation_Phone
     */
    public function setRelationPhone(string $Relation_Phone): void
    {
        $this->Relation_Phone = $Relation_Phone;
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
     * @return int
     */
    public function getGrade(): int
    {
        return $this->Grade;
    }

    /**
     * @param int $Grade
     */
    public function setGrade(int $Grade): void
    {
        $this->Grade = $Grade;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->Age;
    }

    /**
     * @param int $Age
     */
    public function setAge(int $Age): void
    {
        $this->Age = $Age;
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
            $stmt = $conn->prepare("UPDATE student SET student.Password = ? WHERE student.Student_ID = ?");
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
     * @param String $time
     * @param String $day
     * @return array|bool
     */
    public function GetCourseNameByTime(mysqli $conn, String $time, String $day):array|bool
    {
        $stmt = $conn->prepare("SELECT courses.Name,course_time.Period FROM time_table 
            LEFT JOIN course_time ON course_time.Course_Time_ID = time_table.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE time_table.User_ID = ? AND course_time.Time = ? AND course_time.Day = ? AND courses.stat = '1'");
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
    public function  ReturnAllCoursesName(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT DISTINCT courses.Course_ID,courses.Name FROM time_table
            LEFT JOIN course_time ON course_time.Course_Time_ID = time_table.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID WHERE time_table.User_ID = ?;");
        $id = $this->getID();
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @return mysqli_result
     */
    public function GetAttendLectureCount(mysqli $conn, int $course_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT COUNT(attendance_list.User_ID) AS Counter, attendance_list.State FROM attendance_list
            LEFT JOIN lectures ON attendance_list.Lecture_ID = lectures.Lecture_ID
            LEFT JOIN course_time ct ON lectures.Course_Time_ID = ct.Course_Time_ID 
            LEFT JOIN courses c ON c.Course_ID = ct.Course_ID
            WHERE attendance_list.User_ID = ? AND c.Course_ID = ?
            GROUP BY attendance_list.State;");
        $id = $this->getID();
        $stmt->bind_param("ii", $id, $course_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @return mysqli_result
     */

    public function  ReturnAllCoursesLecture(mysqli $conn, int $course_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT lectures.Name, ct.Day, ct.Time, attendance_list.State,attendance_list.Arrival_Time FROM attendance_list
            LEFT JOIN lectures ON attendance_list.Lecture_ID = lectures.Lecture_ID
            LEFT JOIN course_time ct ON lectures.Course_Time_ID = ct.Course_Time_ID 
            LEFT JOIN courses c ON c.Course_ID = ct.Course_ID
            WHERE attendance_list.User_ID = ? AND c.Course_ID = ?;");
        $id = $this->getID();
        $stmt->bind_param("ii", $id, $course_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}