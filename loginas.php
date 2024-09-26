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
                    <a href="index.php">
                        <img src="images/logoorange.png" alt="logo" class="logo">
                    </a>
                </header>
                <div class="btn-container">
                    <div>
                        <h1>Log-In As</h1>
                    </div>
                    <div class="login">
                        <a href="homeownerlogin.php?redirect=<?php echo $redirect ?>"><button type="button" name="submit">
                                Landlord
                            </button>
                        </a>
                    </div>
                    <div class="login">
                        <a href="login.php?redirect=<?php echo $redirect ?>"><button type="button" name="submit">
                                Student
                            </button></a>
                    </div>
                    <div class="login">
                        <a href="./agent/"><button type="button" name="submit">
                                Agent
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>