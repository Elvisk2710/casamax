<?php
session_start();
$currentMonthFull = date('F');
$amount = 2201;
$formattedAmount = number_format($amount, 2);

if (empty($_SESSION['sessionEmployee'])) {
    require '../../required/alerts.php';
    redirect('../index.php?error=Please Login');
} else {
    $user = $_SESSION['sessionEmployee'];
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
    <title>Employee Dashboard</title>
</head>

<body onunload="">
    <?php
    // require '../components/admin_advertise_form.php';
    // require '../components/add_admin_agent.php';
    require '../../required/pageloader.php';
    ?>
    <div class="container">
        <?php
        require '../components/admin_navbar.php'
        ?>
        <div class="left-col">
            <?php
                require '../../required/nav_header.php';
            ?>
            <!-- <div class="left-col-content"> -->
            <div class="top-row">
                <div class="top-row-container">
                    <div class="top-container-top">
                        <div class="top-container-top-icon">
                            <img src="../../images/wallet.png" alt="">
                        </div>
                    </div>
                    <div class="top-container-value">
                        <h2>$<?php echo $formattedAmount ?></h2>
                    </div>
                    <div class="top-container-desc">
                        <p>Commission (<?php echo $currentMonthFull ?>)</p>
                    </div>
                </div>
                <div class="top-row-container">
                    <div class="top-container-top">
                        <div class="top-container-top-icon">
                        <img src="../../images/house_added.png" alt="">
                        </div>
                    </div>
                    <div class="top-container-value">
                        <h2>6</h2>
                    </div>
                    <div class="top-container-desc">
                        <p>Houses Added (<?php echo $currentMonthFull ?>)</p>
                    </div>
                </div>
                <div class="top-row-container">
                    <div class="top-container-top">
                        <div class="top-container-top-icon">
                        <img src="../../images/verified_home.png" alt="">
                        </div>
                    </div>
                    <div class="top-container-value">
                        <h2>2</h2>
                    </div>
                    <div class="top-container-desc">
                        <p>Verified Houses (<?php echo $currentMonthFull ?>)</p>
                    </div>
                </div>
                <div class="top-row-container">
                    <div class="top-container-top">
                        <div class="top-container-top-icon">
                        <img src="../../images/house_listings.png" alt="">
                        </div>
                    </div>
                    <div class="top-container-value">
                        <h2>30</h2>
                    </div>
                    <div class="top-container-desc">
                        <p>Total Houses Added</p>
                    </div>
                </div>
            </div>
            <div class="bottom-row">
                <div class="bottom-left">
                    <div class="bottom-left-header">
                        <h2>
                            My Houses
                        </h2>
                        <div class="button">
                            <p class="positive-percent">
                                5 (Last Month)
                            </p>
                            <a href="../admin_listings_dashboard">
                            <Button>
                                View All Houses
                            </Button>
                            </a>
                        </div>
                    </div>
                    <div class="history-table">
                        <table>
                            <thead>
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>johndoe@example.com</td>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>+123456789</td>
                                    <td>12345</td>
                                    <td>123 Main St, City A</td>
                                    <td class="verified-yes">Yes</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>janesmith@example.com</td>
                                    <td>Jane</td>
                                    <td>Smith</td>
                                    <td>+987654321</td>
                                    <td>67890</td>
                                    <td>456 Oak Ave, City B</td>
                                    <td class="verified-no">No</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>bobmartin@example.com</td>
                                    <td>Bob</td>
                                    <td>Martin</td>
                                    <td>+112233445</td>
                                    <td>11223</td>
                                    <td>789 Pine Rd, City C</td>
                                    <td class="verified-yes">Yes</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>sarajones@example.com</td>
                                    <td>Sara</td>
                                    <td>Jones</td>
                                    <td>+998877665</td>
                                    <td>44556</td>
                                    <td>321 Elm St, City D</td>
                                    <td class="verified-no">No</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>michaeldavis@example.com</td>
                                    <td>Michael</td>
                                    <td>Davis</td>
                                    <td>+556677889</td>
                                    <td>77889</td>
                                    <td>654 Maple Ave, City E</td>
                                    <td class="verified-yes">Yes</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bottom-right">
                    <div class="bottom-right-header">
                        <h2>
                            Commission History
                        </h2>
                        <p class="positive-percent">
                            +32% (Last Month)
                        </p>
                    </div>
                    <div class="history-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Month</th>
                                    <th>Commission Earned</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2024-11-01</td>
                                    <td>October</td>
                                    <td>$500</td>
                                    <td class="status-paid">Paid</td>
                                </tr>
                                <tr>
                                    <td>2024-11-05</td>
                                    <td>September</td>
                                    <td>$1,200</td>
                                    <td class="status-pending">Pending</td>
                                </tr>
                                <tr>
                                    <td>2024-11-10</td>
                                    <td>August</td>
                                    <td>$300</td>
                                    <td class="status-canceled">Canceled</td>
                                </tr>
                                <tr>
                                    <td>2024-11-10</td>
                                    <td>August</td>
                                    <td>$300</td>
                                    <td class="status-canceled">Canceled</td>
                                </tr>
                                <tr>
                                    <td>2024-11-10</td>
                                    <td>August</td>
                                    <td>$300</td>
                                    <td class="status-canceled">Canceled</td>
                                </tr>
                                <tr>
                                    <td>2024-11-10</td>
                                    <td>August</td>
                                    <td>$300</td>
                                    <td class="status-canceled">Canceled</td>
                                </tr>
                                <tr>
                                    <td>2024-11-10</td>
                                    <td>August</td>
                                    <td>$300</td>
                                    <td class="status-canceled">Canceled</td>
                                </tr>
                                <tr>
                                    <td>2024-11-10</td>
                                    <td>August</td>
                                    <td>$300</td>
                                    <td class="status-canceled">Canceled</td>
                                </tr>
                                <tr>
                                    <td>2024-11-10</td>
                                    <td>August</td>
                                    <td>$300</td>
                                    <td class="status-canceled">Canceled</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>

    </div>
    <script src="../jsfiles/onclickscript.js"></script>

</body>

</html>