<?php
require_once '../../Models/vendor/autoload.php';
require_once "../../DB/attendance_db.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GenerateExcelReportController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function generateReport(int $lecture_id, $year) {
        $result = $this->ExcelAttendanceReport($this->conn, $lecture_id, $year);
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header row
        $sheet->setCellValue('A1', 'State');
        $sheet->setCellValue('B1', 'Arrival Time');
        $sheet->setCellValue('C1', 'First Name');
        $sheet->setCellValue('D1', 'Last Name');
        $sheet->setCellValue('E1', 'Middle Name');
        $sheet->setCellValue('F1', 'Lecture Name');
        $sheet->setCellValue('G1', 'Course Name');
        $sheet->setCellValue('H1', 'Lecture ID');
        $sheet->setCellValue('I1', 'Student ID');

        // Add data rows
        $row = 2;
        while ($data = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $data[$year . '_attendance_list.State']);
            $sheet->setCellValue('B' . $row, $data[$year . '_attendance_list.Arrival_Time']);
            $sheet->setCellValue('C' . $row, $data[$year . '_students.F_Name']);
            $sheet->setCellValue('D' . $row, $data[$year . '_students.L_Name']);
            $sheet->setCellValue('E' . $row, $data[$year . '_students.M_Name']);
            $sheet->setCellValue('F' . $row, $data['L_Name']);
            $sheet->setCellValue('G' . $row, $data['C_Name']);
            $sheet->setCellValue('H' . $row, $data[$year . '_lectures.Lecture_ID']);
            $sheet->setCellValue('I' . $row, $data[$year . '_students.Student_ID']);
            $row++;
        }

        $fileName = 'AttendanceReport_' . $lecture_id . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Length: ' . filesize($temp_file));
        readfile($temp_file);
        unlink($temp_file);
        exit;
    }

    private function ExcelAttendanceReport(mysqli $conn, int $lecture_id, $year): mysqli_result {
        $stmt = $conn->prepare("SELECT ".$year."_attendance_list.State, ".$year."_attendance_list.Arrival_Time, ".$year."_students.F_Name, ".$year."_students.L_Name, ".$year."_students.M_Name, ".$year."_lectures.Name AS L_Name, ".$year."_courses.Name AS C_Name, ".$year."_lectures.Lecture_ID, ".$year."_students.Student_ID FROM ".$year."_attendance_list
            LEFT JOIN ".$year."_students ON ".$year."_students.Student_ID = ".$year."_attendance_list.User_ID
            LEFT JOIN ".$year."_lectures ON ".$year."_lectures.Lecture_ID = ".$year."_attendance_list.Lecture_ID
            LEFT JOIN ".$year."_course_time ON ".$year."_course_time.Course_Time_ID = ".$year."_lectures.Course_Time_ID
            LEFT JOIN ".$year."_courses ON ".$year."_courses.Course_ID = ".$year."_course_time.Course_ID
            WHERE ".$year."_attendance_list.Lecture_ID = ?
            ORDER BY ".$year."_attendance_list.Arrival_Time");
        $stmt->bind_param("i", $lecture_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    
};

if (isset($_GET['Lecture_ID']) && isset($_GET['year'])){
    $controller = new GenerateExcelReportController($conn);
    $controller->generateReport($_GET['Lecture_ID'], $_GET['year']);
}else{
    
}
