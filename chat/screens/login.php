<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once '../../required/header.php';
    ?>
    <meta name="description" content="Login as a Student and enjoy vast options of homes to choose for your off-campus accommodation">
    <link rel="icon" href="../../images/logowhite.png">
    <link rel="stylesheet" href="../../signup.css">
    <title>CasaMax Admin Log-In</title>


</head>


<body onunload="" class="scrollable">

    <?php
    require_once '../../required/pageloader.php';
    ?>
    <header>
        <a href="../../index.php"><img src="../../images/logowhite.png" alt="logo" class="logo"></a>
    </header>

    <div class="container">
        <form action="" method="post" >
            <div>
                <h3 class="h3reg">Chat</h3>
                <h1>Log-In</h1>
            </div>

            <div class="input-label">
                <label for="email">Email<span style="color: red; font-size:10px;">*</span></label>
                <input type="email" id="email" placeholder="Email Address" name="email" required>

            </div>
            <div class="input-label">
                <label for="upword">Password<span style="color: red; font-size:10px;">*</span></label>
                <input type="password" id="pword" placeholder="Enter your Password" name="password" required>
                <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>

            </div>

            <div class="login">
                <div>
                <a href="./index.php">
                    <button type="button" name="submit" class="login_btn">
                        Log-In
                    </button>
                    </a>
                    <br>
                </div>
            </div>

            <script>
                const togglePassword = document.querySelector('#togglePassword');
                const password = document.querySelector('#pword');

                togglePassword.addEventListener('click', function(e) {
                    // toggle the type attribute
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    // toggle the eye slash icon
                    this.classList.toggle('fa-eye-slash');
                });
            </script>
        </form>

        <form action="" method="post">

            <div class="login">
                <button name="logout" class="logout_btn">
                    Log-Out
                </button>
            </div>
        </form>
        <br>
        <div class="fpass">
            <a href="../required/fpass.php">forgot your password?</a>
        </div>

        <?php
        $sec = "0.1";

        if (isset($_POST['logout'])) {
            unset($_SESSION['sessionstudent']);

            echo '<script type="text/javascript"> alert("Logout Successful")</script>';

            header("refresh:$sec;  index.php?Logoutsuccessful");
        }
        ?>

    </div>
</body>

</html>