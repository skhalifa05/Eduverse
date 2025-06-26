<?php

require_once "../DB/attendance_db.php";
require_once "../Models/Center.php";
require_once "../Models/Email.php";

session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)){
    if (isset($_GET['Delete_Student'])) {
        if($center->getType() == "SUPER-ADMIN"){
            $center->DeleteStudent($conn, $_GET['Student_ID']);
            header("Location: ../Views/PHP/Center_Student_List.php");
        }else{
            header("Location: ../Views/PHP/Center_Student_List.php?Not-Authorized");
        }
    }elseif(isset($_GET['Reverify_Student'])){
          $email = new Email("CodeologyEdu@brightside-edu.com", "Codeology Education", "Codeologyedu@2022");
          $student_data = $center->GetStudentData($conn, $_GET['Student_ID']);
          if($student_data['Verify'] == '0'){
            $email->SendStudentVerificationEmail($student_data['Email'],$student_data['F_Name'] . " " . $student_data['M_Name'] . " " . $student_data['L_Name'],$_GET['Student_ID']); 
             header("Location: ../Views/PHP/Center_Student_List.php?stat=OK");
          }else{
              header("Location: ../Views/PHP/Center_Student_List.php");
          }
    }elseif(isset($_GET['admin_approve'])){
          $center->adminapprove($conn, $_GET['Student_ID']);
            header("Location: ../Views/PHP/Center_Student_List.php?stat=OK");
    }elseif(isset($_GET['Duplicate']) and isset($_GET['Year'])){
        echo $_GET['Student_ID'];
        $stuname = $center->GetOldsName($conn, $_GET['Student_ID'],$_GET['Year']);
        $Sname = $stuname->fetch_assoc();
        echo $Sname['F_Name'].' '.$Sname['M_Name'].' '.$Sname['L_Name'];
        if(!$center->CheckEmailExist($conn, $Sname['Email'])){
            $center->AddOLDStudent($conn, $_GET['Student_ID'], $Sname['F_Name'], $Sname['M_Name'], $Sname['L_Name'], $Sname['Email'], $Sname['Phone'], $Sname['Phone'], $Sname['School_Name'], $Sname['Grade'], $Sname['Age'], $Sname['Relation_Name'], $Sname['Parent_Name'], $Sname['Relation_Phone'], $Sname['Verify']);

        }else{
            header("Location: ../Views/PHP/Center_Student_List.php?Year=".$_GET['Year']."&Email-Exist");
        }
    }elseif(isset($_GET['Drop_Student'])){
        if($center->getType() == "SUPER-ADMIN"){
            $center->DropStudent($conn, $_GET['Student_ID'], $_GET['Course_id']);
            header("Location: ../Views/PHP/Course_S_View.php?Course_ID=".$_GET['Course_id']);
        }else{
            header("Location: ../Views/PHP/Center_Student_List.php?Not-Authorized");
        }        
    }elseif(isset($_GET['Delete_request'])){
        if($center->getType() == "SUPER-ADMIN"){
            $center->DeleteRequest($conn, $_GET['Student_ID']);
            header("Location: ../Views/PHP/Center_requests.php");
        }else{
            header("Location: ../Views/PHP/Center_Student_List.php?Not-Authorized");
        }
    }
    else{
        header("Location: ../Views/PHP/Center_Student_List.php");
    }
}else{
    header("Location: ../Views/PHP/Center_Student_List.php");
}