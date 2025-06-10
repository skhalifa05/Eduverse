<?php

/**
 *
 */
class Center
{

    /**
     * @var String
     */
    private String $Name,$Type;

    /**
     * @return String
     */
    public function getType(): string
    {
        return $this->Type;
    }

    /**
     * @param String $Type
     */
    public function setType(string $Type): void
    {
        $this->Type = $Type;
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
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function ReturnAllLecturesNotFinished(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT courses.Name AS Course_Name,
            lectures.Lecture_ID,lectures.Name AS Lecture_Name,lectures.State,
            doctor.F_Name,doctor.L_Name, doctor.M_Name,
            course_time.Time,course_time.Period 
            FROM lectures
            LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            LEFT JOIN doctor ON doctor.Admin_ID = courses.Admin_ID
            WHERE lectures.State != 'FINISHED' and lectures.State != 'Cancelled'");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     * @return int
     */
    public function GetStudentCount(mysqli $conn, int $lecture_id):int
    {
        $stmt = $conn->prepare("SELECT COUNT(attendance_list.User_ID) AS Students_Count 
            FROM attendance_list 
            WHERE attendance_list.Lecture_ID = ? AND  attendance_list.State = 'ATTENDED'
            GROUP BY attendance_list.Lecture_ID ");
        $stmt->bind_param("i",$lecture_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return 0;
        }else{
            $data = $stmt->fetch_assoc();
            return $data['Students_Count'];
        }
    }



    /**
     * @param mysqli $conn
     * @param String $Day
     * @return mysqli_result
     */
    public function GetAvailableCoursesToLectures(mysqli $conn, String $Day):mysqli_result
    {
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE course_time.Day = ? and courses.stat = '1'
            AND courses.Course_ID NOT IN (SELECT courses.Course_ID FROM lectures
                 LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
                 LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
                 WHERE lectures.State != 'FINISHED' and lectures.State != 'Cancelled');");
        $stmt->bind_param("s",$Day);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param String $Day
     * @return mysqli_result
     */
    public function GetAvailableCoursesToLecturestwo(mysqli $conn, String $Day):mysqli_result
    {
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE course_time.Day = ? and courses.stat = '1'
            ");
        $stmt->bind_param("s",$Day);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function GetAvailableCoursesToLectureslist(mysqli $conn, String $Day):array
    {
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE course_time.Day = ? and courses.stat = '1'
            ");
        $stmt->bind_param("s",$Day);
        $stmt->execute();
        $data = $stmt->get_result();
        $a=array();
        while($row = $data->fetch_assoc()){
            array_push($a,$row['Name']);
        }
        return $a;
    }

    /**
     * @param mysqli $conn
     * @param string $day
     * @return int
     */
    public function dayStu(mysqli $conn, string $day):int
    {
        $count = 0;
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE course_time.Day = ? and courses.stat = '1'
            ");
        $stmt->bind_param("s",$day);
        $stmt->execute();
        $daycourses = $stmt->get_result();
        while($row = $daycourses->fetch_assoc()){
            $stmt = $conn->prepare("SELECT COUNT(time_table.User_ID) AS Enroll_Count FROM courses
                LEFT JOIN course_time ON course_time.Course_ID = courses.Course_ID
                LEFT JOIN time_table ON course_time.Course_Time_ID = time_table.Course_Time_ID
                WHERE courses.Course_ID = ?
                GROUP BY courses.Course_ID;");
            $stmt->bind_param("i", $row['Course_ID']);
            $stmt->execute();
            $stmt = $stmt->get_result();
            if($stmt->num_rows === 0){
                $numb = 0;
            }else{
                $data = $stmt->fetch_assoc();
                $numb = $data['Enroll_Count'];
            }
            $count = $count + $numb;
        }
        return $count;
    }

    /**
     * @param mysqli $conn
     * @param string $day
     * @return int
     */
    public function expect(mysqli $conn, string $day):int
    {
        $students = 0;
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE course_time.Day = ? and courses.stat = '1'
            ");
        $stmt->bind_param("s",$day);
        $stmt->execute();
        $Courses = $stmt->get_result();
        while($row = $Courses->fetch_assoc()){
            $stmt = $conn->prepare("SELECT COUNT(time_table.User_ID) AS Enroll_Count FROM courses
            LEFT JOIN course_time ON course_time.Course_ID = courses.Course_ID
            LEFT JOIN time_table ON course_time.Course_Time_ID = time_table.Course_Time_ID
            WHERE courses.Course_ID = ?
            GROUP BY courses.Course_ID;");
            $stmt->bind_param("i", $row['Course_ID']);
            $stmt->execute();
            $stmt = $stmt->get_result();
            if($stmt->num_rows === 0){
                $numb = 0;
            }else{
                $data = $stmt->fetch_assoc();
                $numb = $data['Enroll_Count'];
            }
            $students = $students + $numb;
        }
        return $students;
    }

    /**
     * @param mysqli $conn
     * @param string $day
     * @return int
     */
    public function sessionnumber(mysqli $conn, string $day):int
    {
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE course_time.Day = ? and courses.stat = '1'
            ");
        $stmt->bind_param("s",$day);
        $stmt->execute();
        $Courses = $stmt->get_result();
        $courseCount = mysqli_num_rows($Courses);
        return $courseCount;
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function GetAvailableDevices(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT available_devices.Device_ID,available_devices.Device_Number,available_devices.Device_Name 
            FROM available_devices
            WHERE available_devices.Device_ID NOT IN (SELECT lectures.Device_Reader FROM lectures WHERE lectures.State != 'FINISHED');");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $course_time_id
     * @param int $device_id
     * @param String $lecture_name
     * @param String $State
     */
    public function AddLecture(mysqli $conn, int $course_time_id, int $device_id, String $lecture_name, String $State)
    {
        if($device_id == "-1"){
            $stmt = $conn->prepare("INSERT INTO lectures (lectures.Course_Time_ID, lectures.Device_Reader, lectures.Name, lectures.State) 
            VALUES (?, NULL, ?, ?)");
            $stmt->bind_param("iss",$course_time_id,$lecture_name,$State);
        }else{
            $stmt = $conn->prepare("INSERT INTO lectures (lectures.Course_Time_ID, lectures.Device_Reader, lectures.Name, lectures.State) 
            VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss",$course_time_id,$device_id,$lecture_name,$State);
        }
        $stmt->execute();

    }

    /**
     * @param mysqli $conn
     * @param int $device_id
     * @return int
     */
    public function getLectureID_ByReaderID(mysqli $conn, int $device_id):int
    {
        $stmt = $conn->prepare("SELECT lectures.Lecture_ID FROM lectures
            LEFT JOIN available_devices ON available_devices.Device_ID = lectures.Device_Reader
            WHERE available_devices.Device_Number = ?");
        $stmt->bind_param("s", $device_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $stmt = $stmt->fetch_assoc();
        return $stmt['Lecture_ID'];
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_ID
     */
    public function FinishLecture(mysqli $conn, int $lecture_ID)
    {
        $stmt = $conn->prepare("UPDATE lectures SET lectures.State = 'FINISHED' WHERE lectures.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_ID);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_ID
     */
    public function CancelLect(mysqli $conn, int $lecture_ID)
    {
        $stmt = $conn->prepare("UPDATE lectures SET lectures.State = 'Cancelled' WHERE lectures.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_ID);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_ID
     */
    public function StartLecture(mysqli $conn, int $lecture_ID)
    {
        $stmt = $conn->prepare("UPDATE lectures SET lectures.State = 'STARTED' WHERE lectures.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_ID);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_ID
     */
    public function RemoveLecture(mysqli $conn, int $lecture_ID)
    {
        $stmt = $conn->prepare("DELETE FROM lectures WHERE lectures.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_ID);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function ReturnCourses(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT * FROM courses");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function ramydata(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT * FROM applicants");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @return String
     */
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

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @return int
     */
    public function GetUsersEnrolledCount(mysqli $conn, int $course_id):int
    {
        $stmt = $conn->prepare("SELECT COUNT(time_table.User_ID) AS Enroll_Count FROM courses
            LEFT JOIN course_time ON course_time.Course_ID = courses.Course_ID
            LEFT JOIN time_table ON course_time.Course_Time_ID = time_table.Course_Time_ID
            WHERE courses.Course_ID = ?
            GROUP BY courses.Course_ID;");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return 0;
        }else{
            $data = $stmt->fetch_assoc();
            return $data['Enroll_Count'];
        }
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     */
    public function DeleteCourse(mysqli $conn, int $course_id)
    {
        $stmt = $conn->prepare("DELETE FROM courses WHERE courses.Course_ID = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $courseID
     * @return void
     */
    public function DisableCourse(mysqli $conn, int $courseID)
    {
        $stmt = $conn->prepare("UPDATE courses SET stat = '0' WHERE courses.Course_ID = ?");
        $stmt->bind_param("i", $courseID);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function GetAllAdmins(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT doctor.Admin_ID,doctor.F_Name,doctor.L_Name, doctor.M_Name FROM doctor");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param String $course_name
     * @param int $admin_id
     */
    public function AddCourse(mysqli $conn, String $course_name, int $admin_id)
    {
        $stmt = $conn->prepare("INSERT INTO courses (Admin_ID, Name) VALUES (?, ?)");
        $stmt->bind_param("is", $admin_id, $course_name);
        $stmt->execute();
    }

    /**
     * @param $conn
     * @return mysqli_result
     */
    public function ReturnAllCourseTime($conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT course_time.Course_Time_ID,course_time.Day,course_time.Time,course_time.Period,
            doctor.F_Name,doctor.L_Name, doctor.M_Name,
            courses.Name,courses.Course_ID FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            LEFT JOIN doctor ON doctor.Admin_ID = courses.Admin_ID");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param String $day
     * @param String $start_time
     * @param String $end_time
     * @param int $course_id
     * @param int $admin_id
     * @return bool
     */
    public function CheckCourseTime(mysqli $conn, String $day, String $start_time, String $end_time, int $course_id, int $admin_id):bool
    {
        $stmt = $conn->prepare("SELECT courses.Course_ID FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            LEFT JOIN doctor ON doctor.Admin_ID = courses.Admin_ID
            WHERE courses.Course_ID = ? AND course_time.Day = ? AND
            ((? >= course_time.Time AND ? < ADDTIME(course_time.Period, course_time.Time))
            OR (? > course_time.Time AND ? <= ADDTIME(course_time.Period, course_time.Time)))
            AND courses.Admin_ID = ? ;");
        $stmt->bind_param("isssssi", $course_id, $day, $start_time, $start_time, $end_time, $end_time, $admin_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $course_time_id
     */
    public function DeleteCourseTime(mysqli $conn, int $course_time_id)
    {
        $stmt = $conn->prepare("DELETE FROM course_time WHERE course_time.Course_Time_ID = ?");
        $stmt->bind_param("i", $course_time_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @param String $day
     * @param String $start_time
     * @param String $period
     */
    public function InsertCourseTime(mysqli $conn, int $course_id, String $day, String $start_time, String $period)
    {
        $stmt = $conn->prepare("INSERT INTO course_time (Course_ID, Day, Time, Period) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $course_id, $day, $start_time, $period);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @param String $day
     * @param String $start_time
     * @param String $period
     * @param int $lecture_id
     */
    public function EditCourseTime(mysqli $conn, int $course_id, String $day, String $start_time, String $period, int $lecture_id)
    {
        $stmt = $conn->prepare("UPDATE course_time SET Course_ID = ?, Day = ?, Time = ? , Period = ? WHERE course_time.Course_Time_ID = ?");
        $stmt->bind_param("isssi", $course_id, $day, $start_time, $period, $lecture_id);
        $stmt->execute();
    }

    /**
     * @param $conn
     * @param $course_time_id
     * @return int
     */
    public function GetEnrolledStudents($conn, $course_time_id):int
    {
        $stmt = $conn->prepare("SELECT COUNT(time_table.User_ID) AS Enroll_Count FROM course_time
            LEFT JOIN time_table ON course_time.Course_Time_ID = time_table.Course_Time_ID
            WHERE course_time.Course_Time_ID = ?
            GROUP BY course_time.Course_Time_ID;");
        $stmt->bind_param("i", $course_time_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return 0;
        }else{
            $data = $stmt->fetch_assoc();
            return $data['Enroll_Count'];
        }
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function ReturnAllLecturesFinished(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT lectures.Lecture_ID, lectures.State, lectures.Name AS L_NAme, courses.Name AS C_Name, doctor.F_Name, doctor.L_Name, doctor.M_Name FROM lectures
            LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
            LEFT JOIN courses ON course_time.Course_ID = courses.Course_ID
            LEFT JOIN doctor ON doctor.Admin_ID = courses.Admin_ID WHERE lectures.State = 'FINISHED' or lectures.State = 'Cancelled'
            ORDER BY lectures.Lecture_ID DESC;");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $courseid
     * @return mysqli_result
     */
    public function GetStudentListForCourseByID(mysqli $conn, int $courseid):mysqli_result
    {
        $stmt = $conn->prepare("SELECT student.Student_ID, student.F_Name, student.L_Name, student.M_Name FROM course_time
            LEFT JOIN time_table ON time_table.Course_Time_ID = course_time.Course_Time_ID
            LEFT JOIN student ON student.Student_ID = time_table.User_ID
            WHERE course_time.Course_ID = ? 
            ORDER BY student.Student_ID");
        $stmt->bind_param("i", $courseid);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $courseid
     * @return mysqli_result
     */
    public function getCNameforVS(mysqli $conn, int $courseid):mysqli_result
    {
        $stmt = $conn->prepare("SELECT Name FROM courses WHERE Course_ID = ?");
        $stmt->bind_param("i", $courseid);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    /**
     * @param mysqli $conn
     * @param int $courseid
     * @return mysqli_result
     */
    public function getCTid(mysqli $conn, int $courseid):mysqli_result
    {
        $stmt = $conn->prepare("SELECT Course_Time_ID FROM course_time WHERE Course_ID = ?");
        $stmt->bind_param("i", $courseid);
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
        $stmt = $conn->prepare("SELECT attendance_list.State, attendance_list.Arrival_Time, student.F_Name, student.L_Name, student.M_Name, lectures.Name AS L_NAme, courses.Name AS C_Name,lectures.Lecture_ID, student.Student_ID FROM attendance_list
            LEFT JOIN student ON student.Student_ID = attendance_list.User_ID
            LEFT JOIN lectures ON lectures.Lecture_ID = attendance_list.Lecture_ID
            LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE attendance_list.Lecture_ID = ?
            ORDER BY attendance_list.Arrival_Time");
        $stmt->bind_param("i", $lecture_id);
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
    public function AddStudent(mysqli $conn, String $f_name, String $m_name, String $l_name, String $email, String $password, String $Phone, String $school_name, int $grade, int $age, String $relation_name, String $parent_name, String $relation_phone)
    {
        $stmt = $conn->prepare("INSERT INTO student (F_Name, M_Name, L_Name, Email, Password, Phone, School_Name, Grade, Age, Relation_Name, Parent_Name, Relation_Phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssiisss", $f_name, $m_name, $l_name, $email, $password, $Phone, $school_name, $grade, $age, $relation_name, $parent_name, $relation_phone);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function GetAllStudents(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT * FROM student");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $student_id
     */
    public function DeleteStudent(mysqli $conn, int $student_id)
    {
        $stmt = $conn->prepare("DELETE FROM student WHERE student.Student_ID = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $student_id
     * @param int $course_id
     * @return void
     */
    public function DropStudent(mysqli $conn, int $student_id, int $course_id)
    {
        $stmt = $conn->prepare("SELECT Course_Time_ID FROM course_time WHERE Course_ID = ?;");
        $stmt->bind_param("i",$course_id);
        $stmt->execute();
        $resultsss = $stmt->get_result();
        $row = $resultsss->fetch_assoc();
        $timeid = $row['Course_Time_ID'];

        $stmt2 = $conn->prepare("DELETE FROM time_table WHERE Course_Time_ID = ? and User_ID = ?;");
        $stmt2->bind_param("ii",$timeid, $student_id);
        $stmt2->execute();

    }

    /**
     * @param mysqli $conn
     * @param $email
     * @return bool
     */
    public function CheckEmailExist(mysqli $conn, $email):bool
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE student.Email = ?;");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows > 0){
            return true;
        }else{
            $stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor.Email = ?;");
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $results = $stmt->get_result();
            if($results->num_rows > 0){
                return true;
            }else{
                $stmt = $conn->prepare("SELECT * FROM center WHERE center.Email = ?;");
                $stmt->bind_param("s",$email);
                $stmt->execute();
                $results = $stmt->get_result();
                if($results->num_rows > 0){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * @param mysqli $conn
     * @param $student_id
     * @return array
     */
    public function GetStudentData(mysqli $conn, $student_id):array
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE student.Student_ID = ?;");
        $stmt->bind_param("i",$student_id);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results->fetch_assoc();
    }

    /**
     * @param mysqli $conn
     * @param String $f_name
     * @param String $m_name
     * @param String $l_name
     * @param String $email
     * @param String $Phone
     * @param String $school_name
     * @param int $grade
     * @param int $age
     * @param String $relation_name
     * @param String $relation_phone
     * @param String $parent_name
     * @param int $student_id
     */
    public function EditStudent(mysqli $conn, String $f_name, String $m_name, String $l_name, String $email, String $Phone, String $school_name, int $grade, int $age, String $relation_name, String $parent_name, String $relation_phone, int $student_id)
    {
        $stmt = $conn->prepare("UPDATE student SET F_Name = ?, M_Name = ?, L_Name = ?, Email = ?, Phone = ?, School_Name = ?, Grade = ?, Age = ?, Relation_Name = ?, Parent_Name = ?, Relation_Phone = ? WHERE student.Student_ID = ?");
        $stmt->bind_param("ssssssiisssi", $f_name, $m_name, $l_name, $email, $Phone, $school_name, $grade, $age, $relation_name, $parent_name, $relation_phone,$student_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param String $f_name
     * @param String $m_name
     * @param String $l_name
     * @param String $email
     * @param String $password
     * @param String $Phone
     * @param String $subject
     */
    public function AddDoctor(mysqli $conn, String $f_name, String $m_name, String $l_name, String $email, String $password, String $Phone, String $subject)
    {
        $stmt = $conn->prepare("INSERT INTO doctor (F_Name, M_Name, L_Name, Email, Password, Phone, Subject)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $f_name, $m_name, $l_name, $email, $password, $Phone, $subject);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function GetAllDocs(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT * FROM doctor");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param $admin_id
     * @return array
     */
    public function GetDoctorData(mysqli $conn, $admin_id):array
    {
        $stmt = $conn->prepare("SELECT * FROM doctor WHERE doctor.Admin_ID = ?;");
        $stmt->bind_param("i",$admin_id);
        $stmt->execute();
        $results = $stmt->get_result();
        return $results->fetch_assoc();
    }

    /**
     * @param mysqli $conn
     * @param int $admin_id
     */
    public function DeleteDoctor(mysqli $conn, int $admin_id)
    {
        $stmt = $conn->prepare("DELETE FROM doctor WHERE doctor.Admin_ID = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param String $email
     * @return int
     */
    public function GetDoctorID(mysqli $conn, String $email):int
    {
        $stmt = $conn->prepare("SELECT doctor.Admin_ID FROM doctor WHERE  doctor.Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();
        return $results['Admin_ID'];
    }

    /**
     * @param mysqli $conn
     * @param int $grade
     * @param int $admin_id
     */
    public function AddGradeToDoctor(mysqli $conn, int $grade, int $admin_id)
    {
        $stmt = $conn->prepare("INSERT INTO doctor_teaching_grades (Grade, Doctor_ID)  VALUES (?, ?); ");
        $stmt->bind_param("ii", $grade, $admin_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param String $school_name
     * @param int $admin_id
     */
    public function AddSchoolNameToDoctor(mysqli $conn, String $school_name, int $admin_id)
    {
        $stmt = $conn->prepare("INSERT INTO doctor_teaching_school (School_Name, Doctor_ID)  VALUES (?, ?); ");
        $stmt->bind_param("si", $school_name, $admin_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function GetAvailableLectures(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time 
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE courses.stat != '0';");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param String $email
     * @return int
     */
    public function GetStudentID(mysqli $conn, String $email):int
    {
        $stmt = $conn->prepare("SELECT student.Student_ID FROM student WHERE  student.Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();
        return $results['Student_ID'];
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @param int $student_id
     * @return bool
     */
    public function CheckIfCourseTaken(mysqli $conn, int $course_id, int $student_id):bool
    {
        $stmt = $conn->prepare("SELECT course_time.Course_ID FROM course_time
            WHERE course_time.Course_ID = ?
            AND course_time.Course_Time_ID IN (SELECT time_table.Course_Time_ID FROM time_table WHERE time_table.User_ID = ?)");
        $stmt->bind_param("ii", $course_id, $student_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param String $day
     * @param String $start_time
     * @param String $end_time
     * @param int $student_id
     * @return bool
     */
    public function CheckIfCourseTime(mysqli $conn, String $day, String $start_time, String $end_time, int $student_id):bool
    {
        $stmt = $conn->prepare("SELECT course_time.Course_ID FROM course_time
            WHERE course_time.Day = ? AND
            ((? >= course_time.Time AND ? < ADDTIME(course_time.Period, course_time.Time))
            OR (? > course_time.Time AND ? <= ADDTIME(course_time.Period, course_time.Time)))
            AND course_time.Course_Time_ID IN (SELECT time_table.Course_Time_ID FROM time_table WHERE time_table.User_ID = ?);");
        $stmt->bind_param("sssssi", $day, $start_time, $start_time, $end_time, $end_time, $student_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows === 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $course_time_id
     * @param int $lecture_id
     * @return mysqli_result
     */
    private function GetAllSTU(mysqli $conn, int $course_time_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT  time_table.User_ID FROM course_time
            LEFT JOIN time_table ON course_time.Course_Time_ID = time_table.Course_Time_ID
            WHERE course_time.Course_Time_ID = ? AND time_table.User_ID ");
        $stmt->bind_param("i", $course_time_id, );
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $course_time_id
     * @return int
     */
    public function GetCourseIdByCourseTimeID(mysqli $conn, int $course_time_id):int
    {
        $stmt = $conn->prepare("SELECT course_time.Course_ID FROM course_time WHERE course_time.Course_Time_ID = ?");
        $stmt->bind_param("i", $course_time_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $stmt = $stmt->fetch_assoc();
        return $stmt['Course_ID'];
    }

    /**
     * @param mysqli $conn
     * @param int $course_time_id
     * @return array
     */
    public function GetCourseTimeInfo(mysqli $conn, int $course_time_id):array
    {
        $stmt = $conn->prepare("SELECT course_time.Day,course_time.Time,course_time.Period FROM course_time WHERE course_time.Course_Time_ID = ?");
        $stmt->bind_param("i", $course_time_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        return $stmt->fetch_assoc();
    }

    /**
     * @param mysqli $conn
     * @param int $user_id
     * @param int $course_time_id
     */
    public function AddCourseToStudent(mysqli $conn, int $user_id, int $course_time_id)
    {
        $stmt = $conn->prepare("INSERT INTO time_table (time_table.Course_Time_ID,time_table.User_ID) VALUES  (?, ?)");
        $stmt->bind_param("ii", $course_time_id, $user_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $user_id
     * @return mysqli_result
     */
    public function GetStudentTimeTable(mysqli $conn, int $user_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT time_table.Course_Time_ID FROM time_table WHERE time_table.User_ID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $user_id
     */
    public function DropStudentTimeTable(mysqli $conn, int $user_id)
    {
        $stmt = $conn->prepare("DELETE FROM time_table WHERE time_table.User_ID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $doctor_id
     * @return mysqli_result
     */
    public function GetDoctorGrades(mysqli $conn, int $doctor_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT doctor_teaching_grades.Grade FROM doctor_teaching_grades WHERE doctor_teaching_grades.Doctor_ID = ?");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $doctor_id
     * @return mysqli_result
     */
    public function GetDoctorSchools(mysqli $conn, int $doctor_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT doctor_teaching_school.School_Name FROM doctor_teaching_school WHERE doctor_teaching_school.Doctor_ID = ?");
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $garde
     * @param int $doctor_id
     * @return bool
     */
    public function CheckDoctorGrade(mysqli $conn, int $garde, int $doctor_id):bool
    {
        $stmt = $conn->prepare("SELECT doctor_teaching_grades.Grade FROM doctor_teaching_grades WHERE doctor_teaching_grades.Doctor_ID = ? AND doctor_teaching_grades.Grade = ?");
        $stmt->bind_param("ii", $doctor_id, $garde);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param String $school_name
     * @param int $doctor_id
     * @return bool
     */
    public function CheckDoctorSchool(mysqli $conn, String $school_name, int $doctor_id):bool
    {
        $stmt = $conn->prepare("SELECT doctor_teaching_school.School_Name FROM doctor_teaching_school WHERE doctor_teaching_school.Doctor_ID = ? AND doctor_teaching_school.School_Name = ?");
        $stmt->bind_param("is", $doctor_id, $school_name);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows > 0){
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
     * @param String $subject
     * @param int $admin_id
     */
    public function EditDoctor(mysqli $conn, String $f_name, String $m_name, String $l_name, String $email, String $password, String $Phone, String $subject, int $admin_id)
    {
        $stmt = $conn->prepare("UPDATE doctor SET F_Name = ?, M_Name = ?, L_Name = ?, Email = ?, Password = ?, Phone = ?, Subject = ? WHERE doctor.Admin_ID = ?");
        $stmt->bind_param("sssssssi", $f_name, $m_name, $l_name, $email, $password, $Phone, $subject, $admin_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $admin_id
     */
    public function DropGradeDoctor(mysqli $conn, int $admin_id)
    {
        $stmt = $conn->prepare("DELETE FROM doctor_teaching_grades WHERE doctor_teaching_grades.Doctor_ID = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $admin_id
     */
    public function DropSchoolDoctor(mysqli $conn, int $admin_id)
    {
        $stmt = $conn->prepare("DELETE FROM doctor_teaching_school WHERE doctor_teaching_school.Doctor_ID = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $course_id
     * @return int
     */
    public function GetAdminIDByCourseID(mysqli $conn, int $course_id):int
    {
        $stmt = $conn->prepare("SELECT courses.Admin_ID FROM courses WHERE courses.Course_ID = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $stmt = $stmt->fetch_assoc();
        return $stmt['Admin_ID'];
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

    /**
     * @param mysqli $conn
     * @param int $user_id
     * @return bool
     */
    public function CheckUserByID(mysqli $conn, int $user_id):bool
    {
        $stmt = $conn->prepare("SELECT student.Student_ID FROM student WHERE student.Student_ID = ?");
        $stmt->bind_param("i",$user_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $user_id
     * @param int $lecture_id
     * @return bool
     */
    public function CheckUserEnrollByLectureID(mysqli $conn, int $user_id, int $lecture_id):bool
    {
        $stmt = $conn->prepare("SELECT lectures.Lecture_ID FROM lectures WHERE lectures.Lecture_ID = ? AND lectures.Course_Time_ID IN (SELECT time_table.Course_Time_ID FROM time_table WHERE time_table.User_ID = ?)");
        $stmt->bind_param("ii", $lecture_id, $user_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $user_id
     * @param int $lecture_id
     * @return bool
     */
    public function CheckIfUserAttend(mysqli $conn, int $user_id, int $lecture_id):bool
    {
        $stmt = $conn->prepare("SELECT attendance_list.User_ID FROM attendance_list WHERE attendance_list.Lecture_ID = ? AND attendance_list.User_ID = ?");
        $stmt->bind_param("ii", $lecture_id, $user_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        if($stmt->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @param int $user_id
     * @param int $lecture_id
     * @param String $arrival_time
     */
    public function AttendUser(mysqli $conn, int $user_id, int $lecture_id, String $arrival_time)
    {
        $stmt = $conn->prepare("INSERT INTO attendance_list (attendance_list.Lecture_ID,attendance_list.User_ID,attendance_list.Arrival_Time,attendance_list.State) VALUES (?, ?, ?, 'ATTENDED') ");
        $stmt->bind_param("iis", $lecture_id, $user_id, $arrival_time);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $course_time_id
     * @param int $lecture_id
     * @return mysqli_result
     */
    private function GetRemainingStudent(mysqli $conn, int $course_time_id, int $lecture_id):mysqli_result
    {
        $stmt = $conn->prepare("SELECT  time_table.User_ID FROM course_time
            LEFT JOIN time_table ON course_time.Course_Time_ID = time_table.Course_Time_ID
            WHERE course_time.Course_Time_ID = ? AND time_table.User_ID NOT IN (SELECT attendance_list.User_ID FROM attendance_list WHERE attendance_list.Lecture_ID = ?)");
        $stmt->bind_param("ii", $course_time_id, $lecture_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     * @return int
     */
    private function GetCourseIdByLectureID(mysqli $conn, int $lecture_id):int
    {
        $stmt = $conn->prepare("SELECT lectures.Course_Time_ID FROM lectures WHERE lectures.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $stmt = $stmt->fetch_assoc();
        return $stmt['Course_Time_ID'];
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     */
    public function AbsentRemainStudent(mysqli $conn, int $lecture_id)
    {
        $course_time_id = $this->GetCourseIdByLectureID($conn, $lecture_id);
        $user_ids = $this->GetRemainingStudent($conn, $course_time_id, $lecture_id);
        while($user_id = $user_ids->fetch_assoc()){
            $stmt = $conn->prepare("INSERT INTO attendance_list (Lecture_ID, User_ID, Arrival_Time, State) VALUES (?, ?, NULL, 'ABSENT')");
            $stmt->bind_param("ii", $lecture_id, $user_id['User_ID']);
            $stmt->execute();
        }
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     */
    public function CancelAllStu(mysqli $conn, int $lecture_id)
    {
        $course_time_id = $this->GetCourseIdByLectureID($conn, $lecture_id);
        $user_ids = $this->GetAllSTU($conn, $course_time_id);
        while($user_id = $user_ids->fetch_assoc()){
            $stmt1 = $conn->prepare("SELECT COUNT(*) FROM attendance_list WHERE Lecture_ID = ? and User_ID = ?;");
            $stmt1->bind_param("ii", $lecture_id, $user_id['User_ID']);
            $stmt1->execute();
            $result = $stmt1->get_result();
            $results = $result->fetch_assoc();
            /**print_r($results['COUNT(*)']);
            var_dump(intval($results['COUNT(*)']) === 0);**/
            if (intval($results['COUNT(*)'])==0){
                $stmt = $conn->prepare("INSERT INTO attendance_list (Lecture_ID, User_ID, Arrival_Time, State) VALUES (?, ?, NULL, 'Cancelled')");
                $stmt->bind_param("ii", $lecture_id, $user_id['User_ID']);

            }else{
                $stmt = $conn->prepare("UPDATE attendance_list SET State ='Cancelled', Arrival_Time= NULL WHERE `User_ID` = ? and `Lecture_ID` = ?;");
                $uid = intval($user_id['User_ID']);
                $stmt->bind_param("ii", $user_id['User_ID'], $lecture_id);

            }
            $stmt->execute();
        }
    }
    /**
     * @param mysqli $conn
     * @param String $course_name
     * @param int $dr_id
     * @return bool
     */
    public function CheckCourseExist(mysqli $conn, String $course_name, int $dr_id):bool
    {
        $stmt = $conn->prepare("SELECT * FROM courses WHERE courses.Admin_ID = ? AND courses.Name = ?;");
        $stmt->bind_param("is", $dr_id, $course_name);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows > 0) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param mysqli $conn
     * @return mysqli_result
     */
    public function GetAllStartedLectures(mysqli $conn):mysqli_result
    {
        $stmt = $conn->prepare("SELECT lectures.Lecture_ID, lectures.Name FROM lectures WHERE lectures.State = 'STARTED';");
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $lecture_id
     * @return String
     */
    public function CourseNameByLectureID(mysqli $conn, int $lecture_id):String
    {
        $stmt = $conn->prepare("SELECT courses.Name FROM lectures
            LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
            LEFT JOIN courses  on courses.Course_ID = course_time.Course_ID
            WHERE lectures.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        $stmt = $stmt->fetch_assoc();
        return $stmt['Name'];
    }

    /**
     * @param mysqli $conn
     * @param int $student_id
     */
    public function CancelStudentVerify(mysqli $conn, int $student_id)
    {
        $stmt = $conn->prepare("UPDATE student SET student.Verify = 0 WHERE  student.Student_ID = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param $lecture_id
     * @return array
     */
    public function CourseNameAndLectureName(mysqli $conn, $lecture_id):array
    {
        $stmt = $conn->prepare("SELECT lectures.Name AS Lecture_Name, c.Name AS Course_Name, ct.Time FROM lectures
            LEFT JOIN course_time ct on lectures.Course_Time_ID = ct.Course_Time_ID
            LEFT JOIN courses c on ct.Course_ID = c.Course_ID
            WHERE  lectures.Lecture_ID = ?");
        $stmt->bind_param("i", $lecture_id);
        $stmt->execute();
        $stmt = $stmt->get_result();
        return $stmt->fetch_assoc();
    }

    /**
     * @param mysqli $conn
     * @param int $stuID
     * @return mysqli_result
     */
    public function RetSCourse(mysqli $conn, int $stuID):mysqli_result
    {
        $stmt = $conn->prepare("SELECT courses.Course_ID,courses.Name FROM time_table
            LEFT JOIN course_time ON course_time.Course_Time_ID = time_table.Course_Time_ID
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID WHERE time_table.User_ID = ?;");
        $stmt->bind_param("i", $stuID);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $stuID
     * @param int $courseid
     * @return mysqli_result
     */
    public function GetsAttlect(mysqli $conn, int $stuID, int $courseid):mysqli_result
    {
        $stmt = $conn->prepare("SELECT COUNT(attendance_list.User_ID) AS Counter, attendance_list.State FROM attendance_list
            LEFT JOIN lectures ON attendance_list.Lecture_ID = lectures.Lecture_ID
            LEFT JOIN course_time ct ON lectures.Course_Time_ID = ct.Course_Time_ID 
            LEFT JOIN courses c ON c.Course_ID = ct.Course_ID
            WHERE attendance_list.User_ID = ? AND c.Course_ID = ?
            GROUP BY attendance_list.State;");
        $stmt->bind_param("ii", $stuID, $courseid);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $stuID
     * @param int $courseID
     * @return mysqli_result
     */
    public function RetCLect(mysqli $conn, int $stuID, int $courseID):mysqli_result
    {
        $stmt = $conn->prepare("SELECT lectures.Name, ct.Day, ct.Time, attendance_list.State,attendance_list.Arrival_Time FROM attendance_list
            LEFT JOIN lectures ON attendance_list.Lecture_ID = lectures.Lecture_ID
            LEFT JOIN course_time ct ON lectures.Course_Time_ID = ct.Course_Time_ID 
            LEFT JOIN courses c ON c.Course_ID = ct.Course_ID
            WHERE attendance_list.User_ID = ? AND c.Course_ID = ?;");
        $stmt->bind_param("ii", $stuID, $courseID);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param int $stuid
     * @return mysqli_result
     */
    public function GetsName(mysqli $conn, int $stuid):mysqli_result
    {
        $stmt = $conn->prepare("SELECT F_Name, M_Name, L_Name,Email,Phone,Parent_Name,Relation_Phone,School_Name FROM student
            WHERE student.Student_ID = ?;");
        $stmt->bind_param("i", $stuid);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @return int
     */
    public function stucount(mysqli $conn):int
    {
        $stmt = $conn->prepare("SELECT * FROM student");
        $stmt->execute();
        return mysqli_num_rows($stmt->get_result());
    }

    /**
     * @param mysqli $conn
     * @return int
     */
    public function gr9stucount(mysqli $conn):int
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE grade = 9");
        $stmt->execute();
        return mysqli_num_rows($stmt->get_result());
    }

    /**
     * @param mysqli $conn
     * @return int
     */
    public function gr10stucount(mysqli $conn):int
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE grade = 10");
        $stmt->execute();
        return mysqli_num_rows($stmt->get_result());
    }

    /**
     * @param mysqli $conn
     * @return int
     */
    public function gr11stucount(mysqli $conn):int
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE grade = 11");
        $stmt->execute();
        return mysqli_num_rows($stmt->get_result());
    }

    /**
     * @param mysqli $conn
     * @return int
     */
    public function gr12stucount(mysqli $conn):int
    {
        $stmt = $conn->prepare("SELECT * FROM student WHERE grade = 12");
        $stmt->execute();
        return mysqli_num_rows($stmt->get_result());
    }

    /**
     * @param mysqli $conn
     * @return int
     */
    public function doccount(mysqli $conn):int
    {
        $stmt = $conn->prepare("SELECT * FROM doctor");
        $stmt->execute();
        return mysqli_num_rows($stmt->get_result());
    }

    /**
     * @param mysqli $conn
     * @param string $coursename
     * @return mysqli_result
     */
    public function courseid(mysqli $conn, string $coursename):mysqli_result
    {
        $stmt = $conn->prepare("SELECT Course_ID FROM courses WHERE Name = ?");
        $stmt->bind_param("s", $coursename);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param string $Day
     * @return mysqli_result
     */
    public function CheckDay(mysqli $conn, string $Day):mysqli_result
    {
        $stmt = $conn->prepare("SELECT courses.Name,courses.Course_ID,course_time.Day,course_time.Time,course_time.Period,course_time.Course_Time_ID
            FROM course_time
            LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
            WHERE course_time.Day = ? and courses.stat = '1'
            AND courses.Course_ID NOT IN (SELECT courses.Course_ID FROM lectures
                 LEFT JOIN course_time ON course_time.Course_Time_ID = lectures.Course_Time_ID
                 LEFT JOIN courses ON courses.Course_ID = course_time.Course_ID
                 WHERE lectures.State != 'FINISHED' AND lectures.State != 'Cancelled');");
        $stmt->bind_param("s",$Day);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * @param mysqli $conn
     * @param string $Day
     * @param int $time_id
     * @return int
     */
    public function checklec(mysqli $conn, string $Day, int $time_id):int
    {
        $stmt = $conn->prepare("SELECT lectures.Lecture_ID FROM lectures WHERE lectures.Name = ? and lectures.Course_Time_ID = ?;");
        $stmt->bind_param("si",$Day, $time_id);
        $stmt->execute();
        return mysqli_num_rows($stmt->get_result());
    }
}