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
$courseCount = $center->sessionnumber($conn,$day);
$students = $center->expect($conn,$day);
$totals = $center->stucount($conn);
$gr9 = $center->gr9stucount($conn);
$gr10 = $center->gr10stucount($conn);
$gr11 = $center->gr11stucount($conn);
$gr12 = $center->gr12stucount($conn);
$sundaystu = $center->dayStu($conn, 'Sun');
$mondaystu = $center->dayStu($conn, 'Mon');
$tuesdaystu = $center->dayStu($conn, 'Tue');
$wednesdaystu = $center->dayStu($conn, 'Wed');
$thursdaystu = $center->dayStu($conn, 'Thu');
$fridaystu = $center->dayStu($conn, 'Fri');
$saturdaystu = $center->dayStu($conn, 'Sat');
$todaycoursesnames = $center->GetAvailableCoursesToLectureslist($conn,$day);
$coursedataresult = "'" . implode ( "', '", $todaycoursesnames ) . "'";
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../CSS/dashboardnew.css">
    <link rel="stylesheet" href="../CSS/UQr_Screen.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin-Home</title>
</head>
<body>
<div id="big">
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
            <li class="menuItem active">
                <a href="dashboard.php" class="menuOption">
                    <i class="fa-solid fa-database" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Overview</h5>
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
            <li class="menuItem">
                <a href="Center_Student_List.php" class="menuOption">
                    <i class="fa-solid fa-user"></i><h5 class="menuText open2">Student List</h5>
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

        </div>
        <div class="themeBar">
            <div>
                <button id="themeChangeBtn"><i class="fas " style="color: #fff"></i></button>
            </div>
        </div>
    </nav>
    <section class="dashboard">
        <center>
            <img style="width:300px;" class="CodeOlogyLogo" src="../../Images/COedu.png" alt="">
        </center>
        <!--<div class="CodeOlogyLogo-container">
            <img class="CodeOlogyLogo" src="../../Images/COedu.png" alt="">
        </div>-->

        <div class="container-fluid py-4" style="">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Date</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            <?php echo $date;?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid fa-school" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">For Today</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            <?php echo $courseCount;?> Sessions
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid fa-chalkboard-user" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">We expect tod.</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            <?php echo $students;?> Student
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid fa-user" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Total BS Students:</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            <?php echo $totals;?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa-solid fa-user" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="d-flex flex-column h-100">
                                        <p class="mb-1 pt-2 text-bold">Welcome,</p>
                                        <h5 class="font-weight-bolder"><?php echo $center->getName();?></h5>
                                        <p class="mb-5">All operations are running smoothly, enjoy your day :)</p>
                                        <center><h6 style="color: #000;" id="time"></h6></center>
                                        <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto">
                                            Support: Geeksupport@codeology.digital

                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                                    <div class="bg-gradient-primary border-radius-lg h-100">

                                        <div class="position-relative d-flex align-items-center justify-content-center h-100">
                                            <img class="w-100 position-relative z-index-2 pt-4" style="bottom: 11px;" src="https://cdn.dribbble.com/users/2879528/screenshots/6471331/b9cac263-9f46-4fee-8b67-2c695c530ce8_4x.jpeg" alt="rocket">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card h-100 p-3">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-5 mb-lg-0 mb-4">
                <div class="card z-index-2">
                    <div class="card-body p-3">
                        <div style="width: 440px;">
                            <div class="card-header pb-0">
                                <h6>Today's Sessions Overview</h6>
                                <p class="text-sm">

                            <span class="font-weight-bold"><?php echo date('D')?>, <?php echo date('d')." ".date('M')?>
                                </p>
                            </div>
                            <div class="card-body p-3">
                                <div class="timeline timeline-one-side">
                                    <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="ni ni-bell-55 text-success text-gradient"></i>
                  </span>
                                        <?php
                                        $date = date('d')."/".date('m')."/".date('Y');
                                        $day = date('D');
                                        $data = $center->GetAvailableCoursesToLecturestwo($conn, $day);
                                        while($row = $data->fetch_assoc()){
                                            $time = strtotime($row['Time']);
                                            $period = strtotime($row['Period']);
                                            $secs = $period-strtotime("00:00:00");
                                            $result = date("H:i:s",$time+$secs);
                                            echo '                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">'.$row['Name'].'</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">('  . $row['Time'] . ' -> ' . $result . ' )</p>
                                </div>
                            </div>
                            <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="ni ni-html5 text-danger text-gradient"></i>
                  </span>';
                                        }
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" style="width:28.333333%;height:310px;">
                <div class="card h-100">
                    <div style="width: 300px;">
                        <canvas id="sstudist"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-8" style="width:28.333333%;height:310px;">
                <div class="card h-100">
                    <div style="width: 300px;">
                        <canvas id="ssstudist"></canvas>
                    </div>
                </div>
            </div>

        </div>

</div>
</section>
</div>

<div id="small">
    <div class="smsc">
        <img src="https://brightside-edu.com/Images/sm.png" style="width: 150px;">
        <h3 style="font-size: 18px;color:#fff"><?php echo $center->getName(); ?></h3>
        <h3 style="font-size: 18px;color:#fff">Woops! Looks like you're using a small screen, open from a larger screen to access the system!</h3>
        <h3 style="font-size: 15px;color:#fff">Need To scan a Qr Code?</h3>
        <button type="button" onclick="StartScan()" class="scan-button" style="background-color: #F0A61F;">
            Scan
            <i class="fa-solid fa-qrcode"></i>
        </button>

        <a href="../../Controller/logout.php"  class="scan-button">
            Logout
            <i class="uil uil-signout"></i>
        </a>
    </div>
</body>

</main>


</div>
</div>
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
<script>
    var timeDisplay = document.getElementById("time");


    function refreshTime() {
        const now = new Date()
            .toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            })
            .toLowerCase();
        timeDisplay.innerHTML = now;
    }

    setInterval(refreshTime, 1000);
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../JS/jquery-2.2.3.min.js"></script>
<script src="../JS/Center_Home.js"></script>
<script src="../JS/html5-qrcode.min.js"></script>
<script type="text/javascript"src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
            datasets: [{
                label: 'Traffic / Day',
                data: ['<?php echo $sundaystu?>','<?php echo $mondaystu?>','<?php echo $tuesdaystu?>','<?php echo $wednesdaystu?>','<?php echo $thursdaystu?>','<?php echo $fridaystu?>','<?php echo $saturdaystu?>'],
                borderWidth: 1,
                backgroundColor: [
                    '#174074',
                    '#F0A61F',
                    '#174074',
                    '#F0A61F',
                    '#174074',
                    '#F0A61F',
                    '#174074'
                ],
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }

            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctxx = document.getElementById('sstudist');

    new Chart(ctxx, {
        type: 'pie',
        data: {
            labels: ['Grade 9','Grade 10','Grade 11','Grade 12'],
            datasets: [{

                data: ['<?php echo $gr9?>','<?php echo $gr10?>','<?php echo $gr11?>','<?php echo $gr12?>'],
                borderWidth: 1,
                backgroundColor: [
                    '#c9c9c9',
                    '#339dce',
                    '#174074',
                    '#F0A61F',
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Student Distribution'
                }
            }
        },
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctxxx = document.getElementById('ssstudist');

    new Chart(ctxxx, {
        type: 'doughnut',
        data: {
            labels: [<?php echo($coursedataresult)?>],
            datasets: [{

                data: ['9','10'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Under Development, ignore this graph'
                }
            }
        },
    });
</script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
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
    alert(error[1])
    if(error[1] === "success"){
        alert("hi")
        let lecture_name =  error[2];
        Swal.fire({
            icon: 'success',
            title: 'Done',
            text: "User Attend Successfully in course " + decodeURIComponent(lecture_name),
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonText: "Scan again",
        }).then((result) => {
            if (result.isConfirmed) {
                StartScan();
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
<?php
}
?>
