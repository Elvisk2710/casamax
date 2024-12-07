<?php
session_start();
$currentMonthFull = date('F');
$amount = 2201;
$formattedAmount = number_format($amount, 2);

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
    <link rel="stylesheet" href="../dashboard/dashboard.css">
    <link rel="icon" href="../../images/logowhite.png">
    <title>Admin Profile</title>
</head>

<body onunload="">
    <?php
    require '../../required/pageloader.php';
    ?>
    <div class="container">
        <?php
        require '../components/admin_navbar.php'
        ?>
        <div class="left-col-profile">
        <div class="top-row-info">
            <form action="" class="info-form">
                <div class="top-info-container">
                    <div class="info-row">
                        <div class="info-ttile">Name:</div>
                        <input class="info-value" type="text" value="Elvis" />
                    </div>
                    <div class="info-row">
                        <div class="info-ttile">Last-Name:</div>
                        <input class="info-value" type="text" value="Elvis" />
                    </div>
                    <div class="info-row">
                        <div class="info-ttile">Address:</div>
                        <input class="info-value" type="text" value="Elvis" />
                    </div>
                </div>
                <div class="top-info-container">
                    <div class="info-row">
                        <div class="info-ttile">Name</div>
                        <input class="info-value" type="text" value="Elvis" />
                    </div>
                    <div class="info-row">
                        <div class="info-ttile">Contact</div>
                        <input class="info-value" type="text" value="Elvis" />
                    </div>
                    <div class="info-row">
                        <button>
                            Change Info
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <script src="../jsfiles/onclickscript.js"></script>

</body>

</html>