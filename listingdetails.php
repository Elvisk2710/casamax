<?php
session_start();

require_once 'homerunphp/advertisesdb.php';
$checkmark = './images/checkmark.png';
$crossmark = './images/crossmark.png';
require './required/common_functions.php';

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

        switch ($row['uni']) {
            case 'Africa Univeristy':
                $uni_folder = 'aupictures';
                break;
            case 'Bindura State University':
                $uni_folder = 'bsupictures';
                break;
            case 'Chinhoyi University of Science and Technology':
                $uni_folder = 'cutpictures';
                break;
            case 'Great Zimbabwe University':
                $uni_folder = 'gzpictures';
                break;
            case 'Harare Institute of Technology':
                $uni_folder = 'hitpictures';
                break;
            case 'Midlands State University':
                $uni_folder = 'msupictures';
                break;
            case 'National University of Science and Technology':
                $uni_folder = 'nustpictures';
                break;
            case 'University of Zimbabwe':
                $uni_folder = 'uzpictures';
                break;
        }
    } else {
        header('Location: ./index.php?error=' . urlencode("Clicked Id Is Not Valid"));
        exit;
    }
} else {
    header('Location: ./index.php?error=' . urlencode("Clicked Id Is Not Set"));
    exit;
}

$currentURL = getCurrentUrl();
setcookie('subscriptionRedirect', $currentURL, time() + 3600, '/');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require './required/header.php'; ?>
    <meta name="description" content="Know more about the boarding houses we offer here at casamax.co.zw for students. View pictures and get contact details of the boarding house you like on casamax.co.zw">
    <link rel="icon" href="images/logowhite.png">
    <title>CasaMax House-Details</title>
    <link rel="stylesheet" href="listing.css">
    <script>
        var tourCookie = 'listinDetailsTour';
    </script>
</head>

<body class="scrollable">
    <?php
    require 'required/pageloader.php';
    require './required/root-nav.php';
    $ownerName = $agent ? $row_agent['firstname'] : $row['firstname'];
    ?>

    <div class="container">
        <div class="house-title">
            <div class="house-title-name">
                <h1><?= $ownerName ?>'s Home</h1>
                <div class="address">
                    <a href="http://maps.google.com/?q=<?= $row['home_location'] ?> Zimbabwe" target="blank">
                        <img src="./images/location.png" alt="location" title="Click to go to Google Maps">
                        <p><?= $agent ? $row['home_location'] : $row['adrs'] ?></p>
                    </a>
                </div>
            </div>

            <div class="house-title-contact">
                <?php if ($agent) : ?>
                    <form data-intro="Get in touch with Agent." data-step="1" data-position="bottom" action="./homerunphp/verify_student_redirect.php?home_id=<?= $user ?>&agent_id=<?= $agent_id ?>&route=agent" method="post" class="button_form">
                        <button class="contact-host" id="whatsapp" name="check_sub_whatsapp_agent" type="submit">
                            <img src="images/whatsAppGreen.png" alt="whatsApp" title="Contact on WhatsApp">
                        </button>
                        <button class="contact-host" id="call" name="check_sub_call_agent" type="submit">
                            <img src="images/call.png" alt="call" title="Call">
                        </button>
                        <a href="./agent_profile.php?agent_id=<?= $agent_id ?>">
                            <button class="contact-host" id="about_agent" type="button">
                                <img src="images/information.png" alt="Lister's information" title="Lister's Information">
                            </button>
                        </a>
                    </form>

                <?php else : ?>
                    <?php if (!isset($_SESSION['sessionowner'])) : ?>
                        <form data-intro="Get in touch with Landlord." data-step="1" data-position="bottom" action="./homerunphp/verify_student_redirect.php?home_id=<?= $user ?>&route=landlord&student=1" method="post">
                            <button class="chatBtn" id="chatBtn" name="check_sub_chat_landlord" type="submit">
                                <img src="images/whatsAppGreen.png" alt="whatsApp" title="Contact on WhatsApp">
                            </button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="house-gender-price">
            <div class="house-gender">
                <?php if ($row['gender'] == 'BOYs') { ?>
                    <img src="./images/boy.png" alt="Boys Boarding House" title="Boys Boarding House">
                    <h3>Boys</h3>
                <?php } elseif ($row['gender'] == 'GIRLs') { ?>
                    <img src="./images/girl.png" alt="Girls Boarding House" title="Girls Boarding House">
                    <h3>Girls</h3>
                <?php } else { ?>
                    <img src="./images/mixed.png" alt="Girls Boarding House" title="Girls Boarding House">
                    <h3>Mixed</h3>
                <?php } ?>
            </div>
            <?php
            if ($agent == true) {
            ?>
                <div class="house-price">
                    <img src="./images/agent.png" alt="Boys Boarding house" title="boys boarding house">
                    <h3>
                        Agent Fee - $<?php echo $row_agent['agent_fee'] ?>
                    </h3>
                </div>
            <?php
            }
            ?>
            <div class="house-price">
                <img src="./images/price.png" alt="Boys Boarding house" title="boys boarding house">
                <h3>
                    <?php echo $row['price'] ?> /month
                </h3>
            </div>
        </div>
        <?php if (empty($row['image1']) && empty($row['image2']) && empty($row['image3']) && empty($row['image4']) && empty($row['image5']) && empty($row['image6']) && empty($row['image7']) && empty($row['image8'])) : ?>
            <h3 class="no_photos"> No Photos Are Available For This Property </h3>
            <script>
                document.getElementById('more-pictures').style.display = 'none';
            </script>
        <?php else : ?>
            <div class="gallery" data-intro="View house images." data-step="3" data-position="bottom">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <?php if (!empty($row["image$i"])) : ?>
                        <div class="gallery-img-<?= $i ?>" onclick="open_gallery()">
                            <img src="housepictures/<?= $uni_folder ?>/<?= $row["image$i"] ?>" onclick="open_gallery()">
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <?php if (!empty($row["image1"]) && !empty($row["image2"]) && !empty($row["image3"]) && !empty($row["image4"]) && !empty($row["image5"])) : ?>
                <a href="#gallery_container">
                    <button class="more-pictures" id="more-pictures" onclick="open_gallery()">
                        View More Pictures
                    </button>
                </a>
            <?php endif; ?>
        <?php endif; ?>

        <h2>Amenities:</h2>
        <div class="amenities-list">
            <?php
            $amenities = ['kitchen', 'fridge', 'wifi', 'borehole', 'transport'];
            foreach ($amenities as $amenity) {
                if ($row[$amenity] == "1") {
                    switch ($amenity) {
                        case 'kitchen':
                            $icon = './images/kitchenIcon.png';
                            break;
                        case 'fridge':
                            $icon = './images/fridgeIcon.png';
                            break;
                        case 'wifi':
                            $icon = './images/wifiIcon.png';
                            break;
                        case 'borehole':
                            $icon = './images/boreholeIcon.png';
                            break;
                        case 'transport':
                            $icon = './images/transportIcon.png';
                            break;
                    }
                    echo "<div class='amenities'>
                    <div class='amenities-img'><img src='$icon' alt=''></div>
                    <h4>" . ucfirst($amenity) . "</h4>
                </div>";
                }
            }
            ?>
        </div>

        <h2>Additional Info:</h2>
        <p class="additional-p"><?= ucfirst($row['rules']) ?></p>
        <?php if ($row['people_in_a_room'] != 0) { ?>
            <h2>Room Info:</h2>
            <div class="room-info">
                <div class='house-price' style="gap: 2rem;">
                    <div class='amenities-img'><img src='./images/people.png' alt=''></div>
                    <h4><?php echo ucfirst($row['people_in_a_room']) . " People In A Room" ?></h4>
                </div>
            </div>
        <?php } ?>
        <?php require './gallery.php'; ?>
    </div>

<?php
    require './required/root-footer.php'
?>

    <script>
        let startTourCookie = getCookie('listinDetailsTour');
        if (!startTourCookie) {
            introJs().start();
            setCookie('listinDetailsTour', 'completed', 365);
        }
    </script>
</body>

</html>