<?php

require_once "../../DB/attendance_db.php";
require_once "../../Models/Center.php";

session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center)){
$stuname = $center->GetsName($conn, $_GET['Student_ID']);
$Sname = $stuname->fetch_assoc();
?>
<!Doctype HTML>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../CSS/FINALviewh2.css">
    <style>
        .card{
            border-radius: 20px;
        }
        .bg-primary{
            background-color: #00ff00;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="main-body">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Student List</a></li>
                <li class="breadcrumb-item" aria-current="page">Student ID: <?php echo $_GET['Student_ID']?></li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://pluspng.com/img-png/user-png-icon-big-image-png-2240.png" alt="Admin" class="rounded-circle" width="110">
                            <div class="mt-3">
                                <h4><?php echo $Sname['F_Name'].' '.$Sname['L_Name']?></h4>
                                <p class="text-secondary mb-1">Student at <?php echo $Sname['School_Name']?></p>
                                <!--<p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <center><h5>Contact Us</h5></center>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Email</h6>
                            <span style="font-size: 13px;" class="text-secondary">Geeksupport@codeology.digital</span>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $Sname['F_Name'].' '.$Sname['M_Name'].' '.$Sname['L_Name']?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $Sname['Email']?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $Sname['Phone']?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Parent Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $Sname['Parent_Name']?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Parent Mobile</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $Sname['Relation_Phone']?>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row gutters-sm">

                    <?php
                    $primData = $center->RetSCourse($conn, $_GET['Student_ID']);
                    $attended = 0;
                    $absent = 0;
                    while($primary_row = $primData->fetch_assoc()){
                        $attendance_data = $center->GetsAttlect($conn, $_GET['Student_ID'], $primary_row['Course_ID']);
                        if($attendance_data->num_rows == 1){
                            $row_attendance = $attendance_data->fetch_assoc();
                            if($row_attendance['State'] == "ATTENDED"){
                                $attended = $row_attendance['Counter'];
                                $absent = 0;
                            }else{
                                $absent = $row_attendance['Counter'];
                                $attended = 0;
                            }
                        }else if($attendance_data->num_rows == 0){
                            $absent=0;
                            $attended=0;
                        }else if($attendance_data->num_rows == 2){
                            while($row_attendance = $attendance_data->fetch_assoc()){
                                if($row_attendance['State'] == "ABSENT"){
                                    $absent = $row_attendance['Counter'];
                                }else if($row_attendance['State'] == "ATTENDED"){
                                    $attended = $row_attendance['Counter'];
                                }
                            }
                        }else if($attendance_data->num_rows == 3){
                            while($row_attendance = $attendance_data->fetch_assoc()){
                                if($row_attendance['State'] == "ABSENT"){
                                    $absent = $row_attendance['Counter'];
                                }else if($row_attendance['State'] == "ATTENDED"){
                                    $attended = $row_attendance['Counter'];
                                }else if($row_attendance['State'] == "Cancelled"){
                                    $canc = $row_attendance['Counter'];
                                }
                            }
                        }
                        ?>
                        <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"><?php echo $primary_row['Name']?></i></h6>
                                <small>Total: <?php echo $attended + $absent ?> Lectures</small>
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>Attended: <?php echo $attended ?> Lectures</small>
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: calc((<?php echo $attended ?>/<?php echo $attended + $absent ?>) * 100%);background-color: #00fa9a!important;" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>Absent: <?php echo $absent ?> Lectures</small>
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: calc((<?php echo $absent ?>/<?php echo $attended + $absent ?>) * 100%);background-color: #ff4040!important;"  aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--<small>Cancelled: <?php echo $canc ?> Lectures</small>
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: calc((<?php echo $canc ?>/100) * 100%);background-color: #ffff00!important;"  aria-valuemin="0" aria-valuemax="100"></div>
                                </div>-->
                            </div>
                        </div>
                    </div>

                        <?php
                    }
                    ?>

                </div>



            </div>
        </div>

    </div>
</div>
</body>
    <?php
}
?>