<?php
// Start the session at the very beginning
session_start();
$currentMonthFull = date('F');
require './homerunphp/advertisesdb.php';
// Check if the session variable is set
if (empty($_SESSION['sessionowner'])) {
    require './required/alerts.php';
    echo "Session is not set"; // Debugging: Check if this message appears
    redirect("./homeownerlogin.php?error=Please Login");
} else {
    $home_id = $_SESSION['sessionowner'];
    $sql = "SELECT * FROM  homerunhouses WHERE home_id = '$home_id' ";
    require './homerunphp/landlord_dashboard_functions.php';

    if ($rs_result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($rs_result);
        $home_id = $row['home_id'];
        $verified = $row['verified'];
        setcookie("update", $home_id, time() + (86400 * 1), "/");

        $verified = $row['verified'] == 1;

        switch ($row['uni']) {
            case "University of Zimbabwe":
                setcookie("uni_folder", "uzpictures", time() + (86400 * 1), "/");
                $location = "housepictures/uzpictures/";
                break;
            case "Midlands State University":
                setcookie("uni_folder", "msupictures", time() + (86400 * 1), "/");
                $location = "housepictures/msupictures/";
                break;
            case "Africa University":
                setcookie("uni_folder", "aupictures", time() + (86400 * 1), "/");
                $location = "housepictures/aupictures/";
                break;
            case "Bindura State University":
                setcookie("uni_folder", "bsupictures", time() + (86400 * 1), "/");
                $location = "housepictures/bsupictures/";
                break;
            case "Chinhoyi University of Science and Technology":
                setcookie("uni_folder", "cutpictures", time() + (86400 * 1), "/");
                $location = "housepictures/cutpictures/";
                break;
            case "Great Zimbabwe University":
                setcookie("uni_folder", "gzpictures", time() + (86400 * 1), "/");
                $location = "housepictures/gzpictures/";
                break;
            case "Harare Institute of Technology":
                setcookie("uni_folder", "hitpictures", time() + (86400 * 1), "/");
                $location = "housepictures/hitpictures/";
                break;
            case "National University of Science and Technology":
                setcookie("uni_folder", "nustpictures", time() + (86400 * 1), "/");
                $location = "housepictures/nustpictures/";
                break;
            default:
                redirect("./index.php?error=Failed To Get Uni In Profile");
                break;
        }
    } else {
        redirect("./homeownerlogin.php?error=Sql Error Failed To Get Data");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require './required/header.php';
    ?>
    <meta name="description" content="Login and control how your boarding house is viewed on the platform">
    <link rel="icon" href="images/logowhite.png">
    <link rel="stylesheet" href="profile.css">
    <title>My Profile</title>
    <script>
        var tourCookie = 'landlordProfileTour';
    </script>
</head>

<body onunload="" class="scrollable">

    <?php
    if ($verified == true) {
        require_once 'required/pageloader.php';
    ?>
        <header>
            <?php if ($row['available'] != 1) { ?>
                // alerts whether the house is being shown on the platfrom or not.
                <div class="alert_off">
                    <p> Your current listing is not visible on CasaMax. To make it visible click available and update <a href="#available">Right Here!</a></p>
                </div>
            <?php } ?>
            <h1>
                <a href="index.php"><img src="images/logoorange.png" alt="logo" class="logo"></a>
                <h2>Casamax.co.zw</h2>
                <div class="profile_pic">
                    <img src="./images/profile.png" alt="prof_pic">
                    <h2>
                        <?php echo ucfirst($row['firstname']); ?>
                    </h2>
                </div>
        </header>
        <?php if (empty($row['image1']) and empty($row['image2']) and empty($row['image3']) and empty($row['image4']) and empty($row['image5']) and empty($row['image6']) and empty($row['image7']) and empty($row['image8'])) {
        ?>
            <div class="add_photos">
                <p>YOUR PROFILE DOES NOT HAVE ANY PHOTOS. PLEASE ADD YOUR PHOTOS HERE!!</p>
                <form action="homerunphp/profile_photo_upload.php" enctype="multipart/form-data" method="POST" class="photo_form">
                    <div class="profile_page_photo_upload">

                        <div>

                            <img title="Choose an Image" src="./images/addimage.png" id="image1" onclick="triggerClick()">
                            <input type="file" onchange="displayImage2(this)" id="inputimage1" name="image[]" multiple>
                            <h3 style="color: rgb(8, 8, 12);">
                                Add Upto 8 Images
                            </h3>
                        </div>

                    </div>
                    <button class="photo_button" name="profile_photos">
                        Submit
                    </button>
                </form>
            </div>
        <?php } ?>
        <div class="banner-container">
            <div class="subscribe-banner">
                <div class="sub-banner-top">
                    <img src="./images/logoorange.png" class="logo" alt="warning">
                    <div class="top-banner">
                        <h3>
                            Unlock Your Home's Full Potential
                        </h3>
                        <p>
                            Right now, your home isn't visible to students. Upgrade to our premium package and shine bright—showcase your space and attract more interest!
                            <b> Don't miss out on this opportunity to connect!</b>
                        </p>

                    </div>

                </div>
                <div class="sub-banner-bottom">
                    <div>
                        <button class="cancel" onclick="closeSub()">
                            Maybe Later!
                        </button>
                    </div>
                    <div>
                        <a href="./payment.php">
                            <button class="subscribe-btn">
                                Subscribe
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" data-intro='View Your Details.' data-step='1' data-position='bottom'>
            <div class="house_details">
                <div class="title_text">
                    <h2>
                        Insigths
                    </h2>
                </div>

                <div class="insights">
                    <div class="top-row">
                        <div class="top-row-container">
                            <div class="top-container-top">
                            </div>
                            <div class="top-container-value">
                                <h2><?php echo $landlordShares ?></h2>
                            </div>
                            <div class="top-container-desc">
                                <p>Shares (How many times your home has been shared)</p>
                            </div>
                        </div>
                        <div class="top-row-container">
                            <div class="top-container-top">
                            </div>
                            <div class="top-container-value">
                                <h2><?php echo $landlordChats ?></h2>
                            </div>
                            <div class="top-container-desc">
                                <p>WhatsApp Conversations </p>
                            </div>
                        </div>
                        <div class="top-row-container">
                            <div class="top-container-top">
                            </div>
                            <div class="top-container-value">
                                <h2><?php echo $landlordViews ?></h2>
                            </div>
                            <div class="top-container-desc">
                                <p>Total Views </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title_text">
                    <h2>Your House Info</h2>
                </div>
                <div class="table">
                    <table>
                        <tr>
                            <th class="value">$ <?php echo $row['price']; ?> </th>
                            <th class="value"> <?php echo $row['people_in_a_room']; ?> </th>
                            <th class="value"> <?php echo $row['gender']; ?> </th>
                        </tr>
                        <tr>
                            <td>Amount Per Month</td>
                            <td>People In A Room</td>
                            <td>Gender</td>
                        </tr>
                    </table>
                </div>
                <div class="address">
                    <div class="address_info">
                        <h3>Address:</h3>
                        <p><?php echo $row['adrs'] ?></p>
                    </div>

                    <div class="address_info">
                        <h3>Phone:</h3>
                        <p>0<?php echo $row['contact'] ?></p>
                    </div>

                    <div class="address_info">
                        <h3>Email:</h3>
                        <p><?php echo $row['email'] ?></p>
                    </div>
                </div>
                <div class="edit">
                    <a href="./listingdetails.php?clicked_id=<?php echo $row['home_id'] ?>">
                        <div class="btn-div" data-intro='View the preview of your listing and see how students see it.' data-step='2' data-position='bottom'>
                            <button class="edit-btn" name="viewpage">
                                Page Preview
                            </button>
                        </div>
                    </a>
                </div>
                <br>
                <div class="profile-bottom" data-intro='Change the visibility of your house.' data-step='3' data-position='top'>
                    <form action="./homerunphp/update.php" method="POST">
                        <p>Update To Show If Your Home Is Available Or Not</p>
                        <div class="available_options">
                            <label for="available">
                                <input type="radio" name="availability" id="available" value="1">
                                Available
                            </label> or
                            <label for="occupied">
                                <input type="radio" name="availability" id="occupied" value="0">
                                Occupied
                            </label>
                        </div>
                        <button class="update" name="update">
                            Update
                        </button>
                </div>
            </div>
        </div>
        </div>
        </form>

        </div>

        <script>
            function triggerClick() {
                document.getElementById("inputimage1").click();
            }

            // edit info onclick
            function openForm() {
                document.getElementById("myForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("myForm").style.display = "none";
            }

            function open_Verification_popup() {
                document.getElementById("verify_popup").style.display = "block";
            }

            function close_Verification_popup() {
                document.getElementById("verify_popup").style.display = "none";
            }
        </script>
    <?php
    } else {
    ?>
        <div class="container">
            <div class="house-info" style="width:100%; margin: 0 auto;">
                <h2 style="color: black; font-size:20px; font-weight:600;">Your House ID is <?php echo $row['home_id'] ?></h2>
                <br>
                <button class="update" onclick="copyToClipboard()">
                    Copy Home ID
                </button>
                <br>
                <h2 style="margin: 5% 5%; font-size: 1.4rem; font-weight:700;">Your Home Is Currently Waiting Verification</h2>
                <br>
                <h2 style="margin: 5% 5%; font-size: 1.2rem;">Verification Takes 2 to 7 Working Days. To Speed Up The Process WhatsApp Us On +263 78 698 9144 Stating Your Email Address And House ID.</h2>
                <br>
                <h2 style="margin: 10% 0; font-size: 1.8rem; color:rgb(252, 153, 82)">Thank you</h2>

            </div>
        </div>
    <?php
    }
    ?>
    <script>
        const banner = document.querySelector('.banner-container');

        function copyToClipboard() {
            var home_id = '<?php echo $row['home_id']; ?>';

            var tempInput = document.createElement("input");
            tempInput.value = home_id;
            document.body.appendChild(tempInput);

            tempInput.select();
            tempInput.setSelectionRange(0, 99999);

            document.execCommand("copy");

            document.body.removeChild(tempInput);

            alert("Home ID Has Been Copied To Clipboard: " + home_id);
        }

        function closeSub() {
            banner.style.display = 'none';
            document.querySelector("body").classList.remove("scrollable");
        }
        if (banner.style.display != 'none') {
            document.querySelector("body").classList.add("scrollable");
        }
    </script>
</body>

</html>