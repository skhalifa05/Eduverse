<?php

require_once "../DB/attendance_db.php";
require_once "../Models/EmailVerify.php";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns="">
<head>
    <meta charset="UTF-8">
    <title>Bright Side | Codeology Education</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
if(isset($conn)){
    $verify = new EmailVerify();
if(isset($_GET['Parent_Email_Verify'])){
    $verify->VerifyParent($conn, $_GET['Student_ID']);
    ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Done',
            text: "Your email \"<?php echo $_GET['Email'] ?>\" is verified to be guardian for \"<?php echo $verify->GetStudentName($conn, $_GET['Student_ID']) ?>\"",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Done'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../index.php";
            }
        })
    </script>
<?php
}else if(isset($_GET['Student_Email_Verify'])){
$verify->VerifyStudent($conn, $_GET['Student_ID']);
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Done',
            text: "Your email \"<?php echo $_GET['Email'] ?>\" is verified",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Done'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../index.php";
            }
        })
    </script>
<?php
}else if(isset($_GET['Dr_Email_Verify'])){
$verify->VerifyDR($conn, $_GET['DR_ID']);
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Done',
            text: "Your email \"<?php echo $_GET['Email'] ?>\" is verified",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Done'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../index.php";
            }
        })
    </script>
<?php
}else{
    header("Location: ../index.php");
}
}else{
?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Connection with database failed please contact your organization",
            confirmButtonColor: '#d63030',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../index.php";
            }
        })
    </script>
    <?php
}
?>
</body>
</html>
