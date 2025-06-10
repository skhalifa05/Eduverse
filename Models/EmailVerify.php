<?php

class EmailVerify
{
    /**
     * @param mysqli $conn
     * @param int $student_id
     */
    public function VerifyParent(mysqli $conn, int $student_id)
    {
        $stmt = $conn->prepare("UPDATE student SET student.Parent_Verify = 1 WHERE  student.Student_ID = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $student_id
     */
    public function VerifyStudent(mysqli $conn, int $student_id)
    {
        $stmt = $conn->prepare("UPDATE student SET student.Verify = 1 WHERE  student.Student_ID = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $dr_id
     */
    public function VerifyDR(mysqli $conn, int $dr_id)
    {
        $stmt = $conn->prepare("UPDATE doctor SET doctor.Verify = 1 WHERE  doctor.Admin_ID = ?");
        $stmt->bind_param("i", $dr_id);
        $stmt->execute();
    }

    /**
     * @param mysqli $conn
     * @param int $student_id
     * @return String
     */
    public function GetStudentName(mysqli $conn, int $student_id):String
    {
        $stmt = $conn->prepare("SELECT F_Name,M_Name,L_Name FROM student WHERE student.Student_ID = ?;");
        $stmt->bind_param("i",$student_id);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();
        return $results['F_Name'] . " " . $results['M_Name'] . " " . $results['L_Name'];
    }
}