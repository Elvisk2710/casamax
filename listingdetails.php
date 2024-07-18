<?php
session_start();;

require_once 'homerunphp/advertisesdb.php';

if (!empty($_GET['clicked_id']) && isset($_GET['clicked_id'])) {
    $user  = $_GET['clicked_id'];

    $sql = "SELECT * FROM  homerunhouses WHERE home_id = '$user'";
    if ($rs_result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_array($rs_result);
        if (!empty($row['agent_id'])) {
            $agent_id = $row['agent_id'];
            $sql_agent = "SELECT * FROM agents WHERE agent_id = '$agent_id'";
            if ($agent_result = mysqli_query($conn, $sql_agent)) {
                $agent = true;
                $row_agent = mysqli_fetch_array($agent_result);
            }
        } else {
            $agent = false;
        }
        if ($row['uni'] == 'Africa Univeristy') {
            $uni_folder = 'aupictures';
        } elseif ($row['uni'] == 'Bindura State University') {
            $uni_folder = 'bsupictures';
        } elseif ($row['uni'] == 'Chinhoyi University of Science and Technology') {
            $uni_folder = 'cutpictures';
        } elseif ($row['uni'] == 'gzpictures') {
            $uni_folder = 'Great Zimbabwe University';
        } elseif ($row['uni'] == 'Harare Institute of Technology') {
            $uni_folder = 'hitpictures';
        } elseif ($row['uni'] == 'Midlands State University') {
            $uni_folder = 'msupictures';
        } elseif ($row['uni'] == 'National University of Science and Technology') {
            $uni_folder = 'nustpictures';
        } elseif ($row['uni'] == 'University of Zimbabwe') {
            $uni_folder = 'uzpictures';
        }
    }
} else {
    header('Location: ./index.php?error=' . urlencode("Clicked Id Not Set"));
}

$currentURL = "http";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $currentURL .= "s";
}
$currentURL .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

setcookie('subscriptionRedirect', $currentURL, time() + 3600, '/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require './required/header.php';

    ?>
    <meta name="description" content="Know more about the boarding houses we offer here at casamax.co.zw for students. View pictures and get contact details of the boarding house you like on casamax.co.zw">
    <link rel="icon" href="images/logowhite.png">
    <title>CasaMax House-Details</title>
    <link rel="stylesheet" href="listing.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body onunload="" class="scrollable">
    <?php
    require 'required/pageloader.php';
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        echo "<script>alert($error)</script>";
    }
    ?>


    <header class="head">
        <a href="index.php"> <img src="./images/logoblack.png" alt="logo" class="logo"></a>
    </header>
    <?php
    if ($agent == true) {
        $ownerName = $row_agent['firstname'];
    } else {
        $ownerName = $row['firstname'];
    }
    ?>
    <div class='container'>
        <div class='house-title'>
            <h1>
                <?php echo $ownerName ?>'s Home
            </h1>
            <?php
            if ($agent == true) {
                // agent contact
                $agent_contact = $row_agent['contact'];
            ?>
                <form action="./homerunphp/verify_student_redirect.php?home_id=<?php echo $user ?>&agent_id=<?php echo $agent_id ?>&route=agent" method="post" class="button_form">
                    <button class='contact-host' id='whatsapp' name="check_sub_whatsapp_agent" type="submit"><img src='images/whatsapp.png' alt=''>
                        WhatsApp Agent!
                    </button>

                    <button class='contact-host' id='call' name="check_sub_call_agent" type="submit"><img src='images/dialer.png' alt=''>
                        Call Agent!
                    </button>
                </form>


        </div>

        <h2> Address:<?php echo $row['home_location'] ?></h2>
        <hr>
        <?php
            } else {
                if (!isset($_SESSION['sessionowner'])) {
        ?>
            <!-- landlord contact -->
            <form action="./homerunphp/verify_student_redirect.php?home_id=<?php echo $user ?>&route=landlord&student=1" method="post">
                <button class='chatBtn' id='chatBtn' name="check_sub_chat_landlord" type="submit">
                    Chat With Me
                </button>
            </form>

    </div>

    <h2> Address: "<?php echo $row['adrs'] ?> "</h2>

    <hr>
<?php
                }
            }
?>
<div class='map'>
    <a href="http://maps.google.com/?q=<?php echo $row['home_location'] . " Zimbabwe" ?>" style='text-decoration: none; animation: text 2s ease infinite; color: rgb(252,153,82);' target='blank'>View in Maps!</a>
</div>

<?php


echo "
    <div class='table'>
    <table>
            <tr>
                    <th class='value'>" . $row['price'] . "</th>
                    <th class='value'>" . $row['people_in_a_room'] . "</th>
                    <th class='value'>" . $row['gender'] . "</th>
                    ";
if ($agent == true) {
    echo "<th class='value'> $" . $row_agent['agent_fee'] . "</th>";
}
echo "
                </tr>
                <tr>
                    <th>AMOUNT PER MONTH</th>
                    <th>PEOPLE IN A ROOM</th>
                    <th>GIRLS, BOYS OR BOTH</th>
                    ";
if ($agent == true) {
    echo "<th>AGENT-FEE</th>";
}
echo "
                </tr>
            </table>
        </div>
        <hr>    
        <br>";

if (empty($row['image1']) and empty($row['image2']) and empty($row['image3']) and empty($row['image4']) and empty($row['image4']) and empty($row['image6']) and empty($row['image7']) and empty($row['image8'])) {

    echo "<h3 class='no_photos'> No Photos Are Available For This Property </h3>
    <script>
        document.getElementById('more-pictures').style.display = 'none';
    </script>";
} else {


    echo '
    <div class="gallery">';
    if (!empty($row["image1"])) {
        echo '
           
            <div class="gallery-img-1" onclick = "open_gallery()">
            <a href="#gallery_container" onclick="open_gallery()">
            <img onclick="open_gallery()" src="housepictures/' . $uni_folder  . '/' . $row["image1"] . '">
            </a>
            </div>';
    }
    if (!empty($row["image2"])) {
        echo '
                <div onclick = "open_gallery()">
                <a href="#gallery_container" onclick="open_gallery()">
                    <img onclick="open_gallery()" src="housepictures/' . $uni_folder  . '/' . $row["image2"] . '">
                   </a> 
                </div>
            </a>';
    }
    if (!empty($row["image3"])) {
        echo '
            <div onclick = "open_gallery()">
            <a href="#gallery_container" onclick="open_gallery()">
            <img onclick="open_gallery()" src="housepictures/' . $uni_folder  . '/' . $row["image3"] . '">
           </a> 
            </div> 
            </a>';
    }
    if (!empty($row["image4"])) {
        echo '
            <div onclick = "open_gallery()">
            <a href="#gallery_container" onclick="open_gallery()">
            <img onclick="open_gallery()" src="housepictures/' . $uni_folder  . '/' . $row["image4"] . '">
           </a> 
            </div>';
    }
    if (!empty($row["image5"])) {
        echo '
                    <div onclick = "open_gallery()">
                    <a href="#gallery_container" onclick="open_gallery()">
                        <img onclick="open_gallery()" src="housepictures/' . $uni_folder . '/' . $row["image5"] . '">
                       </a> 
                    </div>';
    }
    echo '  </div>';
}

if ($row['kitchen'] == "1") {
    $kitchenimg = 'kitchen';
} else {
    $kitchenimg = '';
}
if ($row['fridge'] == "1") {
    $fridgeimg = 'fridge';
} else {
    $fridgeimg = '';
}
if ($row['wifi'] == "1") {
    $wifiimg = 'wifi';
} else {
    $wifiimg = '';
}
if ($row['borehole'] == "1") {
    $boreholeimg = 'borehole';
} else {
    $boreholeimg = '';
}
if ($row['transport'] == "1") {
    $transport = 'transport';
} else {
    $transport = '';
}
if (!empty($row["image1"]) and !empty($row["image2"]) and !empty($row["image3"]) and !empty($row["image4"]) and !empty($row["image5"]) and !empty($row["image6"]) and !empty($row["image7"]) and !empty($row["image8"])) {
    echo "
        <a href='#gallery_container'>
            <button class='more-pictures' id='more-pictures' onclick = 'open_gallery()'>
                view more pictures
            </button>
        </a>";
}

if ($row['kitchen'] == "1") {
    $kitchen_link = "%0Akitchen";
    $kitchenimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                    </svg>';
} else {
    $kitchen_link = "";
    $kitchenimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>';
}
if ($row['fridge'] == "1") {
    $fridge_link = "%0Afridge";
    $fridgeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                </svg>';
} else {
    $fridge_link = "";
    $fridgeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>';
}
if ($row['wifi'] == "1") {
    $wifi_link = "%0Awifi";
    $wifiimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>';
} else {
    $wifi_link = "";
    $wifiimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>';
}
if ($row['borehole'] == "1") {
    $borehole_link = "%0Aborehole";
    $boreholeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                </svg>';
} else {
    $borehole_link = "";
    $boreholeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>';
}
if ($row['transport'] == "1") {
    $transport_link = "%0Atransport";
    $transport = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                </svg>';
} else {
    $transport_link = "";
    $transport = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>';
}
?>

<h2>
    Amenities:
</h2>
<div class='amenities-list'>
    <div class="amenities">
        <h4>Kitchen</h4>
        <div><?php echo $kitchenimg ?></div>
    </div>

    <div class="amenities">
        <h4>Fridge</h4>
        <div><?php echo $fridgeimg ?></div>
    </div>

    <div class="amenities">
        <h4>Wifi</h4>
        <div><?php echo $wifiimg ?></div>
    </div>

    <div class="amenities">
        <h4>Borehole</h4>
        <div><?php echo $boreholeimg ?></div>
    </div>

    <div class="amenities">
        <h4>Transport</h4>
        <div><?php echo $transport ?></div>
    </div>
</div>
<h2>
    Additional Info:
</h2>
<p>
    <?php $row['rules'] ?>
</p>
<br class="ft">
<?php
require './gallery.php';
?>

</div>
</div>

<div class="footer">
    <h3 class="abt">
        <a href="aboutus.php">About</a> CasaMax
    </h3>
    <p>
        Looking for a House to Rent?
        Welcome to Casamax, where we provide all the available
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
        <a href="mailto:casamaxzim@gmail.com?subject=Feedback to Casamax&cc=c"> <img src="./images/mail.png" alt="" title="Email"></a>
        <a href=""><img src="./images/twitter.png" alt="" title="Our-twitter-page"></a>
    </div>

</div>

<script>
    function open_gallery() {
        document.getElementById("gallery_container").style.display = "flex";
        document.querySelector("body").classList.add("scrollable");
        console.log("gallery opened");

    }

    function close_gallery() {
        document.getElementById("gallery_container").style.display = "none";
        document.querySelector("body").classList.remove("scrollable");
        console.log("gallery closed");

    }

    var navBar = document.getElementById("navBar");

    function togglebtn() {

        navBar.classList.toggle("hidemenu")
    }

    var dropdown = document.getElementById("dropdown");

    function togglebtn1() {

        navBar.classList.toggle("hideuni")
    }

    var navBar = document.getElementById("navBar");

    function togglebtn() {

        navBar.classList.toggle("hidemenu")
    }
</script>

</body>

</html>