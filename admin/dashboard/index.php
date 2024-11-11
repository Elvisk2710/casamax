<?php
session_start();
if (empty($_SESSION['sessionAdmin'])) {
    require '../../required/alerts.php';
    redirect('../index.php?error=Please Login');
} else {
    $user = $_SESSION['sessionAdmin'];
    require_once '../../homerunphp/advertisesdb.php';
    $sql = "SELECT * FROM  admin_table WHERE admin_id = '$user' ";
}
if ($rs_result = mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_array($rs_result);
    $admin_id = $row['admin_id'];
}
if (empty($user)) {
    redirect(' ../index.php?error=You Have To Login First');
} else {
    $total_admin_houses_sql = "SELECT * FROM  homerunhouses WHERE admin_id = '$admin_id' ";
    if ($home_result = mysqli_query($conn, $total_admin_houses_sql)) {
        $total_admin_houses = mysqli_num_rows($home_result);
        $verified_admin_houses_sql = "SELECT * FROM  homerunhouses WHERE verified = '1' AND admin_id = '$admin_id'";
        if ($home_result = mysqli_query($conn, $verified_admin_houses_sql)) {
            $verified_admin_houses = mysqli_num_rows($home_result);
            $not_verified_admin_houses = $total_admin_houses - $verified_admin_houses;
        }
    } else {
        redirect(' ../index.php?error=Sql Error');
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dashboard.css">
    <link rel="icon" href="../../images/logowhite.png">
    <title>Admin Dashboard</title>
</head>

<body onunload="">
    <?php
    require '../components/admin_advertise_form.php';
    require '../components/add_admin_agent.php';
    require '../../required/pageloader.php';
    ?>
    <div class="container">
        <?php
        require '../components/admin_navbar.php'
        ?>
        <div class="left_col">
            <div class="button_container">
                <div class="add_listing" onclick="OpenAddListingForm()">
                    <h1>
                        Add Listing
                    </h1>
                    <h1 class="number">
                        +
                    </h1>
                </div>
                <?php
                if ($_SESSION['access'] == 1) {
                ?>
                    <div class="add_listing" onclick="OpenAddAddAgent()">
                        <h1>
                            Add Agent
                        </h1>
                        <h1 class="number">
                            +
                        </h1>
                    </div>
                <?php } ?>
            </div>
            <div class="listing_number">
                <a href="../admin_listings_dashboard/">
                    <h1>
                        Total Listings
                    </h1>
                    <h1 class="number">
                        <?php echo $total_admin_houses ?>
                    </h1>
                </a>
            </div>
            <div class="listing_number">
                <a href="../admin_listings_dashboard/">
                    <h1>
                        Verified
                    </h1>
                    <h1 class="number">
                        <?php echo $verified_admin_houses ?>
                    </h1>
                </a>
            </div>
            <div class="listing_number">
                <a href="../admin_listings_dashboard/">
                    <h1>
                        Not Verified
                    </h1>
                    <h1 class="number">
                        <?php echo $not_verified_admin_houses ?>
                    </h1>
                </a>
            </div>
        </div>
        <div class="right_col">
            <div class="right_container">
                <!-- <div class="profile_image">
                    <img src="../../images/background2.jpg" alt="">
                </div> -->
                <hr>
                <div class="top_element">
                    <h1>
                        <?php echo ucfirst($row['first_name']) . ' ' . ucfirst($row['last_name']) ?>

                    </h1>
                    <div class="level">
                        <h3>
                            Admin Level
                        </h3>
                        <h3>
                            <?php echo ucfirst($row['access_level']) ?>
                        </h3>
                    </div>

                </div>
                <hr>
                <div class="bottom_element">
                    <div class="details">
                        <h3>
                            Address
                        </h3>
                        <h3>
                            <?php echo ucfirst($row['home_address']) ?>

                        </h3>
                    </div>
                    <div class="details">
                        <h3>
                            Email
                        </h3>
                        <h3>
                            <?php echo ucfirst($row['email']) ?>

                        </h3>
                    </div>
                    <div class="details">
                        <h3>
                            Contact
                        </h3>
                        <h3>
                            <?php echo ucfirst($row['contact']) ?>

                        </h3>
                    </div>
                    <div class="details">
                        <h3>
                            Gender
                        </h3>
                        <h3>
                            <?php echo ucfirst($row['sex']) ?>

                        </h3>
                    </div>
                    <div class="details">
                        <h3>
                            Admin ID
                        </h3>
                        <h3>
                            <?php echo ucfirst($row['admin_id']) ?>

                        </h3>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="../jsfiles/onclickscript.js"></script>

</body>

</html>