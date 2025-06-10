<?php

class User{
    /**
     * @var array
     */
    /**
     * @var array
     */
    /**
     * @var array
     */
    private array $Student_Array, $Center_Array, $Admin_Array;

    /**
     * @return array
     */
    public function getStudentArray(): array
    {
        return $this->Student_Array;
    }

    /**
     * @param array $Student_Array
     */
    public function setStudentArray(array $Student_Array): void
    {
        $this->Student_Array = $Student_Array;
    }

    /**
     * @return array
     */
    public function getCenterArray(): array
    {
        return $this->Center_Array;
    }

    /**
     * @param array $Center_Array
     */
    public function setCenterArray(array $Center_Array): void
    {
        $this->Center_Array = $Center_Array;
    }

    /**
     * @return array
     */
    public function getAdminArray(): array
    {
        return $this->Admin_Array;
    }

    /**
     * @param array $Admin_Array
     */
    public function setAdminArray(array $Admin_Array): void
    {
        $this->Admin_Array = $Admin_Array;
    }
    /**
     * @param mysqli $conn
     * @param String $email
     * @param String $pass
     * @return int
     */
    function Login(mysqli $conn, String $email, String $pass): int
    {
        if($email != "" && $pass != ""){
            if($this->CheckInCenterTable($conn, $email, $pass)){
                return 200;
            }else{
                if($this->CheckInAdminTable($conn, $email, $pass)){
                    return 201;
                }else{
                    if($this->CheckInStudentTable($conn, $email, $pass)){
                        return 202;
                    }else{
                        return 400;
                    }
                }
            }
        }else{
            return 401;
        }
    }

    /**
     * @param mysqli $conn
     * @param String $email
     * @param String $pass
     * @return bool
     */
    private function CheckInStudentTable(mysqli $conn, String $email, String $pass):bool
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE student.Email = ? && student.Password = ?");
        $stmt->bind_param("ss", $email,$pass);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows == 1){
            $this->setStudentArray($results->fetch_assoc());
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param String $email
     * @param String $pass
     * @return bool
     */
    private function CheckInAdminTable(mysqli $conn, String $email, String $pass):bool
    {
        $stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor.Email = ? && doctor.Password = ?");
        $stmt->bind_param("ss", $email,$pass);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows == 1){
            $this->setAdminArray($results->fetch_assoc());
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param String $email
     * @param String $pass
     * @return bool
     */
    private function CheckInCenterTable(mysqli $conn, String $email, String $pass):bool
    {
        $stmt = $conn->prepare("SELECT * FROM center WHERE center.Email = ? && center.Password = ?");
        $stmt->bind_param("ss", $email,$pass);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows == 1){
            $this->setCenterArray($results->fetch_assoc());
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $admin_id
     * @return array
     */
    public function GetAllSchoolForDoctor(mysqli $conn, int $admin_id):array
    {
        $stmt = $conn->prepare("SELECT doctor_teaching_school.School_Name FROM doctor_teaching_school WHERE doctor_teaching_school.Doctor_ID = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $results = $stmt->get_result();
        $school_array = array();
        while($data = $results->fetch_assoc()){
            array_push($school_array, $data);
        }
        return $school_array;
    }

    /**
     * @param mysqli $conn
     * @param int $admin_id
     * @return array
     */
    public function GetAllGradesForDoctor(mysqli $conn, int $admin_id):array
    {
        $stmt = $conn->prepare("SELECT doctor_teaching_grades.Grade FROM doctor_teaching_grades WHERE doctor_teaching_grades.Doctor_ID = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $results = $stmt->get_result();
        $grade_array = array();
        while($data = $results->fetch_assoc()){
            array_push($grade_array, $data);
        }
        return $grade_array;
    }

    /**
     * @param mysqli $conn
     * @param $email
     * @return bool
     */
    public function CheckStudentEmailExist(mysqli $conn, $email):bool
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE student.Email = ?;");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @param mysqli $conn
     * @param $email
     * @return bool
     */
    public function CheckRequestEmailExist(mysqli $conn, $email):bool
    {
        $stmt = $conn->prepare("SELECT * FROM requests WHERE requests.Email = ?;");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param String $f_name
     * @param String $m_name
     * @param String $l_name
     * @param String $email
     * @param String $password
     * @param String $Phone
     * @param String $school_name
     * @param int $grade
     * @param int $age
     * @param String $relation_name
     * @param String $parent_name
     * @param String $relation_phone
     */
    public function AddStudent(mysqli $conn, String $f_name, String $m_name, String $l_name, String $email, String $password, String $Phone, String $school_name, int $grade, int $age, String $relation_name, String $parent_name, String $relation_phone, String $course)
    {
        $stmt = $conn->prepare("INSERT INTO requests (F_Name, M_Name, L_Name, Email, Password, Phone, School_Name, Grade, Age, Relation_Name, Parent_Name, Relation_Phone, Course) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssiissss", $f_name, $m_name, $l_name, $email, $password, $Phone, $school_name, $grade, $age, $relation_name, $parent_name, $relation_phone, $course);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param String $email
     * @return int
     */
    public function GetStudentID(mysqli $conn, String $email):int
    {
        $stmt = $conn->prepare("SELECT requests.Student_ID FROM requests WHERE  requests.Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();
        return $results['Student_ID'];
    }
}