<?php
session_start();
if (empty($_SESSION['sessionEmployee'])) {
    require '../../required/common_functions.php';
    redirect('../index.php?error=Please Login');
} else {
    require_once '../../homerunphp/advertisesdb.php';
    $admin_id = $_SESSION['sessionEmployee'];
    if (isset($_POST['admin_view_house_search'])) {
        $_SESSION['table'] = 'house';
    } elseif (isset($_POST['admin_view_agents_search'])) {
        $_SESSION['table'] = 'agent';
    } else {
        $_SESSION['table'] = 'all';
    }
    // gets details of the admin
    $sql = "SELECT * FROM  admin_table WHERE admin_id = '$admin_id' ";
    if ($rs_result = mysqli_query($conn, $sql)) {
        $row_admin = mysqli_fetch_array($rs_result);
        // finds the verified homes;
        $sql_verified = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id' AND verified = '1'";
        // handles the search values
        if (isset($_POST['admin_search']) && $_POST['admin_search_value'] != null) {
            $search_value = $_POST['admin_search_value'];
            $sql_home = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id' AND lastname LIKE '$search_value' AND firstname LIKE '$search_value'";
        } elseif (isset($_POST['admin_clear_search'])) {
            // checks if the session for verifying all houses is true and set then turns it to false
            $_SESSION['table'] = 'all';
            // resets the search value
            $_POST['admin_search_value'] = null;
            $sql_home = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id'";
        } elseif ($_SESSION['table'] == 'house' || (isset($_SESSION['verify_all']) && $_SESSION['verify_all'] == true)) {
            $table_name = 'House';
            $sql_home = "SELECT * FROM homerunhouses WHERE verified != '1' AND (agent_id IS NULL OR agent_id = '') AND (id_image IS NOT NULL AND id_image != '') AND (res_image IS NOT NULL AND res_image != '');";
        } elseif ($_SESSION['table'] == 'agent' || (isset($_SESSION['verify_all']) && $_SESSION['verify_all'] == true)) {
            $table_name = 'Agents';
            $sql_home = "SELECT * FROM agents WHERE verified != '1' OR verification_image IS NOT NULL;";
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
    <title>Employee Listings</title>
    <link rel="icon" href="../../images/logowhite.png">
    <link rel="stylesheet" href="./admin_listings_dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../jsfiles/onclickscript.js"></script>
</head>

<body onunload="">
    <div class="container">
        <?php
        include '../components/admin_navbar.php';
        require '../../required/pageloader.php';
        ?>
        <div class="small_screen_overlay">
            <div class="overlay_center">
                <h1>
                    This screen is only optimised for a lorger screen (i.e laptops)
                </h1>
                <br>
                <h3>
                    Download Your Records Instead
                </h3>
                <br>
                <button type="button" name="download_pdf" class="view_button" onclick="generatePdf()">
                    Download Pdf File
                </button>
            </div>
        </div>

        <div class="right_col">
            <?php
            require '../../required/nav_header.php';
            ?>
            <div class="left_col_top">
                <div class="left_col_top_left">
                    <div class="left_col_top_left_details">
                        <h2>
                            Casamax Employee Id
                        </h2>
                        <h2>
                            <?php echo $_SESSION['sessionEmployee'] ?>
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
                            Reset
                        </button>

                    </form>
                    <div>
                        <form action="./" method="post">
                            <button type="button" name="download_pdf" class="view_button" onclick="generatePDF()">
                                Download Pdf File
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            <hr>
            <?php
            if ($total_records == 0) {

            ?>

                <div class="right_col_bottom">
                    <h2>
                        NO Records Found!!!
                    </h2>
                </div>
            <?php
            } else {
            ?>
                <div class="right_col_bottom">
                    <table>
                        <tr>
                            <th>
                                ID
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
                            <?php
                            if ($_SESSION['access'] == 1 || $_SESSION['access'] == 2) {
                            ?>
                                <th>
                                    Action
                                </th>
                            <?php
                            }
                            ?>
                        </tr>
                        <?php
                        include '../../homerunphp/admin_listing_query.php'
                        ?>
                    </table>
                </div>

            <?php
            }

            ?>
        </div>
    </div>

</body>
<script src="../../jsfiles/onclickscript.js"></script>

</html>