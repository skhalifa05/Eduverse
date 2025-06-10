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
    if(isset($_GET['Edit_Student'])){
        $user_data = $center->GetStudentData($conn, $_GET['Student_ID']);
        $courses_data = $center->GetStudentTimeTable($conn, $user_data['Student_ID']);
        $i = 1;
    }else if (isset($_GET['Submit_Request'])){
        $user_data = $center->GetstudentRequest($conn, $_GET['Student_ID']);
        $i = 1;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/QCenter_Add_Student.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
        <!----------------js---------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Add Student</title>
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
        <li class="menuItem active">
            <a href="Center_Add_Student.php" class="menuOption">
                <i class="fa-solid fa-user-plus" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Add Student</h5>
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
        <div style="margin-bottom: 50px" class="content">
            <div class="overview">
                <div class="title">
                    <div class="titlesmall">
                        <i class="uil uil-notes"></i>
                        <span class="text"><?php if(isset($_GET['Edit_Student'])){echo "Edit" ;}else{ echo "Register";}?> student</span>
                    </div>
                </div>
            </div>
            <div class="container">
                <header><?php if(isset($_GET['Edit_Student'])){echo "Editing" ;}else{ echo "Registration";}?></header>
                <form action="../../Controller/Add_Student.php" method="POST">
                    <div class="form first">
                        <div class="details personal">
                            <span class="title">Personal Details</span>
                            <div class="fields course_input">
                                <div class="input-field">
                                    <label for="F_Name">First Name</label>
                                    <input name="F_Name" value="<?php if(isset($user_data)){ echo $user_data['F_Name'];} ?>" id="F_Name" type="text" placeholder="Enter First Name" required>
                                </div>
                                <div class="input-field">
                                    <label for="M_Name">Middle Name</label>
                                    <input name="M_Name" value="<?php if(isset($user_data)){ echo $user_data['M_Name'];} ?>" id="M_Name" type="text" placeholder="Enter middle Name" required>
                                </div>
                                <div class="input-field">
                                    <label for="L_Name">Last Name</label>
                                    <input name="L_Name" id="L_Name" value="<?php if(isset($user_data)){ echo $user_data['L_Name'];} ?>" type="text" placeholder="Enter Last Name" required>
                                </div>
                                <div class="input-field">
                                    <label for="Email">Email</label>
                                    <input name="Email" id="Email" value="<?php if(isset($user_data)){ echo $user_data['Email'];} ?>" type="text" placeholder="Enter E-mail" required>
                                </div>
                                <div class="input-field">
                                    <label for="Phone">Phone</label>
                                    <input name="Phone" id="Phone" value="<?php if(isset($user_data)){ echo $user_data['Phone'];} ?>" type="text" placeholder="Enter Phone" required>
                                </div>
                                <div class="input-field">
                                    <label for="School_Name">School Name</label>
                                    <input name="School_Name" id="School_Name" value="<?php if(isset($user_data)){ echo $user_data['School_Name'];} ?>" type="text" placeholder="Enter School Name" required>
                                </div>
                                <div class="input-field">
                                    <label for="Grade">Grade</label>
                                    <select id="Grade" name="Grade" required>
                                        <option disabled selected>Select grade</option>
                                        <option  <?php if(isset($user_data)){
                                            if($user_data['Grade'] == 9){
                                            echo "selected";
                                            }
                                        } ?> value="9">9</option>
                                        <option <?php if(isset($user_data)){
                                            if($user_data['Grade'] == 10){
                                                echo "selected";
                                            }
                                        } ?> value="10">10</option>
                                        <option <?php if(isset($user_data)){
                                            if($user_data['Grade'] == 11){
                                                echo "selected";
                                            }
                                        } ?> value="11">11</option>
                                        <option <?php if(isset($user_data)){
                                            if($user_data['Grade'] == 12){
                                                echo "selected";
                                            }
                                        } ?> value="12">12</option>
                                    </select>
                                </div>
                                <div class="input-field">
                                    <label for="Age">Age</label>
                                    <input name="Age" id="Age" type="number" value="<?php if(isset($user_data)){ echo $user_data['Age'];} ?>" placeholder="Enter Age" required>
                                </div>
                                <div class="input-field">
                                    <label for="Relation_Name">Relation Name</label>
                                    <input name="Relation_Name" id="Relation_Name" value="<?php if(isset($user_data)){ echo $user_data['Relation_Name'];} ?>" type="text" placeholder="Enter Relation Name" required>
                                </div>
                                <div class="input-field">
                                    <label for="Parent_Name">Parent Name</label>
                                    <input name="Parent_Name" id="Parent_Name" value="<?php if(isset($user_data)){ echo $user_data['Parent_Name'];} ?>" type="text" placeholder="Enter Relation Name" required>
                                </div>
                                <div class="input-field">
                                    <label for="Parent_Phone">Parent Phone</label>
                                    <input name="Parent_Phone" id="Parent_Phone" value="<?php if(isset($user_data)){ echo $user_data['Relation_Phone'];} ?>" type="text" placeholder="Enter Phone" required>
                                </div>
                                <div class="input-field">
                                    <div style="display: flex;justify-content: space-between;align-items: center;">
                                        <label for="Course">Courses Enroll</label>
                                        <button class="add_button_course" id="add_button_course" type="button" style="border:none;background-color:black;width:30px;height:20px;margin:0;">
                                            <i class="far fa-plus-square"></i>
                                        </button>
                                        <button class="remove_button_course" id="remove_button_course" type="button" style="border:none;background-color:black;display:none;width:30px;height:20px;margin:0;">
                                            <i class="far fa-minus-square"></i>
                                        </button>
                                    </div>
                                    <select id="Course" name="Course" required>
                                        <option disabled selected>Select Course</option>
                                        <?php
                                        $data = $center->GetAvailableLectures($conn);
                                        if(isset($courses_data)){
                                            $course_id = $courses_data->fetch_assoc();
                                        }
                                        while($row = $data->fetch_assoc()){
                                            ?>
                                            <option <?php
                                            if(isset($course_id)){
                                                if($course_id['Course_Time_ID'] === $row['Course_Time_ID']){
                                                    echo "selected";
                                                }
                                            }
                                            ?> value="<?php echo $row['Course_Time_ID'] ?>">
                                                <?php
                                                $time = strtotime($row['Time']);
                                                $period = strtotime($row['Period']);
                                                $secs = $period-strtotime("00:00:00");
                                                $result = date("H:i:s",$time+$secs);
                                                $dr = $center->GetDoctorName($conn,$row['Course_ID']);
                                                echo $row['Name'] ."/ Dr.".$dr. " / " . $row['Day'] . " ( " . $row['Time'] . " -> " . $result . " )";
                                                ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                if(isset($courses_data) && isset($i)){
                                    while($row_for_course_select = $courses_data->fetch_assoc()){
                                        ?>
                                        <div class="input-field">
                                            <label for="Course<?php echo $i; ?>">Courses Enroll <?php echo $i; ?></label>
                                            <select id="Course<?php echo $i; ?>" name="Course<?php echo $i; ?>" required>
                                                <option disabled selected>Select Course</option>
                                                <?php
                                                $data = $center->GetAvailableLectures($conn);
                                                while($row = $data->fetch_assoc()){
                                                    ?>
                                                    <option <?php
                                                    if(isset($row_for_course_select)){
                                                        if($row_for_course_select['Course_Time_ID'] === $row['Course_Time_ID']){
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?> value="<?php echo $row['Course_Time_ID'] ?>">
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
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            if(isset($user_data)){
                                ?>
                                <label>
                                    <input name="Student_ID" type="number" value="<?php echo $user_data['Student_ID'] ?>" hidden>
                                </label>
                                <label>
                                    <input name="Old_Email" type="text" value="<?php echo $user_data['Email'] ?>" hidden>
                                </label>
                                <?php
                            }
                            ?>
                            <button name="<?php if(isset($_GET['Edit_Student'])){ echo "Edit_Student";}else if(isset($_GET['Submit_Request'])){ echo "Submit_Request";}else{ echo "Add_Student";} ?>" type="submit" class="sumbit">
                                <span class="btnText">Submit</span>
                                <i class="uil uil-navigator"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../JS/Center_Add_Student.js"></script>
    <script>
        let error = (document.location.href).split("?");
        if(error[1] === "Email-Exist"){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Email Already Exist"
            })
        }else if(error[1] === "Time-Interferes"){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "All available courses for him are added except courses that interferes with his time table"
            })
        }else if(error[1] === "Missing-Data"){
            Swal.fire({
                icon: 'error',
                title: 'data missing',
                text: "Please fill all user data"
            })
        }
        $(document).ready(function(){
            let addButton = $('.add_button_course'); //Add button selector
            let wrapper = $('.course_input'); //Input field wrapper
            let Input_number = <?php if(isset($i))echo $i;else echo 1; ?>;
            let number_of_inputs = <?php if(isset($i))echo $i;else echo 1; ?>;
            if(number_of_inputs > 1){
                document.getElementById('remove_button_course').style.display = 'block';
            }
            //Once add button is clicked
            $(addButton).click(function(){
                let fieldHTML = '<div class="input-field"><label for="Course' + Input_number + '">Course Enroll ' + Input_number + '</label><select id="Course' + Input_number + '" name="Course' + Input_number + '" required></select></div>'; //New input field html
                $(wrapper).append(fieldHTML); //Add field html
                let $options = $("#Course > option").clone();
                $('#Course' + Input_number).append($options);
                Input_number++;
                number_of_inputs++;
                if(number_of_inputs > 1){
                    document.getElementById('remove_button_course').style.display = 'block';
                }
                if (number_of_inputs === 10){
                    document.getElementById('add_button_course').style.display = 'none';
                }
            });
            $(wrapper).on('click', '.remove_button_course', function(e){
                e.preventDefault();
                $(wrapper).children().last().remove(); //Remove field html
                Input_number--;
                number_of_inputs--;
                if(number_of_inputs === 1){
                    document.getElementById("remove_button_course").style.display = 'none';
                }
                if (number_of_inputs < 10){
                    document.getElementById("add_button_course").style.display = 'block';
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
}
?>

