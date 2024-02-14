<?php
session_start();
if (empty($_SESSION['sessionAdmin'])) {
    header("Location:../index.php?PleaseLogin");
    echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
    exit();
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
    echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
    header("refresh:0.1; ../index.php?error=youhavetologinfirst");
    exit();
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
        echo '<script type="text/javascript"> alert("SQL Error") </script>';
        header("refresh:0.1; ../index.php?error=SQLError");
        exit();
    }
}
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
                    <?php echo $total_admin_houses?>
                </h1>
            </div>
            <div class="listing_number">
                <h1>
                    Verified
                </h1>
                <h1 class="number">
                <?php echo $verified_admin_houses?>
                </h1>
            </div>
            <div class="listing_number">
                <h1>
                    Not Verified
                </h1>
                <h1 class="number">
                <?php echo $not_verified_admin_houses?>
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
                    <?php echo ucfirst($row['first_name']). ' ' .ucfirst($row['last_name'])?>

                    </h1>
                    <div class="level">
                        <h3>
                            Admin Level
                        </h3>
                        <h3>
                        <?php echo ucfirst($row['access_level'])?>
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
                        <?php echo ucfirst($row['address'])?>

                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Email
                        </h2>
                        <h3>
                        <?php echo ucfirst($row['email'])?>

                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Contact
                        </h2>
                        <h3>
                        <?php echo ucfirst($row['contact'])?>

                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Gender
                        </h2>
                        <h3>
                        <?php echo ucfirst($row['sex'])?>

                        </h3>
                    </div>
                    <div class="details">
                        <h2>
                            Admin ID
                        </h2>
                        <h3>
                        <?php echo ucfirst($row['admin_id'])?>

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