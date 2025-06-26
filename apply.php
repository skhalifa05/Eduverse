<?php
require_once "./DB/attendance_db.php";
require_once "./Models/newstudent.php";

$application = new Newstudent();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply</title>
    <link rel="stylesheet" href="./Views/CSS/apply.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://kit.fontawesome.com/590c731183.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        /* Simple modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 99;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #fff;
            padding: 2em;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
        }
        .close-modal {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>
<body>

<form id="courseForm" onsubmit="event.preventDefault(); showModal();">
    <fieldset class="checkbox-group">
        <legend class="checkbox-group-legend">Choose Courses</legend>

        <?php
        $data = $application->GetAvailableLectures($conn);
        $i = 1;
        while($row = $data->fetch_assoc()):
            $drname = $application->GetDoctorName($conn, $row['Course_ID']);
            $courseId = $row['Course_Time_ID'];
            ?>
            <div class="checkbox">
                <label class="checkbox-wrapper">
                    <input type="checkbox" class="checkbox-input" name="courses[]" value="<?= $courseId ?>">
                    <span class="checkbox-tile">
                      <?php
                      $time = strtotime($row['Time']);
                      $period = strtotime($row['Period']);
                      $secs = $period-strtotime("00:00:00");
                      $result = date("H:i:s",$time+$secs);
                      ?>
                        <span class="checkbox-icon"><i class="fa-solid fa-book"></i></span>
                        <span class="checkbox-label" style="font-size: 10px"><?= $row['Name'] ?></span>
                        <span class="checkbox-label" style="font-size: 10px">Dr. <?= $drname ?></span>
                        <span class="checkbox-label" style="font-size: 10px"><?= $row['Day'] . " ( " . $row['Time'] . " -> " . $result  ?></span>
                    </span>
                </label>
            </div>
            <?php
            $i++;
        endwhile;
        ?>
    </fieldset>

    <button type="submit" class="continue-application">
        <span>Continue Application</span>
    </button>
</form>

<!-- Modal -->
<div class="modal" id="studentModal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <form id="fullApplicationForm" method="POST" action="./Controller/Add_Student.php">
            <div class="form first">
                <input type="hidden" name="Add_Student_Manual" value="1">
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
                </div>
            </div>
            <!-- Placeholder for course checkboxes -->
            <div id="selectedCourses"></div>

            <button name="appsub" type="submit" class="sumbit">Submit</button>
        </form>
    </div>
</div>

<script>
    function showModal() {
        const selected = document.querySelectorAll('input[name="courses[]"]:checked');
        if (selected.length === 0) {
            Swal.fire("Please select at least one course");
            return;
        }

        const container = document.getElementById("selectedCourses");
        container.innerHTML = ""; // clear previous
        selected.forEach((checkbox, index) => {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            if (index == 0){
                hidden.name = `Course`;
            }else{
                hidden.name = `Course${index}`;
            }
            hidden.value = checkbox.value;
            container.appendChild(hidden);
        });

        // Also add count if needed by backend
        const count = document.createElement("input");
        count.type = "hidden";
        count.name = "Course_Count";
        count.value = selected.length;
        container.appendChild(count);

        document.getElementById("studentModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("studentModal").style.display = "none";
    }
</script>
<script>
    window.onload = function () {
        <?php if (isset($_GET['Time-Interferes'])): ?>
        Swal.fire('Time Conflict', 'One or more courses have overlapping times.', 'error');
        <?php elseif (isset($_GET['Success'])): ?>
        Swal.fire('Application Submitted!', 'Your application has been successfully received.', 'success');
        <?php elseif (isset($_GET['Email-Exist'])): ?>
        Swal.fire('Email Already Exists', 'This email has already been used for an application.', 'warning');
        <?php elseif (isset($_GET['Missing-Data'])): ?>
        Swal.fire('Missing Data', 'Please select at least one course before continuing.', 'info');
        <?php endif; ?>
    };
</script>
</body>

</html>