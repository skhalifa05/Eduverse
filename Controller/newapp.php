<?php
require_once "../Models/User.php";
require_once "../DB/attendance_db.php";
require_once "../Models/Email.php";
$user = new User();
if (isset($conn)) {
    if (isset($_POST['new-stu-signup'])) {
        $email = new Email("CodeologyEdu@brightside-edu.com", "Codeology Education", "Codeologyedu@2022");
//        echo $_POST['F_name'];
//        echo $_POST['M_name'];
//        echo $_POST['L_name'];
//        echo $_POST['email'];
//        echo $_POST['Pnumb'];
//        echo $_POST['Sname'];
//        echo $_POST['Grade'];
//        echo $_POST['Age'];
//        echo $_POST['Gname'];
//        echo $_POST['GType'];
//        echo $_POST['Gpnumb'];
//        echo $_POST['Course'];
        if(!$user->CheckRequestEmailExist($conn, $_POST['email']) and !$user->CheckStudentEmailExist($conn, $_POST['email'])){
            $fail = false;
            $user->AddStudent($conn, $_POST['F_name'], $_POST['M_name'], $_POST['L_name'], $_POST['email'], $_POST['Pnumb'], $_POST['Pnumb'], $_POST['Sname'], $_POST['Grade'], $_POST['Age'], $_POST['GType'], $_POST['Gname'], $_POST['Gpnumb'], $_POST['Course']);
//            $email->SendStudentVerificationEmail($_POST['email'],$_POST['F_name'] . " " . $_POST['M_name'] . " " . $_POST['L_name'], $user->GetStudentID($conn, $_POST['email']));

            header("Location: ../index.php?success");
        }else{
            header("Location: ../index.php?Email-Exist");
        }
    }else{
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}