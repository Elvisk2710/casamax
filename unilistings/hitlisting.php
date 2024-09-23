<?php
session_start();
require '../required/ads_query.php';
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
require_once '../homerunphp/advertisesdb.php';
$page_name = "hitlisting.php";
$folder = "hitpictures";
$university = "Harare Institute of Technology";
setcookie("uni_folder", $folder, time() + (86400 * 1), "/");
require_once '../homerunphp/select_query.php';
$page_filter_name = "../unilistings/" . $page_name;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require '../required/header.php';
    ?>
    <meta name="description" content="View Boarding Houses available for Harare Institute of Technology students to rent">
    <link rel="icon" href="../images/logowhite.png">
    <link rel="stylesheet" href="../index.css">
    <title>CasaMax HIT-ListingPage</title>
    <script>
        var tourCookie = "listingsTour";
    </script>
</head>

<body onunload="" class="scrollable">
    <?php
    require_once '../required/pageloader.php';
    ?>

    <!-- includes the navbar -->
<div class="page-container">
<div class="side-bar-container">
                <!-- includes the filters of the page -->
                <?php
                require '../required/filter.php';
                ?>
            </div>
    <div class="container">
    <?php
    require_once '../required/navbar.php';
    ?>
        <div class="list-container">
            <div class="left-col">
                <h2>Recommended For HIT</h2>
                <!-- includes the query for looping the houses -->
                 <?php
                require_once '../required/listing_query.php';
                ?>
            </div>
        </div>
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