<?php
session_start();
setcookie("code", '', time() + (-900 * 1), "/");
setcookie("email", '', time() + (-900 * 1), "/");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../signup.css">
    <title>CasaMax Reset Password</title>
    <link rel="icon" href="../images/logowhite.png">
    <meta name="description" content="Our staff is committed to help you choose the right Home. Home Rental Real Estate Business. For School, Familiy Or a Commercial space . No Hidden Costs..">


</head>

<body onunload="" class="scrollable">

    <?php
    require_once 'pageloader.php';
    ?>
    <div class="container">
        <div class="right-login">
            <div class="fpass-container">
                <header>
                    <a href="index.php">
                        <img src="../images/logoorange.png" alt="logo" class="logo">
                    </a>
                </header>
                <form action="../homerunphp/fpassscript.php" method="post">
                    <div>
                        <h1>Set New Password</h1>
                    </div>

                    <div class="input-label">
                        <label for="email">Email<span style="color: red; font-size:10px;">*</span></label>
                        <input type="email" id="email" placeholder="Email Address" name="email" required title="enter your email">

                    </div>
                    <div class="input-label">
                        <label for="upword">New-Password<span style="color: red; font-size:10px;">*</span></label>
                        <input type="password" id="pword" placeholder="Enter your New Password" name="password" required>

                    </div>
                    <div class="input-label">
                        <label for="upword">Confirm Password<span style="color: red; font-size:10px;">*</span></label>
                        <input type="password" id="pword" placeholder="Enter your New Password" name="confirm_password" required>

                    </div>
                    <div class="login">
                        <div>
                            <button type="submit" name="submit" class="login_btn">
                                UPDATE
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>