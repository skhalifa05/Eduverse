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
        <link rel="stylesheet" href="../CSS/QCenter_Lectures.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.all.min.js"></script>
        <title>Add Lecture</title>
        <style>
            .Center_Home_Input{
                width: calc((100%/4) - 25px);
            }
        </style>
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
                <i class="fa-solid fa-database" ></i><h5 class="menuText open2">Overview</h5>
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
        <li class="menuItem active">
            <a href="Center_Lectures.php" class="menuOption">
                <i class="fa-solid fa-chalkboard-user" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Lecture Timings</h5>
            </a>
        </li>
        <li class="menuItem">
            <a href="Center_Lecture_List.php" class="menuOption">
                <i class="fa-solid fa-clipboard-user"></i><h5 class="menuText open2">Attendance Reports</h5>
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
        <div style="margin-bottom: 50px" class="dash-content">
            <div class="activity">
                  <div class="notch">
<h3 style="padding-left: 22%;margin-top: 0%;color: #F0A61F;"><?php echo $center->getName(); ?></h3>
  </div>
                <div class="title">
                    <i class="uil uil-book"></i>
                    <span class="text">Lecture Timings</span>
                </div>
                <div class="container" style="margin-bottom: 2%;">
                    <div class="row">
                        <div class="header-border mt-4">
                            <h2 class="heading"><span>Add New Lecture</span></h2>
                            <div class="col-sm-4 mt-5">
                                <div style="margin: 25px 0">
                                    <form action="../../Controller/Course_Time_Handling.php" method="POST">
                                        <div class="Center_Home_Form">
                                            <div  class="Center_Home_Input">
                                                <label for="Course_ID">Course Name: </label>
                                                <select required name="Course_ID" id="Course_ID" class="Insert-Room"  style="width: 100%">
                                                    <option selected disabled>
                                                        Choose Course Name
                                                    </option>
                                            <?php
                                            $data = $center->ReturnCourses($conn);
                                            while($row = $data->fetch_assoc()){
                                                $dr = $center->GetDoctorName($conn,$row['Course_ID']);
                                                ?>
                                                <option value="<?php echo $row['Course_ID'] ?>">
                                                    <?php
                                                    echo $row['Name'].' / '.$dr;
                                                    ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                                </select>
                                            </div>
                                            <div class="Center_Home_Input">
                                                <label for="Course_Day">Day:</label>
                                                <select required name="Course_Day" id="Course_Day" class="Insert-Room"  style="width: 100%">
                                                    <option selected disabled>
                                                        Choose Day
                                                    </option>
                                                    <?php
                                                    $timestamp = strtotime('next Sunday');
                                                    $days = array();
                                                    for ($i = 0; $i < 7; $i++) {
                                                        ?>
                                                        <option value="<?php echo strftime('%a', $timestamp) ?>">
                                                            <?php
                                                            echo strftime('%a', $timestamp);
                                                            ?>
                                                        </option>
                                                        <?php
                                                        $timestamp = strtotime('+1 day', $timestamp);
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div  class="Center_Home_Input">
                                                <label for="Course_Time">Time: </label>
                                                <input required name="Course_Time" id="Course_Time" class="Insert-Room"  style="width: 100%" step="1" type="time">
                                            </div>
                                            <div  class="Center_Home_Input">
                                                <label for="Course_Period">Duration: </label>
                                                <input required name="Course_Period" id="Course_Period" class="Insert-Room" min="01:00" max="10:00" step="1"  style="width: 100%" type="time">
                                            </div>
                                        </div>
                                        <div style="margin:10px;text-align: -webkit-center;">
                                            <button type="Submit" name="Insert-Course-Time" class='button -blue center'>Insert</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- row-->
                </div><!-- container -->
                <div class="activity-data">
                    <table id="myTable">
                        <tr>
                            <th>
                                <p>No.</p>
                            </th>
                            <th>
                                <p>Course Name</p>
                            </th>
                            <th>
                                <p>Dr. Name</p>
                            </th>
                            <th>
                                <p>Day</p>
                            </th>
                            <th>
                                <p>Start Time</p>
                            </th>
                            <th>
                                <p>Duration</p>
                            </th>
                            <th>
                                <p>Students Enrolled</p>
                            </th>
                            <th>
                                <p>Edit</p>
                            </th>
                            <th>
                                <p>Delete</p>
                            </th>
                        </tr>
                        <?php
                        $data = $center->ReturnAllCourseTime($conn);
                        $i=1;
                        while($row = $data->fetch_assoc()){
                            ?>
                            <tr style="text-align: -webkit-center;">
                                <td>
                                    <p>
                                        <?php echo $i; ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['Name']?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php
                                        echo "Dr. " . $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'];
                                        ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['Day']; ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['Time'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['Period'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $center->GetEnrolledStudents($conn, $row['Course_Time_ID']) ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <button style="border:none;background:inherit;" onClick="EditLecture(<?php echo $row['Course_Time_ID'] ?>, <?php echo $row['Course_ID'] ?>)">
                                            <img alt="edit" style="vertical-align: bottom;" src="../../Images/pencil_icon-2.png">
                                        </button>
                                    </p>
                                </td>
                                <td>
                                    <button style="border:none;background:inherit;" onClick="window.location.href='../../Controller/Course_Time_Handling.php?Course_Time_ID=<?php echo $row['Course_Time_ID'] ?>&Delete_Course_Time'">
                                        <img alt="delete" style="vertical-align: bottom;" src="../../Images/cancel.png">
                                    </button>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="../JS/jquery-2.2.3.min.js"></script>
    <script src="../JS/Center_Lectures.js"></script>
    <script>
        let error = (document.location.href).split("?");
        if(error[1] === "Time-Error"){
            sweetAlert({
                type: 'error',
                title: 'Oops...',
                text: "You can't create this lecture due to interferes with other lecture for the same course",
            });
        }else if(error[1] === "Missing-Data"){
            sweetAlert({
                type: 'error',
                title: 'data missing',
                text: "Please fill all lecture data"
            });
        }else if(error[1] === "Not-Authorized"){
            sweetAlert({
                type: 'error',
                title: 'Oops...',
                text: "You are not authorized to do this action"
            });

        }

        function EditLecture(id,course_id){
            sweetAlert({
                title: 'Edit Lecture Timing',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                html: '<form action="../../Controller/Course_Time_Handling.php" method="post"><div class="Center_Home_Form"><div class="Center_Home_Input2"> <label for="Course_Day">Day:</label><select required name="Course_Day" id="Course_Day" class="Insert-Room"  style="width: 100%"><option selected disabled>Choose Day</option><?php $timestamp = strtotime("next Sunday");$days = array();for ($i = 0; $i < 7; $i++) {?><option value="<?php echo strftime("%a", $timestamp) ?>"><?php echo strftime("%a", $timestamp);?></option><?php $timestamp = strtotime("+1 day", $timestamp);}?></select></div><div  class="Center_Home_Input2"><label for="Course_Time">Time: </label><input required name="Course_Time" id="Course_Time" class="Insert-Room"  style="width: 100%" step="1" type="time"></div><div  class="Center_Home_Input2"><label for="Course_Period">Duration: </label><input required name="Course_Period" id="Course_Period" class="Insert-Room" min="01:00" max="10:00" step="1"  style="width: 100%" type="time"></div></div><div style="margin:10px;text-align: -webkit-center;"> <button type="Submit" name="Edit-Course-Time" class="button -blue center">Update</button></div><input type="text" hidden value="'+id+'" name="Edit-Lecture-Id"><input type="text" hidden value="'+course_id+'" name="Edit-Lecture-course-Id"></form>',
                onClose: function (result) {
                    if (!result) {
                        // Handle the Cancel button click here if needed
                        // For example, you might want to display a message or perform other actions
                    }
                }
            });

        }
    </script>
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