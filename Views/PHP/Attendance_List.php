<?php
require_once "../../DB/attendance_db.php";
require_once "../../Models/Center.php";
require_once "../../Models/Doctor.php";

session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    $center = unserialize($_SESSION['Center-Attendance-System-1']);
}else{
    if(isset($_SESSION['Doctor-Attendance-System-1'])){
        $doctor = unserialize($_SESSION['Doctor-Attendance-System-1']);
    }else{
        header("Location: ../../index.php");
    }
}
if(isset($conn) && ((isset($doctor) && ($doctor instanceof Doctor))  || (isset($center) && ($center instanceof Center))) && isset($_GET['Lecture_ID'])){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/QAttendance.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
        <script type="text/javascript" src="../JS/html2canvas.js"></script>
        <title>Attendance</title>
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
                <i class="fa-solid fa-database" ></i><h5 class="menuText open2" >Overview</h5>
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
        <li class="menuItem active">
            <a href="Center_Lecture_List.php" class="menuOption">
                <i class="fa-solid fa-clipboard-user" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Attendance Reports</h5>
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
      <div class="notch">
<h3 style="padding-left: 22%;margin-top: 0%;color: #F0A61F;"><?php echo $center->getName(); ?></h3>
  </div>
        <div class="CodeOlogyLogo-container">
            <img class="CodeOlogyLogo" src="../../Images/COedu.png" alt="">
        </div>

        <div style="margin-bottom: 50px" class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-dashboard"></i>
                    <span class="text">Overview</span>
                </div>
                <div class="boxes">
                    <div class="box box1" onclick="getFinished('attendance_selector')">
                        <span class="text">All Students</span>
                        <span class="number"><?php echo ($_GET['Attend_Count'] + $_GET['Absent_Count']) ?></span>
                    </div>
                    <div class="box box2" onclick ="getFinished('attend')">
                        <span class="text">Students attended</span>
                        <span class="number"><?php echo $_GET['Attend_Count'] ?></span>
                    </div>
                    <div class="box box3" onclick="getFinished('not_attend')">
                        <span class="text">Students absent</span>
                        <span class="number"><?php echo $_GET['Absent_Count'] ?></span>
                    </div>
                </div>
            </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-book"></i>
                    <?php
                    $data = NULL;
                    if (isset($_GET['Year'])){
                        if(isset($center)){
                            $data = $center->GetOldAttendanceListForLectureByID($conn, $_GET['Lecture_ID'], $_GET['Year']);
                        }
                        $i=1;
                    }else{
                        if(isset($center)){
                            $data = $center->GetAttendanceListForLectureByID($conn, $_GET['Lecture_ID']);
                        }
                        $i=1;
                    }
                        $row = $data->fetch_assoc()
                        ?>
                    <span class="text"><?php if (isset($_GET['Year'])){echo $_GET['Year'].' Archives<br>';}?> Attendance for <?php echo $row['C_Name'];?><br>on <?php echo $row['L_NAme'];?></span>
                </div>
                <div class="activity-data" id="Attendance-Report">
<table id="myTable">
                        <tr>
                            <th>
                                <p>No.</p>
                            </th>
                            <!--<th>
                                <p>Course Name</p>
                            </th>
                            <th>
                                <p>Lecture Name</p>
                            </th>-->
                            <th>
                                <p>Student Name</p>
                            </th>
                            <th>
                                <p>Arrival Time</p>
                            </th>
                            <th>
                                <p>State</p>
                            </th>
                            <th>
                                <p>Change State</p>
                            </th>
                        </tr>
                        <?php
                        $data = NULL;
                        if (isset($_GET['Year'])){
                            if(isset($center)){
                                $data = $center->GetOldAttendanceListForLectureByID($conn, $_GET['Lecture_ID'], $_GET['Year']);
                            }
                            $i=1;
                        }else{
                            if(isset($center)){
                                $data = $center->GetAttendanceListForLectureByID($conn, $_GET['Lecture_ID']);
                            }
                            $i=1;
                        }

                        while($row = $data->fetch_assoc()){
                            ?>
                            <tr class="attendance_selector <?php
                            if($row['State'] == "ATTENDED"){
                                echo "attend";
                            }else{
                                echo "not_attend";
                            }
                            ?>">
                                <td>
                                    <p>
                                        <?php echo $i; ?>
                                    </p>
                                </td>
                                <!--<td>
                                    <p>
                                        <?php echo $row['C_Name']; ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php echo $row['L_NAme']; ?>
                                    </p>
                                </td>-->
                                <td>
                                    <p>
                                        <?php echo $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name']; ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php
                                        if($row['Arrival_Time'] && $row['State'] == "ATTENDED"){
                                            echo $row['Arrival_Time'];
                                        }else{
                                            echo "--:--";
                                        }
                                        ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="<?php
                                    if($row['State'] == "ATTENDED"){
                                        echo "deadline1";
                                    }else{
                                        echo "deadline";
                                    }
                                    ?>">
                                        <?php
                                        if($row['State'] == "ATTENDED"){
                                            echo "Attended";
                                        }else{
                                            echo "Absent";
                                        }
                                        ?>
                                    </p>
                                </td>
                                <td>
                                    <button type="button" onClick="window.location.href='../../Controller/Change_Attendance_System.php?From=<?php if(isset($center))echo "1";else if(isset($doctor))echo "2"; ?>&Lecture_ID=<?php echo $row['Lecture_ID'] ?>&Student_ID=<?php echo $row['Student_ID'] ?>&UserState=<?php if($row['State'] == "ATTENDED"){echo "1";}else{echo "2";} ?>&ChangeUserState'" class="att-btn">
                                        <?php
                                        if($row['State'] == "ATTENDED"){
                                            echo "Absent";
                                        }else{
                                            echo "Attend";
                                        }
                                        ?>
                                    </button>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                </div>
                <div class="lastRow">
                    <button id="fileDownload" class="savePDF"><i class="uil uil-file-download-alt" id="fileDown"></i> save as PDF</button>
                </div>
            </div>
        </div>
    </section>
    <script src="../JS/Attendance.js"></script>
    <script>
        window.jsPDF = window.jspdf.jsPDF;
        let pdf = new jsPDF('l', 'px',[document.getElementById('Attendance-Report').clientWidth + 100,document.getElementById('Attendance-Report').clientHeight + 100]);
        window.html2canvas = html2canvas
        const data = document.getElementById('Attendance-Report');
        $("#fileDownload").click(function () {
            pdf.html(data, {
                'margin' : 20,
                callback: function (pdf) {
                    <?php
                    if(isset($center)){
                        $data = $center->CourseNameAndLectureName($conn, $_GET['Lecture_ID']);
                        ?>
                    let report_name = "<?php echo $data['Course_Name'] . ' ' . $data['Lecture_Name'] ?>";
                    pdf.save(report_name + ' attendance report.pdf');
                        <?php
                    }
                    ?>
                }
            });
        });
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
}else{
    header("Location: ../../index.php");
}
?>