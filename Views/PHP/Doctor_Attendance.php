<?php

require_once "../../Models/Doctor.php";
require_once "../../DB/attendance_db.php";

session_start();
if(isset($_SESSION['Doctor-Attendance-System-1'])){
    $doctor = unserialize($_SESSION['Doctor-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
header("Location: ../../index.php");
if(isset($conn) && isset($doctor) && ($doctor instanceof Doctor)){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/UAttendance.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/e6688e278c.js" crossorigin="anonymous"></script>
        <title>Attendance</title>
    </head>

    <body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../../Images/BrightSideLogo.png" alt="">
            </div>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="Doctor_Attendance.php">
                        <i id="nav-active" class="uil uil-estate"  title="home"></i>
                        <span id="nav-active" class="link-name" >Home</span>
                    </a>
                </li>
                <li><a href="Doctor_Profile.php">
                        <i class="uil uil-user-square" title="profile"></i>
                        <span class="link-name">Profile</span>
                    </a>
                </li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../../Controller/logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="CodeOlogyLogo-container">
            <img class="CodeOlogyLogo" src="../../Images/COedu.png" alt="">
        </div>
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="name"><?php echo $doctor->getName(); ?></div>
            <a href="Doctor_Profile.php"><img src="../../Images/profile.jpg" alt=""></a>
        </div>
        <div style="margin-bottom: 50px" class="dash-content">
            <div class="activity">
                <div class="title">
                    <i class="uil uil-book"></i>
                    <span class="text">Attendance</span>
                </div>
                <div class="activity-data">
                    <table id="myTable">
                        <thead>
                        <tr>
                            <th>
                                <p>
                                    No.
                                </p>
                            </th>
                            <th>
                                <p>
                                    Course name
                                </p>
                            </th>
                            <th>
                                <p>
                                    Lecture name
                                </p>
                            </th>
                            <th>
                                <p>
                                    Lecture Time
                                </p>
                            </th>
                            <th>
                                <p>
                                    Students attended
                                </p>
                            </th>
                            <th>
                                <p>
                                    Students absent
                                </p>
                            </th>
                            <th>
                                <p>
                                    Attendance
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $data = $doctor->ReturnAllLectures($conn);
                        $attended = 0;
                        $absent = 0;
                        $i=1;
                        while($row = $data->fetch_assoc()){
                            $attendance_data = $doctor->GetUserCountsForLecture($conn, $row['Lecture_ID']);
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
                            }
                            ?>
                            <tr>
                                <td>
                                    <p>
                                        <?php echo $i; ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['C_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['L_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php
                                        $time = strtotime($row['Time']);
                                        $period = strtotime($row['Period']);
                                        $secs = $period-strtotime("00:00:00");
                                        $result = date("H:i:s",$time+$secs);
                                        echo $row['Day'] . ": " . $row['Time'] . "->" .  $result;
                                        ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $attended ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $absent ?>
                                    </p>
                                </td>
                                <td class="att-show">
                                    <button onClick="window.location.href='Attendance_List.php?Lecture_ID=<?php echo $row['Lecture_ID'] ?>&Attend_Count=<?php echo $attended ?>&Absent_Count=<?php echo $absent ?>'" class="att-btn">Show</button>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="../JS/Attendance.js"></script>
    </body>
    </html>
    <?php
}
?>