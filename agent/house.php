<?php

session_start();
require_once '../homerunphp/advertisesdb.php';
$home_id = $_GET['home_id'];
if (empty($_SESSION['sessionagent'])) {
    redirect('./index.php?error=Please Login First');
} else {
    $sql = "SELECT * FROM  homerunhouses WHERE home_id = '$home_id' ";
    if ($rs_result = mysqli_query($conn, $sql)) {
        $home_row = mysqli_fetch_array($rs_result);
    } else {
        redirect('./index.php?error=Sql Error');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css">
    <link rel="icon" href="../images/logowhite.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <meta name="theme-color" content="#08080C" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>LIsting Info</title>
    <script>
        var tourCookie = 'agentProfileHouseTour';
    </script>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }

    html {
        scroll-behavior: smooth;
    }

    .scrollable {
        max-height: 100vh;
        overflow: hidden;
    }

    button:active {

        transform: scale(0.9);
        /* Scaling button to 0.98 to its original size */
        box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.24);
        /* Lowering the shadow */
        transition: 0.3s all;

    }

    header {
        text-align: center;
    }

    .logo {
        width: 6vw;
        height: 6vw;
        margin-top: 10px;

    }

    .home_info_popup {

        margin: 5vh 10vw;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: absolute;
        max-height: 90%;
        max-width: 80vw;
        background-color: rgb(252, 252, 252);
        border-radius: 10px;
        box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.24);

    }

    .pop_up_header {
        height: 4vh;
        min-height: 30px;
        display: flex;
        margin: 1vw auto;
        padding: 0 4vw;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 10px;
        background-color: rgb(8, 8, 12);
        width: 80%;
    }

    .home_id {
        font-size: 20px;
        padding: 0 0vw;
        margin: 0vh 0;
        left: 0;
        flex-basis: 50%;
        font-weight: 600;
        width: 100%;
        color: rgb(255, 255, 255);
        text-align: left;
    }

    .home_controls {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    button {
        background-color: white;
        font-size: 14px;
        border: none;
        border-radius: 10px;
        margin: 0 20px;
        box-shadow: 3px 10px 22px 1px rgba(0, 0, 0, 0.24);
        padding: 10px;
        color: rgb(252, 153, 82);
        font-weight: 600;

    }

    .home_container {
        justify-content: center;
        align-items: center;
        text-align: center;
        display: flex;
        margin: 1vw 4vw;
        border-radius: 10px;
        width: 70vw;

    }

    .left_col,
    .right_col {
        flex: 50%;
        text-align: left;
        font-size: 16px;
        top: 0;
        padding: 2vw;
    }

    .info {
        display: flex;
    }

    .home_label,
    .home_detail {
        margin: 0.5vh 2vw;
        font-size: 24px;
        display: flex;
        align-items: right;
        text-align: right;
        flex-basis: 50%;

    }

    .images input {
        border: none;
        display: none;
    }

    .imagepreview {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        justify-content: center;
        width: 40vw;
        height: 20vh;
        margin: 20px;
        margin-right: 0px !important;
        border: 2px rgb(252, 153, 82) dotted;
        border-radius: 10px;
    }

    .imagepreview img {
        width: 120px;
        height: 120px;
        border-radius: 10px;
        margin: 10px;
    }

    .home_label label {
        font-size: 24px;
        text-align: left;
    }

    .home_detail {
        right: 0;
        display: flex;
        align-items: right;
        text-align: right;
        justify-content: right;
    }

    .home_detail h4 {
        margin: 0;
    }

    .info #spot {
        border: none;
        border-radius: 10px;
        margin: 0.5vh 2vw;
        border: 1px solid rgb(252, 153, 82);
        padding: 2px 10px;
        width: 200px;
    }

    .available {
        margin: 0.5vh 0vw;
    }

    /* ----- carousel content stylings ----- */
    /* places the carousel content on center of the carousel */
    .carousel-content {
        position: absolute;
        /*to center the content horizontally and vertically*/
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 50;
    }

    .content {
        width: 60vh;
        height: 60vh;
        box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.24);
        border-radius: 10px;

    }

    /*----- end of carousel content stylings ----- */

    /* ----- slideshow stylings ----- */
    .slideshow {
        width: 100%;
        height: 100%;
        overflow: hidden;
        /* to hide slides in x-direction */
        position: relative;
    }

    /* wrapper which wraps all the slideshow images stylings */
    .slideshow-wrapper {
        display: flex;
        /* We give it width as 400% because we are making a 
               4 image carousel. If you want to make for example, 
               5 images carousel, then give width as 500%. */
        width: 100%;
        height: 100%;
        position: relative;
        /* you can change the animation settings from below */
        animation: slideshow 20s infinite;
    }

    /* define width and height for images*/
    .slide {
        width: 100%;
        height: 100%;
    }

    .slide img {
        width: 60vh;
        height: 60vh;
        border-radius: 10px;
    }

    .slide-img {
        width: 60vh;
        height: 60vh;
        object-fit: cover;
        border-radius: 10px;
    }

    /* @keyframes are used to provide animations
           We make these settings for 4 image carousel.
           Make modification according to your needs. */
    @keyframes slideshow {
        0% {
            left: 0;
        }

        10% {
            left: 0;
        }

        15% {
            left: -100%;
        }

        25% {
            left: -100%;
        }

        30% {
            left: -200%;
        }

        40% {
            left: -200%;
        }

        45% {
            left: -300%;
        }

        55% {
            left: -300%;
        }

        60% {
            left: -200%;
        }

        70% {
            left: -200%;
        }

        75% {
            left: -100%;
        }

        85% {
            left: -100%;
        }

        90% {
            left: 0%;
        }
    }

    /* ----- end of slideshow stylings ----- */

    /* ----- carousel control buttons stylings ----- */
    .slide-btn {
        background-color: #bbb;
        border-radius: 50%;
        border: .2rem solid #d38800;
        width: 1.2rem;
        height: 1.2rem;
        outline: none;
        cursor: pointer;
        /* stylings for positioning the buttons at
               the bottom of the carousel */
        position: absolute;
        bottom: 3%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 70;
    }

    /* As we provide position as absolute, 
        the buttons places one over the other. 
        So, we have to place them individually
        at their correct positions. */
    .slide-btn-1 {
        left: 45%;
    }

    .slide-btn-2 {
        left: 50%;
    }

    .slide-btn-3 {
        left: 55%;
    }

    .slide-btn-4 {
        left: 60%;
    }

    /* When we focus on the particular button, 
        the animation stops to that particular image 
        to which the button is associated. */
    .slide-btn-1:focus~.slideshow-wrapper {
        animation: none;
        left: 0;
    }

    .slide-btn-2:focus~.slideshow-wrapper {
        animation: none;
        left: -100%;
    }

    .slide-btn-3:focus~.slideshow-wrapper {
        animation: none;
        left: -200%;
    }

    .slide-btn-4:focus~.slideshow-wrapper {
        animation: none;
        left: -300%;
    }

    /* when we focus on the button, the background color changes */
    .slide-btn:focus {
        background-color: rgb(8, 8, 12);
    }

    /* ----- end of carousel control buttons stylings ----- */
    @media only screen and (max-width:700px) {
        .logo {
            width: 120px;
            height: 120px;
            margin-top: 100px;
        }

        .edit_house_info {
            transform: translate(-50%, 100%);
            width: 40vw;
            align-items: center;
            text-align: center;
        }

        .edit_house_info button {
            color: rgb(8, 8, 12);
        }

        .pop_up_header {
            width: 75vw;
            height: 8vh;
            min-height: 8vh;
            justify-content: normal;
        }

        .home_info_popup {
            width: 95vw;
            margin: 5vh 2.5vw;
            max-width: 100vw;
            max-height: fit-content;
            height: fit-content;
        }

        .home_container {
            flex-direction: column;
            width: 95vw !important;
            margin: 10vh 0vw !important;
            height: 100vh;
        }

        .content {
            width: 40vh;
            height: 40vh;
        }

        .slide img {
            width: 40vh;
            height: 40vh;
        }

        .images input {
            border: none;
            display: none;
            font-family: "Arvo", sans-serif, serif;
        }

        .imagepreview {
            margin: 10px 0px;
            width: 100%;
            display: flex !important;
        }

        .imagepreview img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin: 10px;
        }
    }
</style>

<body onunload="" class="scrollable">
    <?php
    require_once '../required/pageloader.php';
    $action = './add_house_script.php?home_id=' . $home_id;

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
    ?>
    <header>
        <a href="../index.php">
            <img src="../images/logoblack.png" alt="logo" class="logo">
        </a>
    </header>


    <div class="home_info_popup" id="home_info_popup">
        <header class="pop_up_header">

            <div class="home_id">
                <?php echo 'Home_ID - ' . $home_row['home_id'] ?>
            </div>
            <div class="home_controls">
                <div class="edit_house_info">
                    <button onclick="open_edit()">
                        Edit Home Info
                    </button>
                </div>

            </div>
        </header>
        <div class="home_container">
            <div class="right_col">
                <?php
                if (empty($home_row['image1']) && empty($home_row['image2']) && empty($home_row['image3']) && empty($home_row['image4']) && empty($home_row['image5']) && empty($home_row['image6']) && empty($home_row['image7']) && empty($home_row['image8'])) {
                ?>
                    <!-- Display the form for uploading images -->
                    <form action="./agent_update_images.php?home_id=<?php echo $home_id; ?>&uni=<?php echo $home_row['uni']; ?>" method="post" enctype="multipart/form-data">
                        <h2>Add House Images</h2>
                        <div class="images">
                            <p>(best represented in landscape view)</p>
                            <div class="imagepreview">
                                <div>
                                    <img title="Choose an Image" src="../images/addimage.png" id="updateImages" onclick="triggerClick()">
                                    <input type="file" id="updateImagesListInput" name="image_update[]" multiple>
                                    <br>
                                    <h3 style="color: rgb(8, 8, 12);">Add Up to 8 Images</h3>
                                </div>
                            </div>
                            <div>
                                <div class="delete">
                                    <button name="update_images" type="submit" style="background-color: white;">Update Images</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php
                } else {
                ?>
                    <!-- Display the slideshow of images -->
                    <div class="content">
                        <div class="slideshow">
                            <div class="slideshow-wrapper">
                                <div class="slide">
                                    <?php echo '<img src="../housepictures/' . $folder . '/' . $home_row['image1'] . '" id =' . $home_row['home_id'] . 'alt="" title="">'; ?>
                                </div>
                                <div class="slide">
                                    <?php echo '<img src="../housepictures/' . $folder . '/' . $home_row['image1'] . '" id =' . $home_row['home_id'] . 'alt="" title="">'; ?>
                                </div>
                                <div class="slide">
                                    <?php echo '<img src="../housepictures/' . $folder . '/' . $home_row['image2'] . '" id =' . $home_row['home_id'] . 'alt="" title="">'; ?>
                                </div>
                                <div class="slide">
                                    <?php echo '<img src="../housepictures/' . $folder . '/' . $home_row['image3'] . '" id =' . $home_row['home_id'] . 'alt="" title="">'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="left_col" data-intro='View your listing details.' data-step='1' data-position='top'>
                <div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                Firstname
                            </label>
                        </div>

                        <div class="home_detail">
                            <h4>
                                <?php echo $home_row['firstname'] ?>
                            </h4>
                        </div>

                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                Lastname
                            </label>
                        </div>

                        <div class="home_detail">
                            <h4>
                                <?php echo $home_row['lastname'] ?>
                            </h4>
                        </div>

                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                Price
                            </label>
                        </div>
                        <div class="home_detail">
                            <h4>
                                <?php echo '$' . $home_row['price'] ?>
                            </h4>
                        </div>

                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                Uni
                            </label>
                        </div>

                        <div class="home_detail">
                            <h4>
                                <?php echo $home_row['uni'] ?>
                            </h4>
                        </div>

                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                free spots available
                            </label>
                        </div>

                        <div class="home_detail">
                            <h4>
                                <?php echo $home_row['spots_available'] ?>
                            </h4>
                        </div>

                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                Gender
                            </label>
                        </div>

                        <div class="home_detail">
                            <h4>
                                <?php echo $home_row['gender'] ?>
                            </h4>
                        </div>

                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                Location
                            </label>
                        </div>

                        <div class="home_detail">
                            <h4>
                                <?php echo $home_row['home_location'] ?>
                            </h4>
                        </div>

                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                Available
                            </label>
                        </div>

                        <div class="home_detail">
                            <h4>
                                <?php if (!$home_row['available'] == 1) {
                                    echo 'No';
                                } else {
                                    echo 'Yes';
                                }
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <div class="home_label">
                        <label for="info">
                            People in a room
                        </label>
                    </div>

                    <div class="home_detail">
                        <h4>
                            <?php echo $home_row['people_in_a_room'] ?>
                        </h4>
                    </div>

                </div>
                <form action=<?php echo $action ?> method="post">
                    <div class="info">
                        <div class="home_label">
                            <label for="info">
                                available
                            </label>
                        </div>

                        <div class="available" data-intro='Change if your listing is full or available.' data-step='4' data-position='top'>
                            <label for="yes" default style="margin: 0;">YES</label>
                            <input type="radio" name="available" value="1" id="yes" required>
                            <label for="no" style="margin: 0;">NO</label>
                            <input type="radio" name="available" value="0" id="no" required>
                        </div>
                    </div>
                    <div class="info">
                        <div class="home_label">
                            <label for="spot">
                                Spots left
                            </label>
                        </div>

                        <input name="spot" type="number" id="spot" placeholder="# of spots available" required>
                    </div>
                    <div class="delete">
                        <button data-intro='Update your listing details.' data-step='2' data-position='top' name="Update" style="background-color: white;">
                            Update listing
                        </button>
                    </div>


                </form>
                <div>
                    <button data-intro='Delete listing.' data-step='3' data-position='top' name="delete" style="background-color: rgba(255, 0, 0, 0.664); color: rgb(8,8,12); margin-top: 10px;" onclick="deletefn()">
                        Delete listing
                    </button>
                </div>
                <div style="display: none;" id="delete_form">


                    <form action=<?php echo $action ?> method="post">
                        <p>
                            are you sure you want to delete?
                        </p>
                        <div class="delete">
                            <button name="delete" style="background-color: rgba(255, 0, 0, 0.664); color: rgb(8,8,12); margin-top: 10px;">
                                Yes, I'm Sure!!
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
    <?php
    require 'edit_info.php';
    ?>
    <script src="./agent_script.js"></script>
    <script>
        document.getElementById('updateImages').onclick = function triggerClick() {
            document.getElementById('updateImagesListInput').click();
        }
    </script>

</body>

</html>