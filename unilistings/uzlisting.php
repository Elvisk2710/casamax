<?php
session_start();
require '../required/ads_query.php';
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");
require_once '../homerunphp/advertisesdb.php';
$page_name = "uzlisting.php";
$folder = "uzpictures";
$university = "University of Zimbabwe";
require_once '../homerunphp/select_query.php';
setcookie("uni_folder", $folder, time() + (86400 * 1), "/");
$page_filter_name = "../unilistings/" . $page_name;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require '../required/header.php';
    ?>
    <meta name="description" content="View Boarding Houses available for University of Zimbabwe students to rent">
    <link rel="icon" href="../images/logowhite.png">
    <link rel="stylesheet" href="../index.css">
    <title>CasaMax UZ ListingPage</title>
    <script>
        var tourCookie = "listingsTour";
    </script>
</head>

<body onunload="" class="scrollable">
    <?php
    require_once '../required/pageloader.php';
    ?>
    <div class="head">
        <a href="../index.php"> <img src="../images/logoblack.png" alt="" class="logo"></a>
    </div>

    <!-- includes the navbar -->
    <?php
    require_once '../required/navbar.php';
    ?>


    <div class="container">

        <div class="list-container">

            <div class="left-col">
                <h2>Recommended For UZ</h2>
                <!-- includes the query for looping the houses -->

                <?php
                // google ads
                require_once '../required/listing_query.php';
                ?>

            </div>


            <!-- includes the filters of the page -->
            <?php
            require_once '../required/filter.php';
            ?>
        </div>

        <div class="rightcol">
            <?php
            require_once '../required/listing-pagination.php';
            ?>
        </div>

    </div>
    <?php
    require_once '../required/footer.php';
    ?>
</body>

</html>