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
        <link rel="stylesheet" href="../CSS/QAAACenter_Student_List.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <!----------------js---------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <li class="menuItem active">
                <a href="Center_requests.php" class="menuOption">
                    <i class="fa-solid fa-user" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Student Requests</h5>
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
        <div style="margin-bottom: 50px" class="content">
            <div class="overview">
                <div class="title">
                    <div class="titlesmall">
                        <i class="fa fa-table"></i>
                        <span class="text"><?php
                            if (isset($_GET['Year'])){
                                echo 'Viewing '.$_GET['Year'].' Students';
                            }else{
                                echo 'All Students';
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="searches">
                <input type="text" id="myNames" onkeyup="searchNames()" placeholder="Search by name.." title="Type in a name">
                <input type="text" id="myIDs" onkeyup="searchIDs()" placeholder="Search by ID.." title="Type in an ID">
                <input type="text" id="myLevels" onkeyup="searchLevel()" placeholder="Search by Grade.." title="Type in a level">
                <input type="text" id="myEmails" onkeyup="searchEmail()" placeholder="Search by Email.." title="Type in a Email">
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
                                ID
                            </p>
                        </th>
                        <th>
                            <p>
                                Name
                            </p>
                        </th>
                        <th>
                            <p>
                                Email
                            </p>
                        </th>
                        <th>
                            <p>
                                Phone
                            </p>
                        </th>
                        <th>
                            <p>
                                Family Phone
                            </p>
                        </th>
                        <th>
                            <p>
                                Guardian Name
                            </p>
                        </th>
                        <th>
                            <p>Age</p>
                        </th>
                        <th>
                            <p>School Name</p>
                        </th>
                        <th>
                            <p>Grade</p>
                        </th>
                        <th>
                            <p>Registered Course</p>
                        </th>
                        <th>
                            <p>Accept</p>
                        </th>
                        <th>
                            Delete
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $data = $center->GetAllRequests($conn);
                    $i = 1;

                    while($row = $data->fetch_assoc()){
                        ?>


                        <tr>
                            <td>
                                <p>
                                    <?php echo $i ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['Student_ID'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['F_Name'] . " " . $row['M_Name'] . " " . $row['L_Name'] ?>
                                </p>
                            </td>
                            <td>
                                <div style="display: flex;align-items: center;height:100%;justify-content: center;">
                                    <p>
                                        <?php echo $row['Email'] ?>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['Phone'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['Relation_Name'] . ": " . $row['Relation_Phone'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['Parent_Name'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['Age'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['School_Name'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['Grade'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo $row['Course'] ?>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <button style="border:none;background:inherit;<?php if(isset($_GET['Year'])){echo'display:none';}?>" onClick="window.location.href='Center_Add_Student.php?Student_ID=<?php echo $row['Student_ID'] ?>&Submit_Request'">
                                        <img alt="delete" style="vertical-align: bottom;" src="../../Images/accept.png">
                                    </button>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <button style="border:none;background:inherit;<?php if(isset($_GET['Year'])){echo'display:none';}?>" onClick="window.location.href='../../Controller/Student_Handling.php?Student_ID=<?php echo $row['Student_ID'] ?>&Delete_request'">
                                        <img alt="delete" style="vertical-align: bottom;" src="../../Images/cancel.png">
                                    </button>
                                </p>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="edit-window">
                <div class="details">
                    <p>Name: Ahmed Khaled</p>
                    <p>ID: 100122</p>
                </div>
                <div class="edit-on-stu">
                    <button class="btn-lec">Add lecture</button>
                    <button class="btn-lec">Remove lecture</button>
                </div>
                <div class="remove">
                    <button class="btn-rem">Remove from system</button>
                </div>
                <div class="cancel">
                    <button>cancel</button>
                </div>
            </div>
        </div>
    </section>
    <script src="../JS/jquery-2.2.3.min.js"></script>
    <script src="../JS/Center_Student_List.js"></script>
    <script src="../JS/modernizr.custom.80028.js"></script>
    <script>
        let error = (document.location.href).split("?");
        if(error[1] === "Email-Exist"){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Email Already Exist"
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
        function verigo(id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //Create the element using the createElement method.
                    var myDiv = document.createElement("div");

                    //Set its unique ID.
                    myDiv.id = 'note';
                    myDiv.style.cssText = 'color:#fff';
                    //Add your content to the DIV
                    myDiv.innerHTML = "Verification Sent!";

                    //Finally, append the element to the HTML body
                    document.body.appendChild(myDiv);
                }
            };
            xhttp.open("GET", `https://brightside-edu.com/Controller/Student_Handling.php?Student_ID=${id}&Reverify_Student`, false);
            xhttp.send();
        }

    </script>
    </body>
    </html>
    <?php
}
?>