<?php
session_start();
require './required/ads_query.php';
setcookie("page_pass", "homerunuserdb", time() + (900 * 1), "/");
setcookie("loginPage", "login.php", time() + (900 * 1), "/");

$sec = "0.1";

if (isset($_POST['logout'])) {
    unset($_SESSION['sessionstudent']);
    session_destroy();
    echo '<script type="text/javascript"> alert("Logout Successful")</script>';

    header("refresh:$sec;  index.php?Logoutsuccessful");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require './required/header.php';
    ?>
    <meta name="description" content="Login as a Student and enjoy vast options of homes to choose for your off-campus accommodation">
    <link rel="icon" href="images/logowhite.png">
    <link rel="stylesheet" href="signup.css">
    <title>CasaMax Student LogIn</title>
</head>

<body onunload="" class="scrollable">

    <?php
    require_once 'required/pageloader.php';
    ?>
    <div class="container">
        <div class="login-container">
            <div class="left-login">
                <lottie-player
                    src="https://lottie.host/54b560aa-0926-4f33-ba56-bc874c3cdf00/HGgMex1FgU.json"
                    background="transparent"
                    speed="1"
                    style="width: 70%; height: 70%;"
                    loop
                    autoplay>
                </lottie-player>
            </div>
            <div class="right-login">
                <header>
                    <a href="index.php">
                        <img src="images/logoorange.png" alt="logo" class="logo">
                    </a>
                </header>
                <form action="./homerunphp/loginscript.php?redirect=<?php echo $redirect ?>" method="post">
                    <div>
                        <h1>Student LogIn</h1>
                    </div>

                    <div class="input-label">
                        <label for="email">Email<span style="color: red; font-size:10px;">*</span></label>
                        <input type="email" id="email" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="input-label">
                        <label for="upword">Password<span style="color: red; font-size:10px;">*</span></label>
                        <input type="password" id="pword" placeholder="Enter your Password" name="password" required>
                    </div>
                    <div class="login">
                        <div>
                            <button type="submit" name="submit" class="login_btn">
                                Log-In
                            </button>
                            <br>
                        </div>
                    </div>
                </form>
                <div class="lower-login">
                    <form action="homerunphp/loginscript.php" method="post">
                        <button name="logout" class="logout_btn">
                            Log-Out
                        </button>
                        <p class="reg">Don't have an account? <a href="signup.php">Register</a></p>
                    </form>
                    <div class="fpass">
                        <a href="required/fpass.php">forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>