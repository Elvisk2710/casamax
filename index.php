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
    <!-- Include Intro.js CSS -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css">
    <meta name="google-site-verification" content="3DpOPyMzbY1JYLNtsHzbAZ_z6o249iU0lE5DYE_mLJA" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CasaMax LandingPage</title>
    <link rel="stylesheet" href="index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" Student boarding-houses in Zimbabwe at affordable prices....">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" type="image/png" href="./images/logowhite.png">
    <meta name="theme-color" content="#08080C" />
    <link rel="apple-touch-icon" href="iconsicons/192x192.png">


</head>

<body onunload="">
    <script src="index.js"></script>
    <!-- Include Intro.js JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
    <?php
    require './required/root-nav.php';
    ?>
    <div class="container">

        <header data-intro="Welcome to CasaMax! Let us guide you through our main features." data-step="1">
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
            <div class="left-header">
                <h1>
                    The Perfect Home for Your Study Life
                </h1>
                <a href="#cta" style="color:rgb(241,241,241,0.6); text-decoration: none;  animation: text 2s ease infinite;">Click to know about us!</a>
                <p class="srch-p">
                    Find Your Next Home
                </p>
                <div class="search-bar" data-intro="Use this search bar to find your next home by selecting a university and setting a budget." data-step="4" data-position="bottom">
                    <form method="POST" action="homerunphp/searchaction.php">

                        <div class="search-form">
                            <div class="left-col">

                                <select name="university" id="dropdown" data-intro="Select your university from this dropdown menu." data-step="5" data-position="right">

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
                                <input type="number" name="pricesearch" min="0" placeholder="Monthly Budget in USD$?" required title="Enter an amount in USD" data-intro="Enter the maximum amount you are willing to pay per month here." data-step="6" data-position="right">
                            </div>
                        </div>
                        <div class="search-btn">
                            <button name=" " data-intro="Click this button to start your search." data-step="7" data-position="bottom">
                                <img src="images/searchicon.png" alt="search">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="right-header">
                <lottie-player
                    src="https://lottie.host/1c0dd04b-5a3f-4809-9363-8bf8ce288271/0rq7KbvgzG.json"
                    background="transparent"
                    speed="1"
                    style="width: 80%; height: 80%;"
                    loop
                    autoplay>
                </lottie-player>
                <p>
                    Tired of distractions at home? Our platform connects you with the best boarding houses in Zimbabwe, offering a quiet, comfortable, and convenient environment for your academic pursuits. Elevate your study experience and find your ideal home away from home.
                </p>
            </div>

        </header>
        <!-- BROWSE Student -->
        <div class="containersub" id="browse">
            <div class="heading-text">
                <a href="#browse">
                    <h2 class="sub-title">
                        What We Have To Offer
                    </h2>
                </a>
            </div>
            <div class="about-div">
                <div class="about-card" style="background-color: rgb(8, 8, 12,0.8)">
                    <h3 style="color: white;">
                        Fill Your Rooms, Find Your Tenants
                    </h3>
                    <p style="color: white;">
                        Tired of empty rooms? Let us connect you with students seeking quality accommodation. List your property today, connect to students and start earning.
                    <div class="about-div-btn">
                        <a href="./advertise/">
                            <button style="background-color: rgb(252, 153, 82); color: rgb(8, 8, 12);">
                                Get Started
                            </button>
                        </a>
                    </div>
                </div>
                <div class="about-card" style="background-color: white; opacity: 0.8;">
                    <h3>
                        Fill Your Needs, Find Your Boarding House
                    </h3>
                    <p>
                        Discover your perfect study haven. Tired of distractions at home? Find the ideal boarding house that offers a quiet, comfortable, and convenient environment for your studies. Let us help you achieve your academic goals.
                    </p>
                    <div class="about-div-btn">
                        <a href="#browse">
                            <button style="background-color: rgb(252, 153, 82); color:white;">
                                Get Started
                            </button>
                        </a>
                    </div>
                </div>
                <div class="about-card" style="background-color: rgb(252,153,82,0.8)">
                    <h3>
                        We Bridge The Gap
                    </h3>
                    <p>
                        Our platform connects landlords and students, streamlining the process of finding the perfect match. With our efficient matching system, we ensure that both parties connect seamlessly, saving time and effort for everyone involved.
                    </p>
                    <div class="about-div-btn">
                        <a href="./aboutus.php">
                            <button style="background-color: rgb(8, 8, 12); color:rgb(252, 153, 82);">
                                Know More
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="browse" data-intro="Choose your university to browse through all available listings." data-step="8" data-position="top">

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
        </div>
        <div class="cta" id="cta">
            <h3>
                Seize the Moment: <b>Profit from Shared Spaces </b>
            </h3>
            <p>
                Discover the lucrative potential of shared spaces. With the growing demand for Boarding Houses, now is the perfect time to invest in this thriving market. The opportunities for profit are endless. Don't miss out on this golden chance to capitalize on the shared economy.
            </p>
            <a href="know_more.php"> <button class="cta-btn"> Know More </button></a>
        </div>
        <!-- footer -->
        <?php
        require './required/root-footer.php';
        // if (!isset($_GET['chat_id'])) {
        // 
        ?>
        // <div class="floating_chat_icon" title="chats" data-intro="View your recent chats with landlords." data-step="9" data-position="top">
            // <a href="./chat/screens/">
                // <img src="./images/new-message.png" alt="">
                // </a>
            // </div>
        // <?php
            // }
            ?>
        <script src="./jsfiles/onclickscript.js"></script>
        <script>
            // Function to set a cookie
            function setCookie(name, value, days) {
                const d = new Date();
                d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
                const expires = "expires=" + d.toUTCString();
                document.cookie = name + "=" + value + ";" + expires + ";path=/";
            }

            // Function to get a cookie
            function getCookie(name) {
                const cname = name + "=";
                const decodedCookie = decodeURIComponent(document.cookie);
                const ca = decodedCookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(cname) === 0) {
                        return c.substring(cname.length, c.length);
                    }
                }
                return "";
            }

            function startTour() {
                const tourSeen = getCookie("tourSeen");

                if (!tourSeen) {
                    setCookie("tourSeen", "true", 365);
                    const intro = introJs();
                    introJs().start();
                    introjs - disableInteraction;
                }
            }

            document.addEventListener('DOMContentLoaded', (event) => {
                startTour();
            });
        </script>
</body>

</html>