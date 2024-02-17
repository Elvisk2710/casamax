<?php
session_start();
if (empty($_SESSION['sessionAdmin'])) {
    header("Location:../index.php?PleaseLogin");
    echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
    exit();
} else {
    require_once '../../homerunphp/advertisesdb.php';
    $admin_id = $_SESSION['sessionAdmin'];
    // gets details of the admin
    $sql = "SELECT * FROM  admin_table WHERE admin_id = '$admin_id' ";
    if ($rs_result = mysqli_query($conn, $sql)) {
        $row_admin = mysqli_fetch_array($rs_result);
        // finds the verified homes;
        $sql_verified = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id' AND verified = '1'";
        // handles the search values
        if (isset($_POST['admin_search']) && $_POST['admin_search_value'] != null) {
            $search_value = $_POST['admin_search_value'];
            $sql_home = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id' AND lastname = '$search_value'";
        } elseif (isset($_POST['admin_clear_search'])) {
            // resets the search value
            $_POST['admin_search_value'] != null;
            $search_value = $_POST['admin_search_value'];
            $sql_home = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id'";
        } else {
            // gets data of the houses
            $sql_home = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id'";
        }

        // gets the number of verified houses
        $num_result_verified = mysqli_query($conn, $sql_verified);
        $total_verified_records = mysqli_num_rows($num_result_verified);

        // gets the number of verified houses
        $num_result = mysqli_query($conn, $sql_home);
        $total_records = mysqli_num_rows($num_result);

        // gets the number of the total houses for that admin
        $result = mysqli_query($conn, $sql_home);
        $row = mysqli_fetch_array($num_result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Listings</title>
    <link rel="icon" href="../../images/logowhite.png">
    <link rel="stylesheet" href="./admin_listings_dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <?php
        include '../components/admin_navbar.php';
        ?>
        <div class="right_col">
            <div class="left_col_top">
                <div class="left_col_top_left">
                    <div class="left_col_top_left_details">
                        <h2>
                            Casamax Agent Id
                        </h2>
                        <h2>
                            <?php echo $_SESSION['sessionAdmin'] ?>
                        </h2>
                    </div>
                    <div class="left_col_top_left_details">
                        <h2>
                            Total Listings
                        </h2>
                        <h2>
                            <?php echo $total_records ?>
                        </h2>
                    </div>
                    <div class="left_col_top_left_details">
                        <h2>
                            Verified Listings
                        </h2>
                        <h2>
                            <?php echo $total_verified_records ?>
                        </h2>
                    </div>

                </div>
                <div class="left_col_top_right">
                    <div class="amount_earned">
                        <h2>
                            Amount Earned: <?php echo $row_admin['amount_earned'] ?>
                        </h2>
                    </div>
                    <form class="select_view" action="./" method="post">
                        <input type="text" name="admin_search_value" id="admin_search" placeholder="Search By Lastname">
                        <button type="submit" name="admin_search">
                            Search
                        </button>
                        <button type="submit" name="admin_clear_search" class="view_button">
                            Clear
                        </button>
                    </form>
                </div>
            </div>
            <hr>
            <div class="right_col_bottom">
                <table>
                    <tr>
                        <th>
                            Home ID
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Firstname
                        </th>
                        <th>
                            Lastname
                        </th>
                        <th>
                            Contact
                        </th>
                        <th>
                            ID Number
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Verified
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    <?php include '../../homerunphp/admin_listing_query.php' ?>
                </table>
            </div>
        </div>
    </div>

</body>
<script src="../../jsfiles/onclickscript.js"></script>

</html>