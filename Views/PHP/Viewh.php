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
if (isset($_GET['Year'])){
    $stuname = $center->GetOldsName($conn, $_GET['Student_ID'],$_GET['Year']);
    $Sname = $stuname->fetch_assoc();
}else{
    $stuname = $center->GetsName($conn, $_GET['Student_ID']);
    $Sname = $stuname->fetch_assoc();
}

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/oldAttendance.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
        <script type="text/javascript" src="../JS/html2canvas.js"></script>
        <title>Students list</title>
    </head>
    <body>
 <nav id="menu" class="menu open">
    <div class="actionbar">
        <div>
            <button id="menuBtn">
                <i class="fas fa-bars"></i>
            </button>
            <h3 class="menuText open2" style="font-size: 20px;"><span style="color: #174074">Bright</span><span style="color: #F0A61F"> Side</span></h3>
        </div>
    </div>
    <ul class="optionsBar">
        <li class="menuItem">
            <a href="dashboard.php" class="menuOption">
                <i class="fa-solid fa-database"></i><h5 class="menuText open2">Overview</h5>
            </a>
        </li>
        <li class="menuBreak">
            <hr>
        </li>
        <li class="menuItem">
            <a href="Center_Home.php" class="menuOption">
                <i class="fa-solid fa-house"></i><h5 class="menuText open2">Home</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_course.php" class="menuOption">
                <i class="fa-solid fa-graduation-cap"></i><h5 class="menuText open2">Courses</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_Lectures.php" class="menuOption">
                <i class="fa-solid fa-chalkboard-user"></i><h5 class="menuText open2">Lecture Timings</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_Lecture_List.php" class="menuOption">
                <i class="fa-solid fa-clipboard-user"></i><h5 class="menuText open2">Attendance Reports</h5>
            </a>
        </li>
        <li class="menuItem active" <?php if(isset($_GET['Year'])){ echo 'style="background-color: #F0A61F";';}?>>
            <a href="Center_Student_List.php" class="menuOption">
                <i class="fa-solid fa-user" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Student List <?php if(isset($_GET['Year'])){ echo '(Archives)';}?></h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_Doc_List.php" class="menuOption">
                <i class="fa-solid fa-school"></i><h5 class="menuText open2">Doctor List</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_Add_Student.php" class="menuOption">
                <i class="fa-solid fa-user-plus"></i><h5 class="menuText open2">Add Student</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_Add_Admin.php" class="menuOption">
                <i class="fa-solid fa-book-medical"></i><h5 class="menuText open2">Add Doctor</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_requests.php" class="menuOption">
                <i class="fa fa-plus-square-o"></i><h5 class="menuText open2">Student Requests</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_archives.php" class="menuOption">
                <i class="fa-solid fa-book"></i><h5 class="menuText open2">Archives</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="../../Controller/logout.php"  class="menuOption">
                    <i class="uil uil-signout"></i><h5 class="menuText open2">Logout</h5>
            </a>
        </li>
    </ul>
    <div class="menuUser">
        <a>
<!--            <h5 class="Username menuText open2">--><?php //echo $center->getName(); ?><!--</h5>-->
<!--            <p class="menuText open2"><i class="fas fa-chevron-right"></i></p>-->
        </a>
        <div class="userInfo">
<!--            <div>-->
<!--                <h1><i class="fas fa-exclamation-circle"></i></h1>-->
<!--                <p>User Info</p>-->
<!--            </div>-->
        </div>
    </div>
    <div class="themeBar">
        <div>
            <button id="themeChangeBtn"><i class="fas " style="color: #fff"></i></button>
        </div>
    </div>
</nav>
    <section class="dashboard">
    <div class="CodeOlogyLogo-container">
        <img class="CodeOlogyLogo" src="../../Images/COedu.png" alt="">
    </div>
        <div style="margin-bottom: 50px" class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="fa-solid fa-user"></i>
                    <span class="text">Student Name: <?php echo $Sname['F_Name'].' '.$Sname['M_Name'].' '.$Sname['L_Name']?></span>
                </div>
    <?php
    if (isset($_GET['Year'])){
        $primData = $center->RetSOldCourse($conn, $_GET['Student_ID'], $_GET['Year']);
    }else{
        $primData = $center->RetSCourse($conn, $_GET['Student_ID']);
    }

    $attended = 0;
    $absent = 0;
    while($primary_row = $primData->fetch_assoc()){
        if (isset($_GET['Year'])){
            $attendance_data = $center->GetsOldAttlect($conn, $_GET['Student_ID'], $primary_row['Course_ID'], $_GET['Year']);
        }else{
            $attendance_data = $center->GetsAttlect($conn, $_GET['Student_ID'], $primary_row['Course_ID']);
        }

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
                        }
                    }
                }
    ?>

            <div class="title">
                <i class="uil uil-dashboard"></i>
                <span class="text"><?php echo $primary_row['Name']?></span>
            </div>
            <div class="boxes">
                <div class="box box1" onclick="getFinished2('attendance_selector', '<?php echo $primary_row['Name'] ?>')">
                    <span class="text">All Lectures</span>
                    <span class="number"><?php echo $attended + $absent ?></span>
                </div>
                <div class="box box2" onclick ="getFinished2('attend', '<?php echo $primary_row['Name'] ?>')">
                    <span class="text">attended Lectures</span>
                    <span class="number"><?php echo $attended ?></span>
                </div>
                <div class="box box3" onclick="getFinished2('not_attend', '<?php echo $primary_row['Name'] ?>')">
                    <span class="text">Absent Lectures</span>
                    <span class="number"><?php echo $absent ?></span>
                </div>
            </div>

        <div class="activity">
            <div class="title">
                <i class="uil uil-book"></i>
                <span class="text">Attendance</span>
            </div>
            <div class="activity-data">
                <table id="myTable">
                    <tr>
                        <th>
                            <p>No.</p>
                        </th>
                        <th>
                            <p>Lecture Name</p>
                        </th>
                        <th>
                            <p>Arrival Time</p>
                        </th>
                        <th>
                            <p>Day: Lecture Time</p>
                        </th>
                        <th>
                            <p>State</p>
                        </th>
                        <th>
                            <p>State</p>
                        </th>
                    </tr>
                    <?php
                    if (isset($_GET['Year'])){
                        $secondary_data = $center->RetOldCLect($conn, $_GET['Student_ID'] ,$primary_row['Course_ID'], $_GET['Year']);
                    }else{
                        $secondary_data = $center->RetCLect($conn, $_GET['Student_ID'] ,$primary_row['Course_ID']);
                    }

                    $i=1;
                    while($secondary_row = $secondary_data->fetch_assoc()){
                        ?>
                        <tr class="attendance_selector-<?php echo $primary_row['Name'] ?> <?php
                        if($secondary_row['State'] == "ATTENDED"){
                            echo "attend-" . $primary_row['Name'];
                        }else{
                            echo "not_attend-" . $primary_row['Name'];
                        }
                        ?>">
                            <td>
                                <p>
                                    <?php echo $i ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $secondary_row['Name']?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php
                                    if ($secondary_row['Arrival_Time'] && $secondary_row['State'] == "ATTENDED") {
                                        echo $secondary_row['Arrival_Time'];
                                    } else {
                                        echo "--:--";
                                    }

                                    ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $secondary_row['Day'] . ": " . $secondary_row['Time'] ?>
                                </p>
                            </td>
                            <td>
                                        <p class="<?php
                                        if($secondary_row['State'] == "ATTENDED"){
                                            echo "deadline1";
                                        }else if($secondary_row['State'] == "ABSENT"){
                                            echo "deadline";
                                        }else{
                                            echo "deadline3";
                                        }
                                        ?>" id="deadline1">
                                            <?php
                                            if($secondary_row['State'] == "ATTENDED"){
                                                echo "Attended";
                                            }else if($secondary_row['State'] == "ABSENT"){
                                                echo "Absent";
                                            }else{
                                                echo "Cancelled";
                                            }
                                            ?>
                                        </p>
                            </td>
                                      <td>
                                        <div class="<?php
                                        if($secondary_row['State'] == "ATTENDED"){
                                            echo "homeworkState";
                                        }else if($secondary_row['State'] == "ABSENT"){
                                            echo "homeworkState2";
                                        }else{
                                            echo "homeworkState3";
                                        }
                                        ?>" id="state"></div>
                                    </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    }
    ?>
    </div>
    </section>
    <script src="../JS/Attendance.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    const menuBtn = document.getElementById('menuBtn');
    const menu = document.getElementById('menu');
    const menuText = document.querySelectorAll('.menuText');

    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('open');
        menuText.forEach(function(text, index){
            setTimeout(() => {
                text.classList.toggle('open2');
            }, index * 50);
        })
    })
    menuBtn.addEventListener('click', function(e) {
        if($(e.target).closest('#menu').length === 0){
            menu.classList.remove('open');
            menuText.forEach(function(text, index){
            setTimeout(() => {
                text.classList.toggle('open2');
            }, index * 50);
        })
    }
    })
    // dark light mode

    const dayNight = document.querySelector('#themeChangeBtn');
    dayNight.addEventListener("click", () => {
        document.body.classList.toggle("dark");
        if(document.body.classList.contains("dark"))
        {
            localStorage.setItem("theme","dark");
        }
        else
        {
            localStorage.setItem("theme","light");
        }
        updateIcon();
    })
    function themeMode(){
        if(localStorage.getItem("theme") !== null)
        {
            if(localStorage.getItem("theme") === "light")
            {
                document.body.classList.remove("dark");
            }
            else
            {
                document.body.classList.add("dark");
            }
        }
        updateIcon();
    }
    themeMode();
    function updateIcon(){
        if(document.body.classList.contains("dark"))
        {
            dayNight.querySelector("i").classList.remove("fa-moon");
            dayNight.querySelector("i").classList.add("fa-sun");
        }
        else
        {
            dayNight.querySelector("i").classList.remove("fa-sun");
            dayNight.querySelector("i").classList.add("fa-moon");
        }
    }
</script>
    </body>
    </html>
    <?php
}
?>
