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
        <link rel="stylesheet" href="../CSS/oldAttendance.css">
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://kit.fontawesome.com/53c8d3b838.js" crossorigin="anonymous"></script>
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
        <li class="menuItem active">
            <a href="Center_Student_List.php" class="menuOption">
                <i class="fa-solid fa-user" style="color: #fff"></i><h5 class="menuText open2" style="color: #fff">Student List</h5>
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
                            <p>History</p>
                        </th>
                        <?php if(!isset($_GET['Year'])){
                            echo'
                        
                        <th>
                            <p>Edit</p>
                        </th>
                        <th>
                            <p>Resend Verification</p>
                        </th>
                        <th>
                            <p>Delete</p>
                        </th>
                        ';
                            }
                            ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_GET['Year'])){
                        $data = $center->GetArchivedStudents($conn, $_GET['Year']);
                        $i=1;
                    }else {
                        $data = $center->GetAllStudents($conn);
                        $i = 1;
                    }
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
                                    <?php
                                    if($row['Verify'] == 1){
                                        ?>
                                        <div style="background:rgba(56,151,240,0.6);width: 20px;border-radius: 100%;height: 20px; position: relative;display: flex;align-items: center;justify-content: center;/*margin-left: 5px;*/right: 5px;top: -5px;">
                                            <i style="font-size: 10px;color: white;" class="fa-solid fa-check"></i>
                                        </div>
                                        <?php
                                    }
                                    ?>
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
                            <td class="att-show" >
                                <button onclick="viewstuh(<?php echo $row['Student_ID']?>)">Open Modal</button>
                            </td>
                            <td>
                                <p>
                                    <button style="border:none;background:inherit;<?php if(isset($_GET['Year'])){echo'display:none';}?>" onClick="window.location.href='Center_Add_Student.php?Student_ID=<?php echo $row['Student_ID'] ?>&Edit_Student'">
                                        <img alt="delete" style="vertical-align: bottom;" src="../../Images/pencil_icon-2.png">
                                    </button>
                                </p>
                            </td>
                            <td class="att-show"  <?php if(isset($_GET['Year'])){echo'style="display: none"';}?>>
                                <button  onclick="verigo(<?php echo $row['Student_ID'] ?>)"  <?php if($row['Verify'] == 1){ echo 'disabled';}?>>
                                    Send
                                </button>
                            </td>
                            <td  <?php if(isset($_GET['Year'])){echo'style="display: none"';}?>>
                                <button style="border:none;background:inherit;" onClick="window.location.href='../../Controller/Student_Handling.php?Student_ID=<?php echo $row['Student_ID'] ?>&Delete_Student'">
                                    <img alt="delete" style="vertical-align: bottom;" src="../../Images/cancel.png">
                                </button>
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
        <!-- The Modal -->
        <div id="myModal" class="modal" style="position:absolute;justify-content: center;">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div style="margin-top: 35px">
                <div class="boxes">
                    <div class="box box1" onclick="">
                        <span class="text">All Lectures</span>
                        <span class="number">3</span>
                    </div>
                    <div class="box box2">
                        <span class="text">attended Lectures</span>
                        <span class="number">3</span>
                    </div>
                    <div class="box box3" >
                        <span class="text">Absent Lectures</span>
                        <span class="number">2</span>
                    </div>
                    <?php

                        if (!empty($_POST)) {
                            // POST variables are available
                            // Process the POST data here
                            foreach ($_POST as $key => $value) {
                                // Access individual POST variables using $key and $value
                                echo "POST variable: " . $key . " = " . $value . "<br>";
                            }
                        } else {
                            // No POST variables found
                            echo "No POST variables available.";
                        }

                    ?>

                </div>
                    <div class="activity">
                        <div class="title">
                            <i class="uil uil-book"></i>
                            <span class="text">Attendance</span>
                        </div>
                        <div class="activity-data">
                            <table id="myTable">
                                <tr>
                                    <th>
                                        <p>No.</p>
                                    </th>
                                    <th>
                                        <p>Lecture Name</p>
                                    </th>
                                    <th>
                                        <p>Arrival Time</p>
                                    </th>
                                    <th>
                                        <p>Day: Lecture Time</p>
                                    </th>
                                    <th>
                                        <p>State</p>
                                    </th>
                                    <th>
                                        <p>State</p>
                                    </th>
                                </tr>

                                <td>
                                    <p>
                                        1
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        a
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        a
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        a
                                    </p>
                                </td>
                                <td>
                                    a
                                    </p>
                                </td>
                                <td>
                                    a
                                </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <script src="../JS/jquery-2.2.3.min.js"></script>
    <script src="../JS/Center_Student_List.js"></script>
    <script src="../JS/modernizr.custom.80028.js"></script>
  <script>
      // Get the modal
      var modal = document.getElementById("myModal");

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];


      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
          modal.style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }

      }
  </script>
  <script>

      function viewstuh(id){
          var idd = id;

          // ajax
          $.ajax({

              type: "POST",
              url: "../../Controller/studenthistory.php<?php if(isset($_GET['Year'])){echo '?Year='.$_GET['Year'];}?>",
              data: {ID: idd},
              dataType: 'json',
              success: function (res) {
                  var ajaxValue = res; // Replace with your actual value

                  // AJAX call to update the PHP variable
                  function updatePHPVariable(value) {
                      $.ajax({
                          type: "POST",
                          url: "", // Send the request to the same file
                          data: { studata: value },
                          dataType: 'json',
                          success: function(response) {
                              console.log('ok');
                              // Handle the response as needed
                          },
                          error: function(xhr, status, error) {
                              console.log('Error:', error);
                          }
                      });
                  }

                  // Call the AJAX function to update the PHP variable
                  updatePHPVariable(ajaxValue);
                  alert(res);
                  modal.style.display = "block";
              }
          })
      }
  </script>
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