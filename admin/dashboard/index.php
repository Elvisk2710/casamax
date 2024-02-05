<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dashboard.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <?php
    include '../components/admin_advertise_form.php'
    ?>
    <div class="container">
        <?php
        require '../components/admin_navbar.php'
        ?>
        <div class="left_col">
            <div class="add_listing" onclick="OpenAddListingForm()">
                <h1>
                    Add Listing
                </h1>
                <h1 class="number">
                    +
                </h1>
            </div>
            <div class="listing_number">
                <h1>
                    Total Listings
                </h1>
                <h1 class="number">
                    13
                </h1>
            </div>
            <div class="listing_number">
                <h1>
                    Verified
                </h1>
                <h1 class="number">
                    5
                </h1>
            </div>
            <div class="listing_number">
                <h1>
                    Not Verified
                </h1>
                <h1 class="number">
                    8
                </h1>
            </div>

        </div>
        <div class="right_col">
            <div class="right_container">
                <div class="profile_image">
                    <img src="../../images/background2.jpg" alt="">
                </div>
                <hr>
                <div class="top_element">
                    <h1>
                        Elvis Kadeya
                    </h1>
                    <div class="level">
                        <h3>
                            Admin Level
                        </h3>
                        <h3>
                            3
                        </h3>
                    </div>

                </div>
                <hr>
                <div class="bottom_element">
                    <div class="details">
                        <h2>
                            Address
                        </h2>
                        <h3>
                            28 Alfred Florida Mutare
                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Email
                        </h2>
                        <h3>
                            Kadeyaelvis@gmail.com
                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Contact
                        </h2>
                        <h3>
                            0786989144
                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Gender
                        </h2>
                        <h3>
                            Male
                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Admin ID
                        </h2>
                        <h3>
                            CMA0001
                        </h3>
                    </div>
                    <!-- <div class="edit_profile">
                        <button>
                            Edit Profile
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <script src="../jsfiles/onclickscript.js"></script>

</body>

</html>