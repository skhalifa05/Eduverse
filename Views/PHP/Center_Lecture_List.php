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
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/QCenter_Lecture_List.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <!----------------js---------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Finished Lectures</title>
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
        <li class="menuItem active" <?php if(isset($_GET['Year'])){ echo 'style="background-color: #F0A61F";';}?>>
            <a href="Center_Lecture_List.php" class="menuOption">
                <i class="fa-solid fa-clipboard-user" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Attendance Reports <?php if(isset($_GET['Year'])){ echo '(Archives)';}?></h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_Student_List.php" class="menuOption">
                <i class="fa-solid fa-user"></i><h5 class="menuText open2">Student List</h5>
            </a>
        </li>
                   <li class="menuItem ">
                <a href="Center_excessive_attendance.php" class="menuOption">
                    <i class="fa fa-history" aria-hidden="true"></i><h5 class="menuText open2" >Excessive Absence</h5>
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
            <!--<li class="menuItem">-->
            <!--    <a href="../../Controller/logout.php"  class="menuOption">-->
            <!--        <i class="uil uil-signout"></i><h5 class="menuText open2">Logout</h5>-->
            <!--    </a>-->
            <!--</li>-->
        </ul>
        <div class="menuUser">

        </div>
        <div class="themeBar">
            <div>
                <!--<button id="themeChangeBtn"><i class="fas " style="color: #fff"></i></button>-->
                <button onclick="window.location.href='../../Controller/logout.php';"><i class="uil uil-signout" style="color: #fff"></i></button>
            </div>
        </div>
    </nav>
    <section class="dashboard">
        <div class="CodeOlogyLogo-container">
            <img class="CodeOlogyLogo" src="../../Images/COedu.png" alt="">
        </div>

        <div style="margin-bottom: 50px" class="content">
              <div class="notch">
<h3 style="padding-left: 22%;margin-top: 0%;color: #F0A61F;"><?php echo $center->getName(); ?></h3>
  </div>
            <div class="overview">
                <div class="title">
                    <div class="titlesmall">
                        <i class="uil uil-notes"></i>
                        <span class="text">
                            <?php
                                if (isset($_GET['Year'])){
                                    echo $_GET['Year'].' Lectures';
                                }else{
                                    echo 'Current Lectures';
                                }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="searches">
                <input type="text" id="myNames" onkeyup="searchLectureNames()" placeholder="Search by Lecture Name.." title="Type in a name">
                <input type="text" id="myIDs" onkeyup="searchCourseNames()" placeholder="Search by Course Name.." title="Type in a name">
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
                                    Day
                                </p>
                            </th>
                            <th>
                                Lecture Date
                            </th>
                            <th>
                                <p>
                                    Dr. Name
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
                        if (isset($_GET['Year'])){
                            $data = $center->ReturnAllOldLecturesFinished($conn, $_GET['Year']);
                            $attended = 0;
                            $absent = 0;
                            $i=1;

                            while($row = $data->fetch_assoc()){
                                $attendance_data = $center->GetOldUserCountsForLecture($conn, $row['Lecture_ID'], $_GET['Year']);
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
                                $name = $row['L_NAme'];
                            ?>



                            <tr>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo $i; ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo $row['C_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                    <?php
                                        $name = $row['L_NAme'];
                                        if ($name[0] == 'L'){
                                            echo 'N/A';
                                        }
                                        else {
                                            $timestamp = $row['L_NAme'];
                                            $dd = explode('/', $timestamp);
                                            $nd = strtotime((string)$dd[1] . "/" . (string)$dd[0] . "/" . (string)$dd[2]);
                                            $day = date('D', $nd);
                                            echo $day;
                                        }
                                    ?>
                                </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo $row['L_NAme'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo "Dr. " . $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php if ($row['State'] == 'Cancelled'){echo 'N/A';}else{echo $attended;} ?>

                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php if ($row['State'] == 'Cancelled'){echo 'N/A';}else{echo $absent;} ?>
                                    </p>
                                </td>
                                <td class="att-show">
                                    <?php
                                    if ($row['State'] == 'Cancelled'){
                                        echo '<p style="color: #ff0000">
                                                 Cancelled
                                    </p>';
                                    }
                                    else{?>
                                    <button onClick="window.location.href='Attendance_List.php?Lecture_ID=<?php echo $row['Lecture_ID'] ?>&Attend_Count=<?php echo $attended ?>&Absent_Count=<?php echo $absent ?>&Year=<?php echo $_GET['Year'] ?>'" class="att-btn">Show</button>
                                <?php }?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        }
                        else{
                            $data = $center->ReturnAllLecturesFinished($conn);
                            $attended = 0;
                            $absent = 0;
                            $i=1;

                            while($row = $data->fetch_assoc()){
                                $attendance_data = $center->GetUserCountsForLecture($conn, $row['Lecture_ID']);
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
                                $name = $row['L_NAme'];
                            ?>



                            <tr>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo $i; ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo $row['C_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                    <?php
                                        $name = $row['L_NAme'];
                                        if ($name[0] == 'L'){
                                            echo 'N/A';
                                        }
                                        else {
                                            $timestamp = $row['L_NAme'];
                                            $dd = explode('/', $timestamp);
                                            $nd = strtotime((string)$dd[1] . "/" . (string)$dd[0] . "/" . (string)$dd[2]);
                                            $day = date('D', $nd);
                                            echo $day;
                                        }
                                    ?>
                                </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo $row['L_NAme'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php echo "Dr. " . $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php if ($row['State'] == 'Cancelled'){echo 'N/A';}else{echo $attended;} ?>

                                    </p>
                                </td>
                                <td>
                                    <p <?php if ($row['State'] == 'Cancelled'){echo 'style="color: #ff0000"';} else if(isset($name[11])) {if ($name[11] == 'X'){echo 'style="color: #0000ff"';}}?>>
                                        <?php if ($row['State'] == 'Cancelled'){echo 'N/A';}else{echo $absent;} ?>
                                    </p>
                                </td>
                                <td class="att-show">
                                    <?php
                                    if ($row['State'] == 'Cancelled'){
                                        echo '<p style="color: #ff0000">
                                                 Cancelled
                                    </p>';
                                    }
                                    else{?>
                                    <button onClick="window.location.href='Attendance_List.php?Lecture_ID=<?php echo $row['Lecture_ID'] ?>&Attend_Count=<?php echo $attended ?>&Absent_Count=<?php echo $absent ?>'" class="att-btn">Show</button>
                                <?php }?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="../JS/Center_Lecture_List.js"></script>
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