<?php
if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' ||
    $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

session_start();
require './required/ads_query.php';
setcookie("search", "search", time() + (-86400 * 1), "/");
setcookie("filter", "filter", time() + (-86400 * 1), "/");
setcookie("page_name", "", time() + (-86400 * 1), "/");
setcookie("uni_folder", "", time() + (-86400 * 1), "/");
setcookie("clicked_id", "", time() + (-86400 * 1), "/");
setcookie("pricesearch", "", time() + (-86400 * 1), "/");
setcookie("code", "", time() + (-900 * 1), "/");
setcookie("email", "", time() + (-900 * 1), "/");

//  pop-up for install
require './required/app_install.php';
require './required/alerts.php';
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<script>alert('$error')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        // fn to close app install
        function close_ad() {
            document.getElementById("app_install_container_div").style.display = "none";
        }
        document.addEventListener('DOMContentLoaded', function() {
            function isInstalled() {
                if (window.navigator.standalone) { // For iOS
                    return true;
                } else if (window.matchMedia('(display-mode: standalone)').matches) { // If neither is true, it's not installed
                    return true;
                } else {
                    return false; // For Android
                }
            }

            if (isInstalled() === false) {
                let deferredPrompt;
                const addBtn = document.querySelector('#install');
                const appDiv = document.querySelector('#app_install_container_div');

                window.addEventListener('beforeinstallprompt', event => {
                    event.preventDefault();
                    deferredPrompt = event;
                    appDiv.style.display = 'flex';
                });

                addBtn.addEventListener('click', event => {
                    deferredPrompt.prompt();

                    deferredPrompt.userChoice.then(choice => {
                        if (choice.outcome === 'accepted') {
                            console.log('User accepted the prompt');
                            appDiv.style.display = 'none';
                        }
                        deferredPrompt = null;
                    });
                });
            }
        });
        if (typeof navigator.serviceWorker !== 'undefined') {
            navigator.serviceWorker.register('sw.js')
        }
    </script>
    <meta name="google-site-verification" content="3DpOPyMzbY1JYLNtsHzbAZ_z6o249iU0lE5DYE_mLJA" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CasaMax LandingPage</title>
    <link rel="stylesheet" href="index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <meta name="description" content=" Student boarding-houses in Zimbabwe at affordable prices....">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" type="image/png" href="./images/logowhite.png">
    <meta name="theme-color" content="#08080C" />
    <link rel="apple-touch-icon" href="iconsicons/192x192.png">


</head>

<body onunload="">
<script src="index.js"></script>

    <div class="container">

        <header>
            <a href="index.php">
                <img src="images/logowhite.png" alt="logo" class="logo">
            </a>

            <nav id="navBar">
                <h3 class="smltxt">CasaMax</h3>
                <img src="images/menu.webp" alt="menu" onclick="togglebtn()" class="fas">
                <br>
                <a href="./index.php" class="home">HOME</a>
                <a href="./manage/index.php">MANAGE RENTAL</a>
                <a href="advertise_as/index.php">ADVERTISE</a>
                <a href="help.php">HELP</a>
                <a href="./chat/screens/">MY CHATS</a>
                <?php
                if (!isset($_SESSION['sessionstudent'])) {
                    echo '<a href="./loginas.php" class="sign_in" name="loginbtn">LOGIN</a>';
                } else {
                    echo '<a href="./student_profile.php" class="sign_in" name="loginbtn">MY PROFILE</a>';
                }
                ?>
            </nav>

            <!-- popup for cookie consent -->
            <div class="consent hide">
                <button class="cookie_btn">
                    I UNDERSTAND!
                </button>
                <img src="images/cookies3.webp" alt="">
                <h2>
                    We Use Cookies!!
                </h2>
                <p>
                    We use cookies and other technologies to help personalize content and provide for a better experience. Without cookies some functionalities will not function properly!!
                </p>



                <script>
                    window.onload = function() {
                        const cookieBox = document.querySelector(".consent"),
                            acceptBtn = cookieBox.querySelector("button");
                        acceptBtn.onclick = () => {
                            document.cookie = "HomeRun=HomeRunCookie; max-age=" + 60 * 60 * 24 * 30;
                            if (document.cookie) {
                                cookieBox.classList.add("hide");
                            } else {
                                alert("Cookie can't be set! Please visit your setting and remove cookie restrictions for this site")
                            }
                        }
                        let checkCookie = document.cookie.indexOf("HomeRun=HomeRunCookie");
                        checkCookie != -1 ? cookieBox.classList.add("hide") : cookieBox.classList.remove("hide");
                    }
                </script>
            </div>

            <!-- main content -->
            <h1>
                CasaMax
            </h1>
            <a href="#cta" style="color:white; text-decoration: none;  animation: text 2s ease infinite;">Click to know about us!</a>

            <p class="srch-p">
                Find Your Next Home
            </p>
            <div class="search-bar">
                <form method="POST" action="homerunphp/searchaction.php">

                    <div class="search-form">
                        <div class="left-col">

                            <select name="university" id="dropdown">

                                <option value="none">Choose a University</option>
                                <option value="University of Zimbabwe">University of Zimbabwe</option>
                                <option value="Midlands State University">Midlands State University</option>
                                <option value="Africa Univeristy">Africa Univeristy</option>
                                <option value="Bindura State University">Bindura State University</option>
                                <option value="Chinhoyi University of Science and Technology">Chinhoyi University of Science and Technology</option>
                                <option value="Great Zimbabwe University">Great Zimbabwe University</option>
                                <option value="Harare Institute of Technology">Harare Institute of Technology</option>
                                <option value="National University of Science and Technology">National University of Science and Technology</option>


                            </select>

                        </div>

                        <div class="right-col">
                            <input type="number" name="pricesearch" min="0" placeholder="Max amount per Month in USD$?" required title="Enter an amount in USD">

                        </div>

                    </div>

                    <div class="search-btn">

                        <button name=" ">
                            <img src="images/searchicon.webp" alt="search">

                        </button>

                    </div>
                </form>
            </div>
        </header>
        <!-- BROWSE Student -->
        <div class="containersub">
            <hr>
            <h2 class="sub-title text-blue-600">
                BROWSE
                <p>
                    (BOARDING HOUSES BY UNI)
                </p>
            </h2>
            <hr>
            <div class="browse">

                <a href="./unilistings/uzlisting.php">
                    <div>
                        <img src="./images/UZ.webp" alt="">

                        <h3>University of Zimbabwe</h3>

                    </div>
                </a>
                <a href="unilistings/aulisting.php">

                    <div>
                        <img src="./images/AU.webp" alt="">

                        <h3>
                            Africa University
                        </h3>

                    </div>
                </a>

                <a href="unilistings/cutlisting.php">
                    <div>

                        <img src="./images/CUT.webp" alt="">

                        <h3>
                            Chinhoyi University of Technology
                        </h3>
                    </div>
                </a>

                <a href="unilistings/gzlisting.php">
                    <div>
                        <img src="./images/GZ.webp" alt="">

                        <h3>
                            Great Zimbabwe University
                        </h3>
                    </div>
                </a>

                <a href="unilistings/hitlisting.php">
                    <div>
                        <img src="./images/HIT.webp" alt="">

                        <h3>
                            Harare Institute of Technology
                        </h3>
                    </div>
                </a>

                <a href="unilistings/msulisting.php">
                    <div>
                        <img src="./images/MSU.webp" alt="">
                        <h3>
                            Midlands State University
                        </h3>

                    </div>
                </a>

                <a href="unilistings/nustlisting.php">
                    <div>
                        <img src="./images/NUST.webp" alt="">
                        <h3>
                            National University of Science and Technology
                        </h3>

                    </div>
                </a>

                <a href="unilistings/bsulisting.php">
                    <div>
                        <img src="./images/BSU.webp" alt="">
                        <h3>
                            Bindura University of Science and Education
                        </h3>

                    </div>
                </a>
            </div>

            <div class="cta" id="cta">
                <h3>
                    Sharing Is Earning
                </h3>
                <p>
                    Grasp The Great Opportunity to make money with shared spaces.
                </p>

                <a href="know_more.php"> <button class="cta-btn"> Know More </button></a>

            </div>
        </div>
        <hr>

        <!-- footer -->
        <div class="footer">
            <h3 class="abt">
                <a href="aboutus.php">About</a> CasaMax
            </h3>
            <p>
                Looking for a House to Rent?
                Welcome to CasaMax, where we provide all the available
                Homes and Rental properties at the tip of your fingers
            </p>
            <p class="abt">
                <a href="../privacy_policy.html">Our Privacy Policy</a>

                <a href="../disclaimer.html">Disclaimer</a>
            </p>



            <div class="socialicons">
                <a href="https://www.facebook.com/profile.php?id=100093414304668" data-tabs="timeline"><img src="./images/facebook.png" alt="" title="Our-Facebook-page"></a>
                <a href="https://www.instagram.com/homerunzim/"><img src="./images/instagram.png" alt="" title="Our-Instagram-page"></a>
                <a href="https://wa.me/+263786989144"> <img src="./images/whatsapp.png" alt="" title="Our-WhatsApp-page"></a>
                <a href="mailto:homerunzim@gmail.com?subject=Feedback to HomeRun&cc=c"> <img src="./images/mail.png" alt="" title="Email"></a>
                <a href=""><img src="./images/twitter.png" alt="" title="Our-twitter-page"></a>
            </div>
        </div>
    </div>
    <?php
    if (!isset($_GET['chat_id'])) {
    ?>
        <div class="floating_chat_icon" title="chats">
            <a href="https://localhost/casamax/chat/screens/">
                <img src="https://localhost/casamax/images/new-message.png" alt="">
            </a>
        </div>
    <?php
    }
    ?>
    <script src="./jsfiles/onclickscript.js"></script>
    <script src="app.js"></script>
    <script src="./chat/scriptjs/user_status.js"></script>
</body>

</html>