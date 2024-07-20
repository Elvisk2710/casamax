<?php
session_start();
require './required/ads_query.php';
require './homerunphp/advertisesdb.php';
if (empty($_SESSION['sessionowner'])) {
    require './required/alerts.php';
    redirect("./homeownerlogin.php?error=Please Login");
    echo 'entered';
} else {
    $user = $_SESSION['sessionowner'];
    $sql = "SELECT * FROM  homerunhouses WHERE home_id = '$user' ";
    if ($rs_result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($rs_result);
        $home_id = $row['home_id'];
        setcookie("update", $home_id, time() + (86400 * 1), "/");

        if ($row['verified'] == 1) {
            $verified = true;
        } else {
            $verified = false;
        }

        if ($row['uni'] == "University of Zimbabwe") {

            setcookie("uni_folder", "uzpictures", time() + (86400 * 1), "/");
            $location = "housepictures/uzpictures/";
        } elseif ($row['uni'] == "Midlands State University") {
            setcookie("uni_folder", "msupictures", time() + (86400 * 1), "/");

            $location = "housepictures/msupictures/";
        } elseif ($row['uni'] == "Africa Univeristy") {
            setcookie("uni_folder", "aupictures", time() + (86400 * 1), "/");

            $location = "housepictures/aupictures/";
        } elseif ($row['uni'] == "Bindura State University") {
            setcookie("uni_folder", "bsupictures", time() + (86400 * 1), "/");

            $location = "housepictures/bsupictures/";
        } elseif ($row['uni'] == "Chinhoyi University of Science and Technology") {
            setcookie("uni_folder", "cutpictures", time() + (86400 * 1), "/");

            $location = "housepictures/cutpictures/";
        } elseif ($row['uni'] == "Great Zimbabwe University") {
            setcookie("uni_folder", "gzpictures", time() + (86400 * 1), "/");

            $location = "housepictures/gzpictures/";
        } elseif ($row['uni'] == "Harare Institute of Technology") {
            setcookie("uni_folder", "hitpictures", time() + (86400 * 1), "/");

            $location = "housepictures/hitpictures/";
        } elseif ($row['uni'] == "National University of Science and Technology") {
            setcookie("uni_folder", "nustpictures", time() + (86400 * 1), "/");
            $location = "housepictures/hitpictures/";
        } else {
            redirect("./index.php?error=Failed To Get Uni In Profile");
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
</head>

<body onunload="" class="scrollable">

    <?php
    if ($verified == true) {
        require_once 'required/pageloader.php';

    ?>
        <header>

            <a href="index.php"><img src="images/logowhite.png" alt="logo" class="logo"></a>
            <?php if ($row['available'] != 1) { ?>
                // alerts whether the house is being shown on the platfrom or not.
                <div class="alert_off">

                    <p> Your current listing is not visible on CasaMax. To make it visible click available and update <a href="#available">Right Here!</a></p>

                </div>
            <?php } ?>
            <h1>
                <?php echo "Hey " . ucfirst($row['firstname']) . "!"; ?>
            </h1>
        </header>

        <?php if (!empty($row['image1'])) { ?>
            <div class="profile-photo">

                <img src=" <?php echo $location . $row["image1"]; ?>" alt="">

            </div>
        <?php } ?>
        <?php if (empty($row['image1']) and empty($row['image2']) and empty($row['image3']) and empty($row['image4']) and empty($row['image5']) and empty($row['image6']) and empty($row['image7']) and empty($row['image8'])) {
        ?>
            <div class="add_photos">
                <p>YOUR PROFILE DOES NOT HAVE ANY PHOTOS. PLEASE ADD YOUR PHOTOS HERE!!</p>
                <form action="homerunphp/profile_photo_upload.php" enctype="multipart/form-data" method="POST" class="photo_form">
                    <div class="profile_page_photo_upload">

                        <div>

                            <img title="Choose an Image" src="./images/addimage.png" id="image1" onclick="triggerClick()">
                            <input type="file" onchange="displayImage2(this)" id="inputimage1" name="image[]" multiple>
                            <br>
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

        <div class="container">
            <div class="house-info">
                <h2>YOUR HOUSE INFO</h2>
            </div>
            <div class="table">
                <table>
                    <tr>
                        <th class="value">$ <?php echo $row['price']; ?> </th>
                        <th class="value"> <?php echo $row['people_in_a_room']; ?> </th>
                        <th class="value"> <?php echo $row['gender']; ?> </th>
                    </tr>
                    <tr>
                        <th>AMOUNT PER MONTH</th>
                        <th>PEOPLE IN A ROOM</th>
                        <th>GIRLS, BOYS OR BOTH</th>
                    </tr>
                </table>
            </div>

            <div class="address">
                <div class="address_info">
                    <h3>ADDRESS</h3>
                    <p><?php echo $row['adrs'] ?></p>
                </div>

                <div class="address_info">
                    <h3>PHONE</h3>
                    <p>0<?php echo $row['contact'] ?></p>
                </div>

                <div class="address_info">
                    <h3>EMAIL</h3>
                    <p><?php echo $row['email'] ?></p>
                </div>

            </div>

            <div class="edit">
                <a href="./listingdetails.php?clicked_id=<?php echo $row['home_id'] ?>">
                    <div class="btn-div">
                        <button class="edit-btn" name="viewpage">
                            Page Preview
                        </button>
                    </div>

                </a>
            </div>

            <div class="profile-bottom">

                <form action="./homerunphp/update.php" method="POST">
                    <p>Is your Home...</p>

                    <label for="available">
                        <input type="radio" name="availability" id="available" value="1">
                        Available
                    </label> or
                    <label for="occupied">
                        <input type="radio" name="availability" id="occupied" value="0">
                        Occupied
                    </label>

                    <br>

                    <button class="update" name="update">
                        Update
                    </button>

                    <p class="desc">
                        this will allow your home to either be removed temporarily (Occupied) or be placed back onto the platform (Available)
                    </p>
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
        <script>
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
        </script>
    <?php
    }
    ?>

</body>

</html>