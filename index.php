<?php
session_start();
if(isset($_SESSION['Center-Attendance-System-1'])){
    header('Location: Views/PHP/Center_Home.php');
}
if(isset($_SESSION['Student-Attendance-System-1'])){
    header('Location: Views/PHP/profile.php');
}
if(isset($_SESSION['Doctor-Attendance-System-1'])){
    header('Location: Views/PHP/Doctor_Profile.php');
}
if(isset($_SESSION['Parent-Attendance-System-1'])){
    header('Location: Views/PHP/Parent_Profile.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns="">
<head>
    <meta charset="UTF-8">
    <title>Bright Side | Codeology Education</title>
    <link rel="stylesheet" href="Views/CSS/loginpagenew.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.all.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>


<div class="area" >
    <center>
        <img style="width:300px;" class="CodeOlogyLogo" src="https://brightside-edu.com/Images/COeduwhite.png" alt="">
    </center>
    <div style="display:flex;justify-content: center;position:relative;z-index: 100">
        <div class="form-structor">

            <form action="Controller/LoginValidate.php" method="POST">
                <div class="signup">
                    <h2 class="form-title" id="signup">Existing Student</h2>
                    <div class="form-holder">
                        <input name="Login-Email" id="Login-Email" type="text" placeholder="Enter your Email" class="input" required>

                        <input type="password" name="Login-Password" placeholder="Enter Your Phone Number" id="password" class="input" required>
                        <div  id="toggle" onclick="showHidePass();"><i class="far fa-eye" id="myicon" ></i></div>
                    </div>
                    <input type="submit" name="Login-Form" class="submit-btn" value="Login">
                </div>
            </form>
<!--            <div class="login slide-up">-->
<!--                <div class="center">-->
<!--                    <h2 class="form-title" id="login" style="padding-bottom: 250px;">New Student Application</h2>-->
<!--                   <div id="div1" style="    height: 500px;-->
<!--    position: absolute;-->
<!--    top: 100px;">-->
<!--                        <div id="div2" style="max-height:100%;overflow:auto;border:1px solid red;">-->
<!--                            <div id="div3" style="height:1500px;border:5px solid yellow;">hello</div>-->
<!--                        </div>-->
<!---->
<!--                    <div class="form-holder"  style="height: 320px; position: absolute; top: 50px; width: 100%; border:0px; overflow: auto; margin-left: auto; margin-right: auto;">-->
<!--                      <form action="Controller/newapp.php" method="POST">-->
<!--                         <h4 style="color: #174074; line-height: 20px;"><center>Registration hasn't opened yet!<br>Come Back Soon!</center></h4> -->
<!--                        <div class="row">-->
<!--                            <div class="col-half">-->
<!--                                <h4>Name</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <input type="text" name="F_name" placeholder="First" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-half">-->
<!--                                <h4 style="color: #fff;">Codeology</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <input type="text" name="M_name" placeholder="Middle" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col">-->
<!--                                <div class="input-group">-->
<!--                                    <input type="text" name="L_name" placeholder="Last Name" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-half">-->
<!--                                <h4>Email</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <input type="text" name="email" placeholder="Email" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-half">-->
<!--                                <h4>Phone #</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <input type="text" name="Pnumb" placeholder="Phone Number" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-half">-->
<!--                                <h4>School Name</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <input type="text" name="Sname" placeholder="School Name" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-half">-->
<!--                                <h4>Grade & Age</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <select name="Grade">-->
<!--                                        <option value="9">9</option>-->
<!--                                        <option value="10">10</option>-->
<!--                                        <option value="11">11</option>-->
<!--                                        <option value="12">12</option>-->
<!--                                    </select>-->
<!---->
<!---->
<!---->
<!--                                    <select name="Age">-->
<!--                                        <option value="14">14</option>-->
<!--                                        <option value="15">15</option>-->
<!--                                        <option value="16">16</option>-->
<!--                                        <option value="17">17</option>-->
<!--                                        <option value="18">18</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-half">-->
<!--                                <h4>Gaurdian Name</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <input name="Gname" type="text" placeholder="Gaurdian Name" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-half">-->
<!--                                <h4>Gaurdian relation</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <select name="GType" style="width: 90%">-->
<!--                                        <option value="Mother">Mother</option>-->
<!--                                        <option value="Father">Father</option>-->
<!--                                        <option value="Other">Other</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col">-->
<!--                                <h4>Gaurdian Phone #</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <input name="Gpnumb" type="text" placeholder="Gaurdian phone #" required/>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col">-->
<!--                                <h4>Course</h4>-->
<!--                                <div class="input-group">-->
<!--                                    <select name="Course" style="width: 90%">-->
<!--                                        <option value="Accounting">Accounting</option>-->
<!--                                        <option value="Math">Maths</option>-->
<!--                                        <option value="Chemistry">Chemistry</option>-->
<!--                                        <option value="Physics">Physics</option>-->
<!--                                        <option value="Biology">Biology</option>-->
<!--                                        <option value="English">English</option>-->
<!--                                        <option value="French">French</option>-->
<!--                                        <option value="ICT">ICT</option>-->
<!--                                        <option value="Computer science">Computer science</option>-->
<!--                                        <option value="Combined science">Combined science</option>-->
<!--                                        <option value="Global prospective">Global prospective</option>-->
<!--                                        <option value="Business">Business</option>-->
<!--                                        <option value="Economics">Economics</option>-->
<!--                                        <option value="Sociology">Sociology</option>-->
<!--                                        <option value="Psychology">Psychology</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            </div>-->
<!--                        <input type="submit" id="new-stu-signup" name="new-stu-signup" class="submit-btn" value="Signup">-->
<!--                        </div>-->
<!--                    </form>-->
<!--                    </div>-->
<!---->
<!--                    </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div >
<script src="Views/JS/login_page.js"></script>
<script>
    console.clear();

    const loginBtn = document.getElementById('login');
    const signupBtn = document.getElementById('signup');

    loginBtn.addEventListener('click', (e) => {
        let parent = e.target.parentNode.parentNode;
        Array.from(e.target.parentNode.parentNode.classList).find((element) => {
            if(element !== "slide-up") {
                parent.classList.add('slide-up')
            }else{
                signupBtn.parentNode.classList.add('slide-up')
                parent.classList.remove('slide-up')
            }
        });
    });

    signupBtn.addEventListener('click', (e) => {
        let parent = e.target.parentNode;
        Array.from(e.target.parentNode.classList).find((element) => {
            if(element !== "slide-up") {
                parent.classList.add('slide-up')
            }else{
                loginBtn.parentNode.parentNode.classList.add('slide-up')
                parent.classList.remove('slide-up')
            }
        });
    });
</script>
<script>
    let error = (document.location.href).split("?");
    if(error[1] === "Missing-Input-Data"){
        sweetAlert("Oops...", "Please fill all fields", "error");
    }else if(error[1] === "Data-is-incorrect"){
        sweetAlert("Oops...", "Wrong Credentials", "error");
    }else if(error[1] === "User-Not-Authorized"){
        sweetAlert("Oops...", "Unverified Account", "error");
    }else if(error[1] === "Email-Exist"){
        sweetAlert("Oops...", "Looks Like this email exists", "error");
    }else if(error[1] === "success"){
        sweetAlert("Hooray!", "Signup Success! our representative will contacts you soon!", "success");
    }
</script>
</body>
</html>

