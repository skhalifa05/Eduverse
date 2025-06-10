<?php
require_once "../../DB/attendance_db.php";
require_once "../../Models/Center.php";
session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}
if(isset($conn) && isset($center) && ($center instanceof Center) && isset($_GET['Year'])){
    $archyear = $_GET['Year']
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/Center_archives.css">
        <!----===== Iconscout CSS ===== -->
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
            <li class="menuItem active">
                <a href="Center_archives.php" class="menuOption">
                    <i class="fa-solid fa-book" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Archives</h5>
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
                        <span class="text">Archives <?php echo $archyear?></span>
                    </div>

                </div>
                <div  class="container" style="justify-content: center">
                    <div onclick="window.location.href='Center_Student_List.php?Year=<?php echo $_GET['Year']?>'" class="card">
                        <div class="iconn">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>
                        <!--<div class="imgBx">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>-->

                        <div class="contentBx">

                            <h1 style="color: #FFFFFF; font-size: 19px;">Students</h1>
                            <h3 style="color: #FFFFFF; font-size: 16px;">November, june Sessions</h3>

                        </div>

                    </div>

                    <div onclick="window.location.href='Center_Lecture_List.php?Year=<?php echo $_GET['Year']?>'" class="card">
                        <div class="iconn">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>
                        <!--<div class="imgBx">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>-->

                        <div class="contentBx">

                            <h1 style="color: #FFFFFF; font-size: 19px;">Attendance Reports</h1>
                            <h3 style="color: #FFFFFF; font-size: 16px;">November, june Sessions</h3>

                        </div>

                    </div>

                    <div onclick="window.location.href='Center_course.php?Year=<?php echo $_GET['Year']?>'" class="card">
                        <div class="iconn">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>
                        <!--<div class="imgBx">
                            <img src="https://brightside-edu.com/Images/coedublack.png" alt="Codeology Education">
                        </div>-->

                        <div class="contentBx">

                            <h1 style="color: #FFFFFF; font-size: 19px;">Courses</h1>
                            <h3 style="color: #FFFFFF; font-size: 16px;">November, june Sessions</h3>

                        </div>

                    </div>
                </div>
            </div>
    </section>

    <script src="../JS/jquery-2.2.3.min.js"></script>
    <script src="../JS/Center_Home.js"></script>
    <script src="../JS/html5-qrcode.min.js"></script>

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