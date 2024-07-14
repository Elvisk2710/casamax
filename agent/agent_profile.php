<?php
session_start();
require_once '../homerunphp/advertisesdb.php';

if (empty($_SESSION['sessionagent'])) {
    header("Location:index.php?eeror=Please Login");
    echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
    exit();
} else {
    $user = $_SESSION['sessionagent'];
    $sql = "SELECT * FROM  agents WHERE email = '$user' ";
    setcookie("update", $user, time() + (86400 * 1), "/");
    if ($rs_result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($rs_result);
        $agent_id = $row['agent_id'];
        setcookie("agent_id", $agent_id, time() + (900 * 1), "/");
        $sql_home = "SELECT * FROM  homerunhouses WHERE agent_id = '$agent_id' ";

        if (!$home_result = mysqli_query($conn, $sql_home)) {
            header("Location:index.php?error=SQL ERROR");
            echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
            exit();
        }
    } else {
        header("Location:index.php?error=Please Login");
        echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
        exit();
    }
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
    <link rel="icon" href="../images/logowhite.png">
    <meta name="google-site-verification" content="3DpOPyMzbY1JYLNtsHzbAZ_z6o249iU0lE5DYE_mLJA" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="agent_profile_css.css">
    <title>Agent Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <meta name="description" content=" Quick and Easy way to find your next home off-campus for tertiary students at an affordable price....">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#08080C" />
    <link rel="apple-touch-icon" href="iconsicons/192x192.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@300&family=Oswald:wght@600&family=Quicksand&family=Source+Sans+3:wght@200&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inconsolata:wght@300&family=Oswald:wght@600&family=Quicksand&family=Source+Sans+3:wght@200&display=swap');
    </style>
    <script async src="https://fundingchoicesmessages.google.com/i/pub-5154867814880124?ers=1" nonce="FAQn2jAMsnFBc1XDFT5Hkg"></script>
    <script nonce="FAQn2jAMsnFBc1XDFT5Hkg">
        (function() {
            function signalGooglefcPresent() {
                if (!window.frames['googlefcPresent']) {
                    if (document.body) {
                        const iframe = document.createElement('iframe');
                        iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;';
                        iframe.style.display = 'none';
                        iframe.name = 'googlefcPresent';
                        document.body.appendChild(iframe);
                    } else {
                        setTimeout(signalGooglefcPresent, 0);
                    }
                }
            }
            signalGooglefcPresent();
        })();
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5154867814880124" crossorigin="anonymous"></script>
</head>

<body onunload="" class="scrollable">
    <?php
    require_once '../required/pageloader.php';
    ?>
    <header>

        <div class="logo_container">
            <a href="../index.php"><img src="../images/logowhite.png" alt="logo" class="logo"></a>
            <?php if (isset($_GET['error'])) {
                $error = $_GET['error'];
                echo '<div class="error" id = "error">
            <h1>' .
                    $error
                    . '</h1>
        </div>';
            } ?>
            <div class="logout_div">
                <form action="./agent_login_script.php" method="post">
                    <button class="edit_info_button" name="logout">
                        Log-Out
                    </button>
                </form>
            </div>
        </div>

        <div class="header_container">

            <br>
            <div class="details">
                <div class="name">
                    <h1>
                        Hey <?php echo $row['lastname'] . ' ' . $row['firstname'] ?>!
                    </h1>
                </div>
                <div class="agent_details">
                    <span>
                        <h3>
                            Agent ID
                        </h3>
                        <p>
                            <?php echo $row['agent_id'] ?>
                        </p>
                    </span>
                    <span>
                        <h3>
                            Contact
                        </h3>
                        <p>
                            <?php echo $row['contact'] ?>
                        </p>
                    </span>
                    <span>
                        <h3>
                            Email
                        </h3>
                        <p>
                            <?php echo $row['email'] ?>
                        </p>
                    </span>
                    <span>
                        <h3>
                            Verified
                        </h3>
                        <p>
                            <?php
                            if ($row['verified'] == 1) {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            }
                            ?>
                        </p>
                    </span>
                </div>
            </div>

        </div>

        <div class="change_info">
            <button class="change_info_btn" onclick="open_agent_change_info()">
                Change My Info
            </button>
        </div>
    </header>
    <br>
    <?php

    $date1 = date_create($_SESSION['date_joined']);
    $today = new DateTime();

    $interval = $date1->diff($today);
    $days_difference = $interval->format('%a');

    $days_left = 30 - $days_difference;
    $directoryPath = '../verification_images/agents_verification_images/' . $agent_id . '/';
    if ($row['verification_image'] == null && !file_exists($directoryPath)) {

    ?> 
        <form action="./agent_update_images.php?agent_id=<?php echo $agent_id; ?>" method="post" enctype="multipart/form-data" class="verification_container" id="verification_container">
            <div class="verification_popup">
                <h2>
                    Add verification documents
                </h2>
                <br>
                <h1 style="color: rgb(252,153,82);">
                    <?php
                    if ($days_left <=  30 && $days_left > 0) {
                        echo $days_left . " Days Left";
                    }
                    ?>
                </h1>
                <br>
                <p class="verification_text">
                    Accounts have to be verified in within 30 days of creation. Failure to do will result in account suspension and your listings will not be advertised on the platform. For more information contact us on+263 78 698 9144.
                </p>
                <div class="image_container">
                    <br>
                    <h2>
                        Proof Of Identity
                    </h2>
                    <br>
                    <div>
                        <img title="Choose an Image" src="../images/addimage.png" id="image2" onclick="AgentVerificationClick()">
                        <input type="file" id="AgentVerificationImage" name="identityImage" accept="image/jpeg, image/png, image/heif, image/heif-sequence">
                        <br>
                    </div>
                </div>
                <p class="verification_text">
                    Upload a picture of your ID number. NB: Your ID number on the image should match the ID number you have uploaded when signing up.
                </p>
                <div class="button_holder">
                    <button type="button" id="validate_form" onclick="validatie_form()">
                        Upload
                    </button>
                    <button type="submit" id="verification_submit" name="verification_submit">

                    </button>
                    <br>
                    <?php
                    if ($days_difference < 30) {
                    ?>
                        <button type="button" id="cancel" onclick="closeVerificationPopUp()">
                            Later
                        </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    <?php
    }
    ?>


    <br>
    <div class="label">
        <h1>
            My Listings...
        </h1>
    </div>
    <div class="container">
        <?php

        while ($home_row = mysqli_fetch_array($home_result)) {

            $uni = $home_row['uni'];

            if ($uni === "University of Zimbabwe") {
                $folder = "uzpictures";
            } elseif ($uni === "Midlands State University") {
                $folder = "msupictures";
            } elseif ($uni === "Africa Univeristy") {
                $folder = "aupictures";
            } elseif ($uni === "Bindura State University") {
                $folder = "bsupictures";
            } elseif ($uni === "Chinhoyi University of Science and Technology") {
                $folder = "cutpictures";
            } elseif ($uni === "Great Zimbabwe University") {
                $folder = "gzpictures";
            } elseif ($uni === "Harare Institute of Technology") {
                $folder = "hitpictures";
            } elseif ($uni === "National University of Science and Technology") {
                $folder = "nustpictures";
            }
            echo '<a href="house.php?home_id=' . $home_row['home_id'] . '&folder=' . $folder . '" target="" class="listings">
            <img src="../housepictures/' . $folder . '/' . $home_row['image1'] . '" id =' . $home_row['home_id'] . 'alt="tap to add images" title="tap to manage" >
        </a>';
        }
        $total_records = mysqli_num_rows($home_result);
        if ($total_records < 100) {
            echo '<div class="listings" onclick="AddHouse()">
                    <img src="../images/add.png" alt="" class="add" title="tap to add listing" style="box-shadow: 0 0 0 0";>
                </div>';
        }
        ?>

    </div>
    <div class="footer">
        <h3 class="abt">
            <a href="../aboutus.php">About</a> CasaMax
        </h3>

        <br>
        <div class="socialicons">
            <a href="https://www.facebook.com/profile.php?id=100093414304668" data-tabs="timeline" target="blank"><img src="../images/facebook.png" alt="" title="Our-Facebook-page"></a>
            <a href="https://www.instagram.com/casamax.co.zw/" target="blank"><img src="../images/instagram.png" alt="" title="Our-Instagram-page"></a>
            <a href="https://wa.me/+263786989144" target="blank"> <img src="../images/whatsapp.png" alt="" title="Our-WhatsApp-page"></a>
            <a href="mailto:casamaxzim@gmail.com?subject=Feedback to CasaMax&cc=c" target="blank"> <img src="../images/mail.png" alt="" title="Email"></a>
            <a href="" target="blank"><img src="../images/twitter.png" alt="" title="Our-twitter-page"></a>
        </div>
    </div>
    </div>
    <?php

    require 'add_house.html';

    require 'agent_change_info.html';
    ?>

    <script src="./agent_script.js"></script>
    <script>
        setTimeout(() => {
            const box = document.getElementById('error');

            //removes element from DOM
            box.style.display = 'none';
        }, 5000); // time in milliseconds

        document.getElementById('image2').onclick = function AgentVerificationClick() {
            document.getElementById('AgentVerificationImage').click();
        }

        function closeVerificationPopUp() {
            document.getElementById("verification_container").style.display = 'none';
        }

        function validatie_form() {
            image = document.getElementById('AgentVerificationImage');
            if (image.value == null || image.value == "") {
                alert("Please Select An Image")
            } else {
                document.getElementById('verification_submit').click();
            }
        }

        // if (document.getElementById('verification_container').style.display = 'flex') {
        //     document.getElementsByClassName('scrollable').style.overflow = 'hidden';
        // } else {
        //     document.getElementsByClassName('scrollable').style.overflow = 'auto';
        // }
    </script>
</body>

</html>