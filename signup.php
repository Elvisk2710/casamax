<?php
session_start();
require './required/ads_query.php';
require_once 'homerunphp/homerunuserdb.php';
setcookie("scriptPage", "register.php", time() + (900 * 1), "/");
setcookie("page_pass", "homerunuserdb", time() + (900 * 1), "/");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Sign-up as a student to take advantage of the vast Homes available for your off-campus accommodatioin">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="icon" href="images/logowhite.png">
    <title>CasaMax Student-SignUp</title>
    <link rel="stylesheet" href="signup.css">
    <?php
    require './required/header.php';
    ?>
</head>


<body onunload="" class="scrollable">
    <?php
    require 'required/pageloader.php';
    ?>
    <div class="container">
        <div class="login-container">
            <div class="left-sign-up">
                <h1>
                    Let's Get You Signed Up!
                </h1>
                <lottie-player
                    src="https://lottie.host/54b560aa-0926-4f33-ba56-bc874c3cdf00/HGgMex1FgU.json"
                    background="transparent"
                    speed="1"
                    style="width: 70%; height: 70%;"
                    loop
                    autoplay>
                </lottie-player>
            </div>
            <div class="right-sign-up">
                <form class="sign-up-container" action="homerunphp/register.php" method="post">
                    <div>
                        <h1>Student Registration</h1>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="uname">First-Name </label>
                            <input title="Enter Your First Name" type="text" id="frstnme" name="firstname" placeholder="Enter your First-Name" required>
                        </div>
                        <div class="input-label">
                            <label for="uname">Last-Name </label>
                            <input title="Enter Your Larst Name" type="text" id="lstnme" name="lastname" placeholder="Enter your Last-Name" required>
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="upword">Password</label>
                            <div class="password">
                                <input title="Enter Your Password" type="password" id="pword" name="password" placeholder="Enter your Password" required>
                            </div>
                        </div>
                        <div class="input-label">
                            <label for="upword">Confirm Password</label>
                            <input title="Enter Your Passord" type="password" id="cpword" name="confirmpassword" placeholder="Enter your Password" required>
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="email">Email</label>
                            <input title="Enter Your Email " type="email" id="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="input-label">
                            <label for="dob">DOB</label>
                            <input title="Enter Your Date Of Birth" type="date" id="dob" name="dob" placeholder="Enter Date of Birth" required>
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="input-label gender">
                            <label for="gender">Gender</label>
                            <div class="radio">
                                <div class="gender_container">
                                    <label for="male" class="man">Male</label>
                                    <input type="radio" id="male" value="M" name="gender">
                                </div>
                                <div class="gender_container">
                                    <label for="female" class="woman">Female</label>
                                    <input type="radio" id="female" value="F" name="gender">
                                </div>
                            </div>
                        </div>
                        <div class="input-label">
                            <label for="phone">Contact</label>
                            <input title="Enter Your Phone Number" min="0" type="number" id="phone" name="contact" placeholder="Enter Contact" required>
                        </div>
                    </div>
                    <div class="input-label">
                        <label for="university">University</label>
                        <select name="university" id="dropdown">
                            <option value="">Choose Your University</option>
                            <option value="University of Zimbabwe">University of Zimbabwe</option>
                            <option value="Midlands State University">Midlands State University</option>
                            <option value="Africa Univeristy">Africa Univeristy</option>
                            <option value="Bindura State University">Bindura State University</option>
                            <option value="Chinhoyi University of Science and Technology">Chinhoyi University of Science and Technology</option>
                            <option value="Great Zimbabwe University">Great Zimbabwe University</option>
                            <option value="Harare Institute of Technology">Harae Institue of Technology</option>
                            <option value="National University of Science and Technology">National University of Science and Technology</option>
                        </select>
                    </div>
                    <div>
                        <label for="checkbox" class="checkbox"><input type="checkbox" id="checkbox" required><a href="terms_of_service.html">I hereby accept all the terms and conditions</a></label>
                    </div>
                    <div class="login">
                        <button type="submit" name="submit">
                            SignUp
                        </button>
                        <br>
                        <p class="reg">Already have an account? <a href="login.php">LogIn</a></p>
                    </div>
                </form>
            </div>
        </div>

        <script src="./jsfiles/onclickscript.js"></script>
    </div>
</body>

</html>