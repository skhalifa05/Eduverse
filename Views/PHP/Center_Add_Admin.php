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
    if(isset($_GET['Edit_Doc'])){
        $Doctor_data = $center->GetDoctorData($conn, $_GET['Admin_ID']);
        $grades_data = $center->GetDoctorGrades($conn, $_GET['Admin_ID']);
        $schools_data = $center->GetDoctorSchools($conn, $_GET['Admin_ID']);
        $grade_i = 1;
        $school_i = 1;
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
        <title>Add Teacher</title>
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
        <li class="menuItem">
            <a href="Center_Add_Student.php" class="menuOption">
                <i class="fa-solid fa-user-plus"></i><h5 class="menuText open2">Add Student</h5>
            </a>
        </li>
        <li class="menuItem active">
            <a href="Center_Add_Admin.php" class="menuOption">
                <i class="fa-solid fa-book-medical" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Add Doctor</h5>
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
                        <span class="text"><?php if(isset($_GET['Edit_Doc'])){echo "Edit" ;}else{ echo "Add";}?> Teacher</span>
                    </div>
                </div>
            </div>
            <div class="container">
                <header><?php if(isset($_GET['Edit_Doc'])){echo "Editing" ;}else{ echo "Registration";}?></header>
                <form action="../../Controller/Add_Doctor.php" method="POST">
                    <div class="form first">
                        <div class="details personal">
                            <span class="title">Teacher Details</span>
                            <div class="fields grade_input">
                                <div class="input-field">
                                    <label for="F_Name">First Name</label>
                                    <input name="F_Name" value="<?php if(isset($Doctor_data)){ echo $Doctor_data['F_Name'];} ?>" id="F_Name" type="text" placeholder="Enter Teacher's first name" required>
                                </div>
                                <div class="input-field">
                                    <label for="M_Name">Middle Name</label>
                                    <input name="M_Name" value="<?php if(isset($Doctor_data)){ echo $Doctor_data['M_Name'];} ?>" id="M_Name" type="text" placeholder="Enter Teacher's middle name (optional)" >
                                </div>
                                <div class="input-field">
                                    <label for="L_Name">Last Name</label>
                                    <input name="L_Name" value="<?php if(isset($Doctor_data)){ echo $Doctor_data['L_Name'];} ?>" id="L_Name" type="text" placeholder="Enter Teacher's last name" required>
                                </div>
                                <div class="input-field">
                                    <label for="Email">Email</label>
                                    <input name="Email" id="Email" value="<?php if(isset($Doctor_data)){ echo $Doctor_data['Email'];} ?>" type="text" placeholder="Enter Teacher's email" required>
                                </div>
                                <div class="input-field">
                                    <label for="Phone">Mobile Number</label>
                                    <input name="Phone" id="Phone" value="<?php if(isset($Doctor_data)){ echo $Doctor_data['Phone'];} ?>" type="text" placeholder="Enter mobile number" required>
                                </div>
                                <div class="input-field">
                                    <label for="Subject">Subject</label>
                                    <input name="Subject" id="Subject" value="<?php if(isset($Doctor_data)){ echo $Doctor_data['Subject'];} ?>" type="text" placeholder="Enter Teacher's Subject" required>
                                </div>
                                <?php
                                if(isset($schools_data)){
                                    $school = $schools_data->fetch_assoc();
                                }
                                ?>
                                <div class="input-field">
                                    <div style="display: flex;justify-content: space-between;align-items: center;">
                                        <label for="School">School</label>
                                        <button class="add_button_school" id="add_button_school" type="button" style="border:none;background-color:black;width:30px;height:20px;margin:0;">
                                            <i class="far fa-plus-square"></i>
                                        </button>
                                        <button class="remove_button_school" id="remove_button_school" type="button" style="border:none;background-color:black;display:none;width:30px;height:20px;margin:0;">
                                            <i class="far fa-minus-square"></i>
                                        </button>
                                    </div>
                                    <input value="<?php
                                    if(isset($school)){
                                        echo $school['School_Name'];
                                    }
                                    ?>" name="School" id="School" type="text" placeholder="Enter Teacher's school(s)" required>
                                </div>
                                <?php
                                if(isset($grades_data)){
                                    $grade = $grades_data->fetch_assoc();
                                }
                                ?>
                                <div class="input-field">
                                    <div style="display: flex;justify-content: space-between;align-items: center;">
                                        <label for="Grade">Grade Levels</label>
                                        <button class="add_button_grade" id="add_button_grade" type="button" style="border:none;background-color:black;width:30px;height:20px;margin:0;">
                                            <i class="far fa-plus-square"></i>
                                        </button>
                                        <button class="remove_button_grade" id="remove_button_grade" type="button" style="border:none;background-color:black;display:none;width:30px;height:20px;margin:0;">
                                            <i class="far fa-minus-square"></i>
                                        </button>
                                    </div>
                                    <select id="Grade" name="Grade" required>
                                        <option disabled selected>Select grade</option>
                                        <option  <?php
                                        if(isset($grade) && $grade['Grade'] == 9){
                                            echo "selected";
                                        }
                                        ?> value="9">9</option>
                                        <option <?php
                                        if(isset($grade) && $grade['Grade'] == 10){
                                            echo "selected";
                                        }
                                        ?> value="10">10</option>
                                        <option <?php
                                        if(isset($grade) && $grade['Grade'] == 11){
                                            echo "selected";
                                        }
                                        ?> value="11">11</option>
                                        <option <?php
                                        if(isset($grade) && $grade['Grade'] == 12){
                                            echo "selected";
                                        }
                                        ?> value="12">12</option>
                                    </select>
                                </div>
                                <?php
                                if(isset($grades_data) && isset($grade_i)){
                                    while($grade_row = $grades_data->fetch_assoc()){
                                        ?>
                                        <div class="input-field">
                                            <label for="Grade">Grade Levels <?php echo $grade_i; ?></label>
                                            <select id="Grade" name="Grade<?php echo $grade_i; ?>" required>
                                                <option disabled selected>Select grade</option>
                                                <option  <?php
                                                if($grade_row['Grade'] == 9){
                                                    echo "selected";
                                                }
                                                ?> value="9">9</option>
                                                <option <?php
                                                if($grade_row['Grade'] == 10){
                                                    echo "selected";
                                                }
                                                ?> value="10">10</option>
                                                <option <?php
                                                if($grade_row['Grade'] == 11){
                                                    echo "selected";
                                                }
                                                ?> value="11">11</option>
                                                <option <?php
                                                if($grade_row['Grade'] == 12){
                                                    echo "selected";
                                                }
                                                ?> value="12">12</option>
                                            </select>
                                        </div>
                                        <?php
                                        $grade_i++;
                                    }
                                }
                                if(isset($schools_data) && isset($school_i)){
                                    while($school_row = $schools_data->fetch_assoc()){
                                        ?>
                                        <div class="input-field">
                                            <div style="display: flex;justify-content: space-between;align-items: center;">
                                                <label for="School">School <?php echo $school_i ?></label>
                                            </div>
                                            <input value="<?php echo $school_row['School_Name']; ?>" name="School<?php echo $school_i ?>" id="School" type="text" placeholder="Enter Teacher's school(s)" required>
                                        </div>
                                        <?php
                                        $school_i++;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if(isset($Doctor_data)){
                            ?>
                            <label>
                                <input name="Admin_ID" type="number" value="<?php echo $Doctor_data['Admin_ID'] ?>" hidden>
                            </label>
                            <label>
                                <input name="Old_Email" type="text" value="<?php echo $Doctor_data['Email'] ?>" hidden>
                            </label>
                            <?php
                        }
                        ?>
                        <button name="<?php if(isset($Doctor_data)){ echo "Edit_Doctor";}else{ echo "Add_Doctor";} ?>" type="submit" class="sumbit">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
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
        }else if(error[1] === "Missing-Data"){
            Swal.fire({
                icon: 'error',
                title: 'data missing',
                text: "Please fill all doctor data"
            })
        }
        $(document).ready(function(){
            let addButton = $('.add_button_grade'); //Add button selector
            let wrapper = $('.grade_input'); //Input field wrapper
            let Input_number = <?php if(isset($grade_i))echo $grade_i;else echo 1; ?>;
            let number_of_inputs = <?php if(isset($grade_i))echo $grade_i;else echo 1; ?>;
            if(number_of_inputs > 1){
                document.getElementById('remove_button_grade').style.display = 'block';
            }
            //Once add button is clicked
            $(addButton).click(function(){
                let fieldHTML = '<div class="input-field"><label for="Grade' + Input_number + '">Grade Levels ' + Input_number + '</label><select id="Grade' + Input_number + '" name="Grade' + Input_number + '" required><option disabled selected>Select grade</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></div>'; //New input field html
                $(wrapper).append(fieldHTML); //Add field html
                Input_number++;
                number_of_inputs++;
                if(number_of_inputs > 1){
                    document.getElementById('remove_button_grade').style.display = 'block';
                }
                if (number_of_inputs === 5){
                    document.getElementById('add_button_grade').style.display = 'none';
                }
            });
            $(wrapper).on('click', '.remove_button_grade', function(e){
                e.preventDefault();
                $(wrapper).children().last().remove(); //Remove field html
                Input_number--;
                number_of_inputs--;
                if(number_of_inputs === 1){
                    document.getElementById("remove_button_grade").style.display = 'none';
                }
                if (number_of_inputs < 5){
                    document.getElementById("add_button_grade").style.display = 'block';
                }
            });
        });
        $(document).ready(function(){
            let addButton = $('.add_button_school'); //Add button selector
            let wrapper = $('.grade_input'); //Input field wrapper
            let Input_number = <?php if(isset($school_i))echo $school_i;else echo 1; ?>;
            let number_of_inputs = <?php if(isset($school_i))echo $school_i;else echo 1; ?>;
            if(number_of_inputs > 1){
                document.getElementById('remove_button_school').style.display = 'block';
            }
            //Once add button is clicked
            $(addButton).click(function(){
                let fieldHTML = '<div class="input-field"><label for="School' + Input_number + '">School ' + Input_number + '</label><input id="School' + Input_number + '" name="School' + Input_number + '" type="text" placeholder="Enter Teacher\'s school(s)" required></div>'; //New input field html
                $(wrapper).append(fieldHTML); //Add field html
                Input_number++;
                number_of_inputs++;
                if(number_of_inputs > 1){
                    document.getElementById('remove_button_school').style.display = 'block';
                }
                if (number_of_inputs === 5){
                    document.getElementById('add_button_school').style.display = 'none';
                }
            });
            $(wrapper).on('click', '.remove_button_school', function(e){
                e.preventDefault();
                $(wrapper).children().last().remove(); //Remove field html
                Input_number--;
                number_of_inputs--;
                if(number_of_inputs === 1){
                    document.getElementById("remove_button_school").style.display = 'none';
                }
                if (number_of_inputs < 5){
                    document.getElementById("add_button_school").style.display = 'block';
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
