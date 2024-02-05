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
    $page_filter_name = "../unilistings/".$page_name;

        // reseting a filter
        if(isset($_POST['filter_reset'])){
            header("Location:https://casamax.co.zw/unilistings/$page_name");
            unset($_GET['fridge']);
            unset($_GET['borehole']);
            unset($_GET['wifi']);
            unset($_GET['kitchen']);
            unset($_GET['transport']);
            unset($_GET['price']);
            unset($_GET['filter']);
            $transport_query ='';
            $kitchen_query ='';
            $wifi_query = '';
            $borehole_query = '';
            $fridge_query = '';
            $gender_query = '';
            $price_query ='';
            $price_url = "";
            $filter_url="";
        }
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
</head>
<body onunload="" class="scrollable">
<?php
    require_once '../required/pageloader.php';
?>
    <div class="head">
        <a href="../index.php">  <img src="../images/logoblack.png" alt="" class="logo"></a>
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
        
        if($ads =true){
            // google ads
            echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5154867814880124"
            crossorigin="anonymous"></script>
                <!-- display add -->
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-5154867814880124"
                    data-ad-slot="9206505907"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>';
        }
    ?>
    </div>
    
    </div>
<?php
    require_once '../required/footer.php';
?>
</body>
</html>