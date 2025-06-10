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
       <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <title>Create Course</title>
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
        <li class="menuItem active" <?php if(isset($_GET['Year'])){ echo 'style="background-color: #F0A61F";';}?>>
            <a href="Center_course.php" class="menuOption">
                <i class="fa-solid fa-graduation-cap" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Courses <?php if(isset($_GET['Year'])){ echo '(Archives)';}?></h5>
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
                <div class="title">
                    <i class="uil uil-book"></i>
                    <span class="text">
                        <?php
                        if (isset($_GET['Year'])){
                            echo 'Viewing '.$_GET['Year'].' Courses';
                        }else{
                            echo 'Courses';
                        }
                        ?>
                    </span>
                </div>
                <div class="container" style="margin-bottom: 2%;">
                    <div class="row">
                        <div class="header-border mt-4">
                            <h2 class="heading"><span>Add Course</span></h2>
                            <div class="col-sm-4 mt-5">
                                <div style="margin: 25px 0">
                                    <form action="../../Controller/Course_Handling.php" method="POST">
                                        <div class="Center_Home_Form">
                                            <div  class="Center_Home_Input">
                                                <label for="Course_Name">Course: </label>
                                                <select required name="Course_Name" id="Course_Name" class="Insert-Room"  style="width: 80%" type="text">
                                                    <option value="Accounting">Accounting</option>
                                                    <option value="Maths">Maths</option>
                                                    <option value="Chemistry">Chemistry</option>
                                                    <option value="Physics">Physics</option>
                                                    <option value="Biology">Biology</option>
                                                    <option value="English">English</option>
                                                    <option value="French">French</option>
                                                    <option value="ICT">ICT</option>
                                                    <option value="Computer science">Computer science</option>
                                                    <option value="Combined science">Combined science</option>
                                                    <option value="Global prospective">Global prospective</option>
                                                    <option value="Business">Business</option>
                                                    <option value="Economics">Economics</option>
                                                    <option value="Sociology">Sociology</option>
                                                    <option value="Psychology">Psychology</option>
                              
                              <option value="Environmental">Environmental Managment</option>                 </select>
                                            </div>
                                            <div  class="Center_Home_Input">
                                                <label for="Course_Level">Course Level: </label>
                                                <select required name="Course_Level" id="Course_Level" class="Insert-Room"  style="width: 80%" type="text">
                                                    <option value="Core">Core</option>
                                                    <option value="OL">OL</option>
                                                    <option value="AS-CAMB">AS Cambridge</option>
                                                    <option value="AS-EDEX">AS Edexcel</option>
                                                    <option value="A2">A2</option>
                                                </select>
                                            </div>
                                            <div  class="Center_Home_Input">
                                                <label for="Course_Session">Session: </label>
                                                <select required name="Course_Session" id="Course_Session" class="Insert-Room"  style="width: 80%" type="text">
                                                    <option value="June">June</option>
                                                    <option value="Nov">November</option>
                                                </select>
                                            </div>
                                            <div  class="Center_Home_Input">
                                                <label for="Course_Year">Year: </label>
                                                <input required name="Course_Year" id="Course_Year" class="Insert-Room"  style="width: 80%" type="text" value="<?php echo date('Y');?>" placeholder="<?php echo date('Y')?>">
                                            </div>
                                            <div class="Center_Home_Input">
                                                <label for="Admin_ID">Dr. Name:</label>
                                                <select required name="Admin_ID" id="Admin_ID" class="Insert-Room"  style="width: 80%">
                                                    <option selected disabled>
                                                        Choose Dr. Name
                                                    </option>
                                                    <?php
                                                    $data = $center->GetAllAdmins($conn);
                                                    while($row = $data->fetch_assoc()){
                                                        ?>
                                                        <option value="<?php echo $row['Admin_ID'] ?>">
                                                            <?php
                                                            echo "Dr. " . $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'];
                                                            ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="margin:10px;text-align: -webkit-center;">
                                            <button type="Submit" name="Insert-Course" class='button -blue center'>Insert</button>
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
                                <p>Students Enrolled</p>
                            </th>
                            <th>
                                <p>View Students</p>
                            </th>
                            <th>
                                Course status
                            </th>
                            <th>
                                <p>Remove</p>
                            </th>
                        </tr>
                        <?php
                        if (isset($_GET['Year'])){
                            $data = $center->ReturnOldCourses($conn,$_GET['Year']);
                            $i=1;
                        }else{
                            $data = $center->ReturnCourses($conn);
                            $i=1;
                        }

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
                                        if (isset($_GET['Year'])){
                                            $drnamee = $center->GetOldDoctorName($conn, $row['Course_ID'], $_GET['Year']);
                                        }else{
                                            $drnamee = $center->GetDoctorName($conn, $row['Course_ID']);
                                        }
                                        echo "Dr. " . $drnamee;
                                        ?>
                                    </p>
                                </td>
                                <td>
                                    <p>

                                        <?php
                                        if (isset($_GET['Year'])){
                                            echo $center->GetOldUsersEnrolledCount($conn, $row['Course_ID'], $_GET['Year']);
                                        }else{
                                            echo $center->GetUsersEnrolledCount($conn, $row['Course_ID']);
                                        }
                                         ?>
                                    </p>
                                </td>
                            <td class="att-show">
                                <button  onClick="window.location.href='Course_S_View.php?Course_ID=<?php echo $row['Course_ID']; if (isset($_GET['Year'])){ echo'&Year='.$_GET['Year'];} ?>'">
                                    View
                                </button>                        
                            </td>
                                <td class="att-show">
                                    <?php
                                    if($row['stat']=='0'){


                                    ?>
                                        <button  onClick="window.location.href='../../Controller/Course_Handling.php?Course_ID=<?php echo $row['Course_ID'] ?>&Enable_Course'">
                                            Enable
                                        </button>

                                    <?php
                                    }else{
                                    ?>
                                        <button  onClick="window.location.href='../../Controller/Course_Handling.php?Course_ID=<?php echo $row['Course_ID'] ?>&Disable_Course'">
                                            Disable
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button style="border:none;background:inherit;" onClick="window.location.href='../../Controller/Course_Handling.php?Course_ID=<?php echo $row['Course_ID'] ?>&Delete_Course'">
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
    <script src="../JS/Center_Lectures.js"></script>
    <script>
        let error = (document.location.href).split("?");
        if(error[1] === "Already-Exist"){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Course Already Exist"
            })
        }else if(error[1] === "Missing-Data"){
            Swal.fire({
                icon: 'error',
                title: 'data missing',
                text: "Please fill all course data"
            })
        }else if(error[1] === "Not-Authorized"){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Your are not authorized to do this action"
            })
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