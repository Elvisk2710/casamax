<?php
session_start();
require './required/ads_query.php';
setcookie("scriptPage", "fpassscript.php", time() + (900 * 1), "/");
setcookie("page_pass", "homerunhouses", time() + (900 * 1), "/");
setcookie("loginPage", "homeownerlogin.php", time() + (900 * 1), "/");
$redirect = '';
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    custonAlert($error);
}
if (isset($_GET['redirect'])) {
    $redirect = $_GET['redirect'];
}
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
    <header>
        <a href="index.php"><img src="images/logowhite.png" alt="logo" height="80px" width="100px" class="logo"></a>
    </header>

    <div class="container">

        <form action="homerunphp/homeownerloginscript.php?redirect=<?php echo $redirect ?>" method="post">
            <div>
                <h3 class="h3reg">Home-Owner</h3>
                <h1>Log-In</h1>
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

                <button type="submit" name="submit">
                    Log-In
                </button>

                <br>

        </form>


        <form action="homerunphp/homeownerloginscript.php" method="post">
            <button name="logout" class="logout_btn">
                Log-Out
            </button>
    </div>

    <p class="reg">Don't have an account? <a href="advertise/index.php">Register</a></p>

    </form>

    <div class="fpass">
        <a href="required/fpass.php">forgot your password?</a>
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