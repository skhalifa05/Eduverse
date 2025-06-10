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
    $date = date('d')."/".date('m')."/".date('Y');
    $day = date('D');
    $dataaaa = $center -> CheckDay($conn, $day);
    while ($row = $dataaaa->fetch_assoc()){
        $conf = $center->checklec($conn, $date, $row['Course_Time_ID']);
        if ($conf == 0)
        {
             $center->AddLecture($conn, $row['Course_Time_ID'], '-1', $date, "NOT-STARTED");
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/Final7Center_Home.css">
        <link rel="stylesheet" href="../CSS/UQr_Screen.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Admin-Home</title>
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
        <li class="menuItem active">
            <a href="Center_Home.php" class="menuOption">
                <i class="fa-solid fa-house" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Home</h5>
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

                <div class="scan-title">
                    <div class="title">
                        <i class="uil uil-book"></i>
                        <span class="text">Lecture Overview</span>
                    </div>
                    <div class="title">
                        <button type="button" onclick="StartScan()" class="scan-button">
                            Scan
                            <i class="fa-solid fa-qrcode"></i>
                        </button>
                    </div>
                </div>

                <div class="container">
<!--                    <div class="header-border mt-4">-->
<!--                        <h2 class="heading"><span>Add Extra Lecture</span></h2>-->
<!--                        <div class="col-sm-4 mt-5">-->
<!--                            <div style="margin: 55px 0">-->
<!--                                <form action="../../Controller/extralect.php" method="POST">-->
<!--                                    <div class="Center_Home_Form">-->
<!--                                        <div  class="Center_Home_Input">-->
<!--                                            <label for="Course_ID">Course Name: </label>-->
<!--                                            <select required name="Course_ID" id="Course_ID" class="Insert-Room"  style="width: 100%">-->
<!--                                                <option selected disabled>-->
<!--                                                    Choose Course Name-->
<!--                                                </option>-->
<!--                                                --><?php
//                                                $data = $center->ReturnCourses($conn);
//                                                while($row = $data->fetch_assoc()){
//                                                    ?>
<!--                                                    <option value="--><?php //echo $row['Course_ID'] ?><!--">-->
<!--                                                        --><?php
//                                                        echo $row['Name'];
//                                                        ?>
<!--                                                    </option>-->
<!--                                                    --><?php
//                                                }
//                                                ?>
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="Center_Home_Input">-->
<!--                                            <label for="date">Day:</label>-->
<!---->
<!--                                            <input  name="date" id="date" value="--><?php //echo $date;?><!--" class="Insert-Room"  style="width: 100%"  type="text" placeholder='--><?php //echo $date;?><!--'  readonly="readonly" />-->
<!---->
<!--                                        </div>-->
<!---->
<!--                                    </div>-->
<!--                                    <div style="margin:10px;text-align: -webkit-center;">-->
<!--                                        <button type="Submit" name="Insert-Extra-Time" class='button -blue center'>Insert</button>-->
<!--                                    </div>-->
<!--                                </form>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="card" style="height: 310px;width: 300px;background-color: #F0A61F;margin-bottom: 10px;margin-left: 0;">
                        <div class="iconn">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education" style="width: 170px">
                        </div>
                        <!--<div class="imgBx">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>-->

                        <div class="contentBx2">

                            <form action="../../Controller/extralect.php" method="POST">
                                <div class="Center_Home_Form">
                                    <div  class="Center_Home_Input">
                                        <label for="Course_ID" style="color:#174074;">Course Name: </label>
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
                                        <label for="date" style="color:#174074;">Day:</label>

                                        <input  name="date" id="date" value="<?php echo $date;?>" class="Insert-Room"  style="width: 100%"  type="text" placeholder='<?php echo $date;?>'  readonly="readonly" />

                                    </div>

                                </div>
                                <div style="margin:10px;text-align: -webkit-center;">
                                    <button type="Submit" name="Insert-Extra-Time" style="background: #174074" class='button -blue center'>Insert</button>
                                </div>
                            </form>
                            <center>

                                <h3 style="color: #174074">
                                    <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                    </span>
                                    Lecture</h3>
                            </center>
                        </div>

                    </div>
                    <?php
                    $data = $center->ReturnAllLecturesNotFinished($conn);
                    $i=1;
                    while ($row = $data->fetch_assoc()){
                        ?>
                    <div class="card">
                        <div class="iconn">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                            <?php
                            if($row['State'] === "STARTED") {
                                echo '<h5 style="margin-top:20%; margin-left:20%">'.$center->GetStudentCount($conn,$row['Lecture_ID']).' Students Present</h5>';
                            }
                            ?>
                        </div>
                        <!--<div class="imgBx">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>-->

                        <div class="contentBx">

                            <h3 style="color: #FFFFFF; font-size: 16px;"><?php echo $row['Course_Name'] ?></h3>

                            <div class="size">
                                <h4>Dr. <?php echo $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] ?></h4>
                            </div>

                            <div class="color">
                                <h5>Starts <?php echo $row['Time'] ?>, <?php echo $row['Period'] ?> hours</h5>
                            </div>

                            <div class="color" style="margin-top: 25px">

                                <span type="button" onclick="window.location.href='../../Controller/Room_Handling.php?State=<?php if($row['State'] === "STARTED"){echo 1;}else if($row['State'] === "NOT-STARTED"){echo 2;} ?>&Lecture_ID=<?php echo $row['Lecture_ID'] ?>&State_Button_Clicked'"  <?php if($row['State'] === "STARTED"){echo 'style="background: #FFFF00"';}else if($row['State'] === "NOT-STARTED"){echo ' style="background-color: #00fa9a"';}?>><center><?php if($row['State'] === "NOT-STARTED"){echo '<i style="margin-top: 7px;color: #174074;" class="fa fa-play"></i>';} elseif ($row['State'] === "STARTED"){echo '<i style="margin-top: 7px;color: #174074;" class="fa fa-pause"></i>';}?></center></span>
                                <span style="background: #ff0000" onClick="window.location.href='../../Controller/Room_Handling.php?State=<?php echo 3;?>&Lecture_ID=<?php echo $row['Lecture_ID'] ?>&State_Button_Clicked'"><i style="margin-top: 7px;color: #174074;" class="fa fa-trash"></i></span>
                            </div>

                        </div>

                    </div>
                        <?php
                        $i++;
                    }
                    ?>

                </div>
                <!--<div class="container" style="margin-bottom: 2%;">
                    <div class="row">
                        <div class="header-border mt-4">
                            <h2 class="heading"><span>Start Lecture</span></h2>
                            <div class="col-sm-4 mt-5">
                                <div style="margin: 25px 0">
                                    <form action="../../Controller/Room_Handling.php" method="POST">
                                        <div class="Center_Home_Form">
                                            <div class="Center_Home_Input">
                                                <label for="Course_Time_ID">Course Name: </label>
                                                <select required name="Course_Time_ID" id="Course_Time_ID" class="Insert-Room"  style="width: 100%">
                                                    <option selected disabled>
                                                        Choose course
                                                    </option>
                                                    <?php
                                                    $date = date('d')."/".date('m')."/".date('Y');
                                                    $day = date('D');
                                                    $data = $center->GetAvailableCoursesToLectures($conn, $day);
                                                    while($row = $data->fetch_assoc()){
                                                        ?>
                                                        <option value="<?php echo $row['Course_Time_ID'] ?>">
                                                            <?php
                                                            $time = strtotime($row['Time']);
                                                            $period = strtotime($row['Period']);
                                                            $secs = $period-strtotime("00:00:00");
                                                            $result = date("H:i:s",$time+$secs);
                                                            echo $row['Name'] . " / " . $row['Day'] . " ( " . $row['Time'] . " -> " . $result . " )";
                                                            ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="Center_Home_Input">
                                                <label for="Lecture_Name">Lecture Date </label>
                                                <input  name="Lecture_Name" id="Lecture_Name" value="<?php echo $date;?>" class="Insert-Room" style="width: 100%" type="text" placeholder="<?php echo $date;?>" readonly="readonly" >
                                            </div>
                                            <div class="Center_Home_Input">
                                                <label for="Device_ID">Reader </label>
                                                <select required name="Device_ID" id="Device_ID" class="Insert-Room"  style="width: 100%">
                                                    <option selected disabled>
                                                        Choose Device
                                                    </option>
                                                    <option value="-1">
                                                        Phone
                                                    </option>
                                                    <?php
                                                    $data = $center->GetAvailableDevices($conn);
                                                    while($row = $data->fetch_assoc()){
                                                        ?>
                                                        <option value="<?php echo $row['Device_ID'] ?>">
                                                            <?php
                                                            echo $row['Device_Name'];
                                                            ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="Center_Home_Input">
                                                <input id="Start-on-insert" type="radio" name="Start-on-insert">
                                                <label for="Start-on-insert">Start on Creation</label>
                                            </div>
                                        </div>
                                        <div style="margin:10px;text-align: -webkit-center;">
                                            <button type="Submit" name="Insert-Room" class='button -blue center'>Insert</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> row
                </div> container -->
<!--                <div class="activity-data">

                    <table id="myTable">
                        <tr>
                            <th>
                                <p>ID</p>
                            </th>
                            <th >
                                <p>Course Name</p>
                            </th>
                            <th>
                                <p>Lecture Name</p>
                            </th>
                            <th>
                                <p>Dr. Name</p>
                            </th>
                            <th>
                                <p>Start Time</p>
                            </th>
                            <th>
                                <p>Duration</p>
                            </th>
                            <th>
                                <p>Students in room</p>
                            </th>
                            <th>
                                <p>State</p>
                            </th>
                            <th>
                                <p>Change State</p>
                            </th>
                            <th>
                                <p>Delete</p>
                            </th>
                        </tr>
                        <?php
                        $data = $center->ReturnAllLecturesNotFinished($conn);
                        $i=1;
                        while ($row = $data->fetch_assoc()){
                            ?>
                            <tr style="text-align: -webkit-center;">
                                <td>
                                    <p>
                                        <?php echo $i ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['Course_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['Lecture_Name'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        Dr. <?php echo $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] ?>
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
                                        <?php
                                        echo $center->GetStudentCount($conn,$row['Lecture_ID']);
                                        ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php
                                        if($row['State'] === "STARTED"){
                                            echo "Started";
                                        }else if($row['State'] === "NOT-STARTED"){
                                            echo "Not Started";
                                        }
                                        ?>
                                    </p>
                                </td>
                                <td>
    
                                    <button type="button" onclick="window.location.href='../../Controller/Room_Handling.php?State=<?php if($row['State'] === "STARTED"){echo 1;}else if($row['State'] === "NOT-STARTED"){echo 2;} ?>&Lecture_ID=<?php echo $row['Lecture_ID'] ?>&State_Button_Clicked'">
                                        <?php
                                        if($row['State'] === "STARTED"){
                                            echo "Finish";
                                        }else if($row['State'] === "NOT-STARTED"){
                                            echo "Start";
                                        }
                                        ?>
                                    </button>
                                </td>
                                <td>
                                    <button style="border:none;background:inherit;" onClick="window.location.href='../../Controller/Room_Handling.php?State=<?php echo 3;?>&Lecture_ID=<?php echo $row['Lecture_ID'] ?>&State_Button_Clicked'">
                                        <img alt="delete" style="vertical-align: bottom;" src="../../Images/cancel.png">
                                    </button>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                </div>-->
            </div>
        </div>
    </section>
    <div id="qr_screen" class="main-container-qr">
        <div class="inner-container-qr">
            <img class="qr-quit" onclick="StopScan()" alt="delete" src="../../Images/cancel.png">
            <h3 class="inner-header-qr">Qr Scanner</h3>
            <div class="inner-reader-qr">
                <div id="qr_reader" ></div>
            </div>
        </div>
    </div>
    <script src="../JS/jquery-2.2.3.min.js"></script>
    <script src="../JS/Center_Home.js"></script>
    <script src="../JS/html5-qrcode.min.js"></script>
    <script>
        let html5QrCode = new Html5Qrcode("qr_reader");
        const config = { fps: 15, qrbox: 200 };
        function StartScan(){
            document.getElementById("qr_screen").style.display = 'block';
            function qrCodeSuccessCallback(successMessage) {
                document.getElementById("qr_screen").style.display = 'none';
                html5QrCode.stop();
                let user_id = Number(successMessage);
                if(!isNaN(user_id)){
                    window.location.href="../../Controller/Student_Attend.php?user_id=" + successMessage + "&Student_attend";
                }
            }
            function qrCodeFailedCallback() {
                return null;
            }
            html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback, qrCodeFailedCallback)
        }
        function StopScan(){
            document.getElementById("qr_screen").style.display = 'none';
            html5QrCode.stop();
        }
        let error = (document.location.href).split("?");
        let show_error = false;
        let errorMessage = "";
        if(error[1] === "success"){
            let lecture_name =  error[2];
            sweetAlert({
                type: 'success', // 'type' is used instead of 'icon' in older versions
                title: 'Done',
                text: "User Attend Successfully in course " + decodeURIComponent(lecture_name),
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: "Scan again",
                onClose: function (result) {
                    if (result) {
                        StartScan();
                    }
                }
            });
        }else if(error[1] === "User_ID_Not_Found"){
            show_error = true;
            errorMessage = "User does not exist";
        }else if(error[1] === "User_Not_Enrolled"){
            show_error = true;
            errorMessage = "User isn't enrolled in any active lectures"
        }else if(error[1] === "User_State_Taken"){
            show_error = true;
            errorMessage = "User already attended you can check attendance list to make sure"
        }else if(error[1] === "No_Active_Lecture"){
            show_error = true;
            errorMessage = "User has no active lectures"
        }else if(error[1] === "Missing-Data"){
            sweetAlert("Data Missing", "Please fill all Lecture data", "error");
        }else if(error[1] === "Not-Authorized"){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Your are not authorized to do this action"
            })
        }else if(error[1] === "User-Not-Authorized"){
            sweetAlert("Oops...", "User email not authorized yet", "error");
        }
        if(show_error){
            sweetAlert({
                type: 'error', // 'type' is used instead of 'icon' in older versions
                title: 'Oops...',
                text: errorMessage,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: "Scan again",
                onClose: function (result) {
                    if (result) {
                        StartScan();
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