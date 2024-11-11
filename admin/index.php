<?php
session_start();
setcookie("page_pass", "homerunuserdb", time() + (900 * 1), "/");
setcookie("loginPage", "login.php", time() + (900 * 1), "/");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-48DWXXLG5F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-48DWXXLG5F');
    </script>
    <?php
    require '../required/header.php';
    ?>
    <meta name="description" content="Login as a Student and enjoy vast options of homes to choose for your off-campus accommodation">
    <link rel="icon" href="../images/logowhite.png">
    <link rel="stylesheet" href="../signup.css">
    <title>CasaMax Admin Log-In</title>
</head>

<body onunload="" class="scrollable">

    <?php
    require_once '../required/pageloader.php';
    ?>
    <?php

    if (isset($_POST['logout'])) {
        unset($_SESSION['sessionstudent']);
        session_destroy();
        redirect('./index.php?error=You Have Logged Out Successfully');
    }
    ?>

    <div class="container">
        <div class="login-container">
            <!-- <div class="left-login">
                <lottie-player
                    src="https://lottie.host/54b560aa-0926-4f33-ba56-bc874c3cdf00/HGgMex1FgU.json"
                    background="transparent"
                    speed="1"
                    style="width: 70%; height: 70%;"
                    loop
                    autoplay>
                </lottie-player>
            </div> -->
            <div class="right-login">
                <header>
                    <a href="../index.php">
                        <img src="../images/logoorange.png" alt="logo" class="logo">
                    </a>
                </header>
                <form action="../homerunphp/admin_login_script.php" method="post">
                    <div>
                        <h1>Admin LogIn</h1>
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
                        <button type="submit" name="submit" class="login_btn">
                            Log-In
                        </button>
                    </div>
                </form>
                <div class="lower-login">
                    <form action="../homerunphp/loginscript.php" method="post">
                        <button name="logout" class="logout_btn">
                            Log-Out
                        </button>
                        <p class="reg">Don't have an account? <a href="signup.php">Register</a></p>
                    </form>
                    <div class="fpass">
                        <a href="../required/fpass.php">forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>