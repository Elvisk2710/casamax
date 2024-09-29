<?php
session_start();
require './required/ads_query.php';
setcookie("scriptPage", "fpassscript.php", time() + (900 * 1), "/");
setcookie("page_pass", "homerunhouses", time() + (900 * 1), "/");
setcookie("loginPage", "homeownerlogin.php", time() + (900 * 1), "/");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require './required/header.php';
    ?>
    <meta name="description" content="Login as a Home-owner and manage your Rental. Change, Delete, Add information as you may please....">
    <link rel="icon" href="images/logowhite.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>CasaMax Home LogIn</title>
    <link rel="stylesheet" href="signup.css">

</head>


<body onunload="" class="scrollable">

    <?php
    require_once 'required/pageloader.php';

    ?>

    <div class="container">
        <div class="login-container">
            <div class="left-login">
                <lottie-player
                    src="https://lottie.host/12be720b-5ba7-4989-a48d-1cbd6de19286/qAUt599WBl.json"
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
                <form action="homerunphp/homeownerloginscript.php?redirect=<?php echo $redirect ?>" method="post">
                    <div>
                        <h1>Landlord LogIn</h1>
                    </div>
                    <div class="input-label">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="Email" name="email" required>
                    </div>
                    <div class="input-label">
                        <label for="upword">Password</label>
                        <input type="password" id="pword" placeholder="Password" name="password" required>
                    </div>
                    <div class="login">
                        <button type="submit" name="submit">
                            Log-In
                        </button>
                    </div>
                </form>
                <div class="lower-login">
                    <form action="homerunphp/homeownerloginscript.php" method="post">
                        <button name="logout" class="logout_btn">
                            Log-Out
                        </button>

                        <p class="reg">Don't have an account? <a href="advertise/index.php">Register</a></p>

                    </form>
                    <div class="fpass">
                        <a href="required/fpass.php">forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <?php

    if (isset($_POST['logoutowner'])) {
        unset($_SESSION['sessionowner']);

        header("Location: index.php?Logoutsuccessful");

        echo '<script type="text/javascript"> alert("Logout Successful")</script>';
    }
    ?>

    </div>
</body>

</html>