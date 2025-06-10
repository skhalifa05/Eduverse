<?php

require_once "../../Models/Doctor.php";
require_once "../../DB/attendance_db.php";

session_start();
if(isset($_SESSION['Doctor-Attendance-System-1'])){
    $doctor = unserialize($_SESSION['Doctor-Attendance-System-1']);
}else{
    header("Location: ../../index.php");
}

if(isset($conn) && isset($doctor) && ($doctor instanceof Doctor)){
    $name = explode(" ",$doctor->getName());
    $f_name = $name[0];
    $m_name = $name[1];
    $l_name = $name[2];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!----======== CSS ======== -->
        <link rel="stylesheet" href="../CSS/Uprofile.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/e6688e278c.js" crossorigin="anonymous"></script>
        <!----------------js---------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <title>Profile</title>
    </head>
    <body>
    <nav class="nav">
        <div class="logo-name">
            <div class="logo-image">
                <img src="../../Images/BrightSideLogo.png" alt="">
            </div>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <!--<li><a href="Doctor_Attendance.php">
                        <i class="uil uil-estate"  title="home"></i>
                        <span class="link-name" >Home</span>
                    </a>
                </li>-->
                <li><a href="Doctor_Profile.php">
                        <i id="nav-active" class="uil uil-user-square" title="profile"></i>
                        <span id="nav-active" class="link-name">Profile</span>
                    </a>
                </li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../../Controller/logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="CodeOlogyLogo-container">
            <img class="CodeOlogyLogo" src="../../Images/COedu.png" alt="">
        </div>
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="name"><?php echo $doctor->getName(); ?></div>
            <a href="Doctor_Profile.php"><img src="../../Images/profile.jpg" alt=""></a>
        </div>
        <div style="margin-bottom: 50px" class="content">
            <div class="overview">
                <div class="title t1">
                    <div class="titlesmall">
                        <i class="uil uil-notes"></i>
                        <span class="text">User Card</span>
                    </div>
                </div>
                <div class="profile-details">
                    <div class="pic-side">
                        <a href="#"><img src="../../Images/profile.jpg" alt=""></a>
                        <div class="name"><h3><?php echo $doctor->getName(); ?></h3></div>
                        <div class="bio"><p><?php echo $doctor->getSubject() ?> Teacher at <?php
                                $i=1;
                                foreach($doctor->getSchoolNames() AS $school_name){
                                    if($i==1){
                                        echo $school_name['School_Name'];
                                        $i++;
                                    }else{
                                        echo ", " . $school_name['School_Name'];
                                    }
                                }
                                ?> for Grade<?php if(count($doctor->getGrades()) > 1)echo "s"; ?> <?php
                                $i=1;
                                foreach($doctor->getGrades() AS $grade_value){
                                    if($i==1){
                                        echo $grade_value['Grade'];
                                        $i++;
                                    }else{
                                        echo ", " . $grade_value['Grade'];
                                    }
                                }
                                ?>.</p></div>
                    </div>
                    <div class="details-side">
                        <h3>User details</h3>
                        <div class="info-data">
                            <div class="data first">
                                <h4>First name</h4>
                                <p><?php echo $f_name ?></p>
                            </div>
                            <div class="data first">
                                <h4>Middle name</h4>
                                <p><?php echo $m_name ?></p>
                            </div>
                            <div class="data last">
                                <h4>Last name</h4>
                                <p><?php echo $l_name ?></p>
                            </div>
                            <div class="data e-mail">
                                <h4>E-mail</h4>
                                <p id="email"><?php echo $doctor->getEmail() ?></p>
                            </div>
                            <div class="data id">
                                <h4>User ID</h4>
                                <p><?php echo $doctor->getID(); ?></p>
                            </div>
                            <div class="data ph-num">
                                <h4>Phone number</h4>
                                <p><?php echo $doctor->getPhone(); ?></p>
                            </div>
                            <div class="data pass">
                                <h4>Password</h4>
                                <div class="pas">
                                    <p>
                                        <?php
                                        for($i=0;$i<strlen($doctor->getPassword());$i++)echo "*";
                                        ?>
                                    </p>
                                    <i class="far fa-edit"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="change-pass-box">
                    <form action="../../Controller/UpdatePassword.php" method="POST">
                        <h2>Change Password</h2>
                        <p id="err_message" class="error" style="display:none"></p>
                        <label for="Old_Password">Old Password</label>
                        <input id="Old_Password" type="password" name="Old_Password" placeholder="Old Password">
                        <br>
                        <label for="New_Password">New Password</label>
                        <input type="password" onblur="CheckSame()" name="New_Password" id="New_Password" placeholder="New Password">
                        <label for="Re_Password">Confirm New Password</label>
                        <input type="password" onblur="CheckSame()" name="Re_Password" id="Re_Password" placeholder="Confirm New Password">
                        <br>
                        <button type="submit" id="Submit_Button" onclick="CheckSame()" name="Password_Change_Doctor" value="<?php echo $doctor->getID(); ?>" class="submit">CHANGE</button>
                        <a href="#" class="ca">Cancel</a>
                    </form>
                </div>
                <div class="title t2">
                    <div class="titlesmall">
                        <i class="uil uil-notes"></i>
                        <span class="text">Timetable</span>
                    </div>
                </div>
                <div class="timetable">
                    <table>
                        <thead>
                        <tr style="text-align:center">
                            <td nowrap=""><i>Period/Day</i></td>
                            <td>
                                <b style="color: var(--onpointer-color);">Saturday</b>
                            </td>
                            <td>
                                <b style="color:  var(--onpointer-color);;">Sunday</b>
                            </td>
                            <td>
                                <b style="color:  var(--onpointer-color);;">Monday</b>
                            </td>
                            <td>
                                <b style="color:  var(--onpointer-color);;">Tuesday</b>
                            </td>
                            <td>
                                <b style="color:  var(--onpointer-color);;">Wednesday</b>
                            </td>
                            <td>
                                <b style="color:  var(--onpointer-color);;">Thursday</b>
                            </td>
                            <td>
                                <b style="color:  var(--onpointer-color);;">Friday</b>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $time = strtotime("06:00:00");
                        $period = strtotime("00:30:00");
                        $secs = strtotime("00:00:00")-strtotime("00:00:00");
                        $result = date("H:i:s",$time+$secs);
                        $sat = 0;
                        $sun = 0;
                        $mon = 0;
                        $tue = 0;
                        $wed = 0;
                        $thu = 0;
                        $fri = 0;
                        while(strtotime($result) != strtotime("00:00:00")){
                            $time = strtotime($result);
                            $secs = $period-strtotime("00:00:00");
                            $result2 = date("H:i:s",$time+$secs);
                            ?>
                            <tr>
                                <td>
                                    <?php echo $result . "->" . $result2 ?>
                                </td>
                                <?php
                                if($sat == 0){
                                    if($course_name = $doctor->GetCourseNameByTime($conn, $result, "Sat")){
                                        $time_for_course = strtotime($course_name['Period'])-strtotime("00:00:00");
                                        $time_for_sec = strtotime("00:30:00")-strtotime("00:00:00");
                                        $section_nums = (int)($time_for_course/$time_for_sec);
                                        $sat = $section_nums-1;
                                        ?>
                                        <td style="background-color: var(--onpointer-color)" rowspan="<?php echo $section_nums ?>">
                                            <?php echo $course_name['Name'] ?>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td style="background-color:white"></td>
                                        <?php
                                    }
                                }else{
                                    $sat--;
                                }
                                if($sun == 0){
                                    if($course_name = $doctor->GetCourseNameByTime($conn, $result, "Sun")){
                                        $time_for_course = strtotime($course_name['Period'])-strtotime("00:00:00");
                                        $time_for_sec = strtotime("00:30:00")-strtotime("00:00:00");
                                        $section_nums = (int)($time_for_course/$time_for_sec);
                                        $sun = $section_nums-1;
                                        ?>
                                        <td style="background-color: var(--onpointer-color)" rowspan="<?php echo $section_nums ?>">
                                            <?php echo $course_name['Name'] ?>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td style="background-color:white"></td>
                                        <?php
                                    }
                                }else{
                                    $sun--;
                                }
                                if($mon == 0){
                                    if($course_name = $doctor->GetCourseNameByTime($conn, $result, "Mon")){
                                        $time_for_course = strtotime($course_name['Period'])-strtotime("00:00:00");
                                        $time_for_sec = strtotime("00:30:00")-strtotime("00:00:00");
                                        $section_nums = (int)($time_for_course/$time_for_sec);
                                        $mon = $section_nums-1;
                                        ?>
                                        <td style="background-color: var(--onpointer-color)" rowspan="<?php echo $section_nums ?>">
                                            <?php echo $course_name['Name'] ?>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td style="background-color:white"></td>
                                        <?php
                                    }
                                }else{
                                    $mon--;
                                }
                                if($tue == 0){
                                    if($course_name = $doctor->GetCourseNameByTime($conn, $result, "Tue")){
                                        $time_for_course = strtotime($course_name['Period'])-strtotime("00:00:00");
                                        $time_for_sec = strtotime("00:30:00")-strtotime("00:00:00");
                                        $section_nums = (int)($time_for_course/$time_for_sec);
                                        $tue = $section_nums-1;
                                        ?>
                                        <td style="background-color: var(--onpointer-color)" rowspan="<?php echo $section_nums ?>">
                                            <?php echo $course_name['Name'] ?>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td style="background-color:white"></td>
                                        <?php
                                    }
                                }else{
                                    $tue--;
                                }
                                if($wed == 0){
                                    if($course_name = $doctor->GetCourseNameByTime($conn, $result, "Wed")){
                                        $time_for_course = strtotime($course_name['Period'])-strtotime("00:00:00");
                                        $time_for_sec = strtotime("00:30:00")-strtotime("00:00:00");
                                        $section_nums = (int)($time_for_course/$time_for_sec);
                                        $wed = $section_nums-1;
                                        ?>
                                        <td style="background-color: var(--onpointer-color)" rowspan="<?php echo $section_nums ?>">
                                            <?php echo $course_name['Name'] ?>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td style="background-color:white"></td>
                                        <?php
                                    }
                                }else{
                                    $wed--;
                                }
                                if($thu == 0){
                                    if($course_name = $doctor->GetCourseNameByTime($conn, $result, "Thu")){
                                        $time_for_course = strtotime($course_name['Period'])-strtotime("00:00:00");
                                        $time_for_sec = strtotime("00:30:00")-strtotime("00:00:00");
                                        $section_nums = (int)($time_for_course/$time_for_sec);
                                        $thu = $section_nums-1;
                                        ?>
                                        <td style="background-color: var(--onpointer-color)" rowspan="<?php echo $section_nums ?>">
                                            <?php echo $course_name['Name'] ?>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td style="background-color:white"></td>
                                        <?php
                                    }
                                }else{
                                    $thu--;
                                }
                                if($fri == 0){
                                    if($course_name = $doctor->GetCourseNameByTime($conn, $result, "Fri")){
                                        $time_for_course = strtotime($course_name['Period'])-strtotime("00:00:00");
                                        $time_for_sec = strtotime("00:30:00")-strtotime("00:00:00");
                                        $section_nums = (int)($time_for_course/$time_for_sec);
                                        $fri = $section_nums-1;
                                        ?>
                                        <td style="background-color: var(--onpointer-color)" rowspan="<?php echo $section_nums ?>">
                                            <?php echo $course_name['Name'] ?>
                                        </td>
                                        <?php
                                    }else{
                                        ?>
                                        <td style="background-color:white"></td>
                                        <?php
                                    }
                                }else{
                                    $fri--;
                                }
                                ?>
                            </tr>
                            <?php
                            $result = $result2;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="../JS/Attendance.js"></script>
    <script src="../JS/profile.js"></script>
    <script>
        let re_enter_pass = document.getElementById('Re_Password');
        let new_pass = document.getElementById('New_Password');
        let err_msg = document.getElementById('err_message');
        document.getElementById('Submit_Button').disabled = true;
        function CheckSame(){
            console.log(re_enter_pass);
            console.log(new_pass);
            if(re_enter_pass.value !== "" && new_pass.value !== "" && re_enter_pass.value !== new_pass.value){
                err_msg.style.display = 'block';
                err_msg.innerHTML = 'Confirm Password is Wrong';
                document.getElementById('Submit_Button').disabled = true;
            }else if(re_enter_pass.value === "" || new_pass.value === ""){
                document.getElementById('Submit_Button').disabled = true;
            }else{
                document.getElementById('Submit_Button').disabled = false;
                err_msg.style.display = 'none';
            }
        }
        let error = (document.location.href).split("?");
        if(error[1] === "success"){
            Swal.fire({
                icon: 'success',
                title: 'Done',
                text: "Password changed successfully"
            })
        }else if(error[1] === "fail"){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Wrong old password"
            })
        }
    </script>
    </body>
    </html>
    <?php
}
?>