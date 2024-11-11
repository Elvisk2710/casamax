<?php
session_start();
setcookie("page_pass", "agents", time() + (900 * 1), "/");
setcookie("loginPage", "agent/index.php", time() + (900 * 1), "/");
$sec = "0.1";

if (isset($_POST['logout'])) {
    unset($_SESSION['sessionagent']);

    echo '<script type="text/javascript"> alert("Logout Successful")</script>';

    header("refresh:$sec;  ../index.php?error=Log-Out Successful");
}
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
    <meta name="description" content="Login as an Agent and enjoy the vast benefits of advertising on casamax ">
    <?php
    require '../required/header.php';
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="icon" href="../images/logowhite.png">
    <link rel="stylesheet" href="../signup.css">
    <title>CasaMax Agent Log-In</title>


</head>


<body onunload="" class="scrollable">
    <?php
    require_once '../required/pageloader.php';
    ?>
    <div class="container">
        <div class="login-container">
            <div class="left-login">
                <lottie-player
                    src="https://lottie.host/0039a8dd-b3e3-4ed5-8ac1-af027ca2d3e6/quHMLFe402.json"
                    background="transparent"
                    speed="1"
                    style="width: 70%; height: 70%;"
                    loop
                    autoplay>
                </lottie-player>
            </div>
            <div class="right-login">
                <header>
                    <a href="../index.php">
                        <img src="../images/logoorange.png" alt="logo" class="logo">
                    </a>
                </header>
                <form action="./agent_login_script.php" method="post">
                    <div>
                        <h1>Agent LogIn</h1>
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
                    <form action="agent_login_script.php" method="post">
                        <button name="logout" class="logout_btn">
                            Log-Out
                        </button>
                        <p class="reg">Don't have an account? <a href="./agent_register.php">Register</a></p>
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