<?php

require_once "../../Models/Student.php";
require_once "../../DB/attendance_db.php";

session_start();
if(isset($_SESSION['Student-Attendance-System-1'])){
    $student = unserialize($_SESSION['Student-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}

if(isset($conn) && isset($student) && ($student instanceof Student)){
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
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <title>My Attendance</title>
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

        <li class="menuBreak">
            <hr>
        </li>
        <li class="menuItem">
            <a href="profile.php" class="menuOption">
                <i class="uil uil-user-square"></i><h5 class="menuText open2" >Profile</h5>
            </a>
        </li>
        <li class="menuItem active">
            <a href="Attendance.php" class="menuOption">
                <i class="uil uil-estate" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">My Attendance</h5>
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
            <h5 class="Username menuText open2"><?php echo $student->getName(); ?></h5>
            <p class="menuText open2"><i class="fas fa-chevron-right"></i></p>
        </a>
        <div class="userInfo">
            <div>
                <h1><i class="fas fa-exclamation-circle"></i></h1>
                <p>User Info</p>
            </div>
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
            <?php
            $primary_data = $student->ReturnAllCoursesName($conn);
            $attended = 0;
            $absent = 0;
            while($primary_row = $primary_data->fetch_assoc()){
                $attendance_data = $student->GetAttendLectureCount($conn, $primary_row['Course_ID']);
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
                <div class="overview">
                    <div class="title">
                        <i class="uil uil-dashboard"></i>
                        <span class="text"><?php echo $primary_row['Name'] ?></span>
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
                            $secondary_data = $student->ReturnAllCoursesLecture($conn, $primary_row['Course_ID']);
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