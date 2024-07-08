<?php
session_start();
require './required/ads_query.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require './required/header.php';
    ?>
    <meta name="description" content="Login and enjoy vast options of homes to choose for your off-campus accommodation">
    <link rel="icon" href="images/logowhite.png">
    <link rel="stylesheet" href="signup.css">
    <title>CasaMax LogIn</title>
</head>

<body onunload="" class="scrollable">
    <?php
    require_once 'required/pageloader.php';
    $chat = true;
    ?>
    <header>
        <a href="index.php">
            <img src="images/logowhite.png" alt="logo" class="logo">
        </a>
    </header>
    <div class="container">
        <div>
            <h1>Log-In As</h1>
        </div>
        <div class="login">
            <a href="homeownerlogin.php?redirect=<?php echo $redirect ?>"><button type="button" name="submit">
                    HOME OWNER
                </button>
            </a>
        </div>
        <div class="login">
            <a href="login.php?redirect=<?php echo $redirect ?>"><button type="button" name="submit">
                    STUDENT
                </button></a>
        </div>
        <div class="login">
            <a href="./agent/"><button type="button" name="submit">
                    AGENT
                </button></a>
        </div>
    </div>
</body>

</html>