<?PHP
require_once '../homerunphp/homerunuserdb.php';
setcookie("scriptPage", "agent_login_script.php", time() + (900 * 1), "/");
setcookie("page_pass", "homerunuserdb", time() + (900 * 1), "/");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Sign-up as an agent to advertise your off campus accommodation to students">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="icon" href="../images/logowhite.png">
    <title>CasaMax Agent-SignUp</title>
    <link rel="stylesheet" href="../signup.css">
    <?php
    require '../required/header.php';
    ?>
</head>


<body onunload="" class="scrollable">
    <?php
    require '../required/pageloader.php';
    ?>
    <div class="container">
        <div class="login-container">
            <div class="left-sign-up">
                <h1>
                    Let's Get You Signed Up!
                </h1>
                <lottie-player
                    src="https://lottie.host/12be720b-5ba7-4989-a48d-1cbd6de19286/qAUt599WBl.json"
                    background="transparent"
                    speed="0.5"
                    style="width: 70%; height: 70%;"
                    loop
                    autoplay>
                </lottie-player>
            </div>
            <div class="right-sign-up">
                <form class="sign-up-container" action="./agent_register_script.php" method="post">
                    <div>
                        <h1>Agent Registration</h1>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="uname">First-Name <span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your First Name" type="text" id="frstnme" name="firstname" placeholder="Enter your First-Name" required>

                        </div>
                        <div class="input-label">
                            <label for="uname">Last-Name <span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your Larst Name" type="text" id="lstnme" name="lastname" placeholder="Enter your Last-Name" required>

                        </div>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="upword">Password<span style="color: red; font-size:10px;">*</span></label>
                            <div class="password">
                                <input title="Enter Your Password" type="password" id="pword" name="password" placeholder="Enter your Password" required>
                            </div>
                        </div>
                        <div class="input-label">
                            <label for="upword">Confirm Password<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your Passord" type="password" id="cpword" name="confirmpassword" placeholder="Enter your Password" required>

                        </div>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="email">Email<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your Email " type="email" id="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="input-label">
                            <label for="email">National ID Number<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your id number " type="text" id="id_num" name="id_num" placeholder="National ID number" required>
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="email">Agent Fee<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your id number " type="number" id="id_num" name="agent_fee" placeholder="$agent fee" required>

                        </div>
                        <div class="input-label">
                            <label for="email">Agent tag-line<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your id number " type="text" id="id_num" name="tagline" placeholder="eg. UZOCA" required>

                        </div>
                    </div>
                    <div class="input-div">
                        <div class="input-label">
                            <label for="gender">Gender<span style="color: red; font-size:10px;">*</span></label>
                            <div class="radio">
                                <div class="gender_container">
                                    <label for="male" class="man">Male<span style="color: red; font-size:10px;">*</span></label>
                                    <input type="radio" id="male" value="M" name="gender">
                                </div>
                                <div class="gender_container">
                                    <label for="female" class="woman">Female<span style="color: red; font-size:10px;">*</span></label>
                                    <input type="radio" id="female" value="F" name="gender">
                                </div>
                            </div>
                        </div>
                        <div class="input-label">
                            <label for="phone">Contact<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your Phone Number" min="0" type="number" id="phone" name="contact" placeholder="Enter Contact" required>
                        </div>
                    </div>
                    <div>
                        <label for="checkbox" class="checkbox"><input type="checkbox" id="checkbox" required><a href="../terms_of_service.html">I hereby accept all the terms and conditions</a><span style="color: red; font-size:10px;">*</span></label>
                    </div>
                    <div class="login">
                        <button type="submit" name="submit">
                            SignUp
                        </button>
                        <br>
                        <p class="reg">Already have an account? <a href="index.php">LogIn</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../jsfiles/onclickscript.js"></script>
    </div>
</body>

</html>