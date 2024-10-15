<?php
if (!isset($_SESSION['sessionagent'])) {
    header("Location: ../agent/index.php?error=please login first");
    exit();
}
$this_date = date('y-m-d');
require './homerunphp/advertisesdb.php';
$pageloader = "Loading Please Wait";

if (isset($_POST['month_basic'])) {
    $sub_type = "month_basic";
    $time_unit = 'daily';
    $period = 90;
    $amount = 25;
    require './paynow.php';
} elseif (isset($_POST['month_premium'])) {
    $sub_type = "month_premium";
    $time_unit = 'daily';
    $period = 180;
    $amount = 45;
    require './paynow.php';
} elseif (isset($_POST['month_pro'])) {
    $sub_type = "month_pro";
    $time_unit = 'daily';
    $period = 365;
    $amount = 80;
    require './paynow.php';
} else if (isset($_POST['half_basic'])) {
    $sub_type = "half_basic";
    $time_unit = 'daily';
    $period = 90;
    $amount = 25;
    require './paynow.php';
} elseif (isset($_POST['half_premium'])) {
    $sub_type = "half_premium";
    $time_unit = 'daily';
    $period = 180;
    $amount = 45;
    require './paynow.php';
} elseif (isset($_POST['half_pro'])) {
    $sub_type = "half_pro";
    $time_unit = 'daily';
    $period = 365;
    $amount = 80;
    require './paynow.php';
} else if (isset($_POST['full_basic'])) {
    $sub_type = "full_basic";
    $time_unit = 'daily';
    $period = 90;
    $amount = 25;
    require './paynow.php';
} elseif (isset($_POST['full_premium'])) {
    $sub_type = "full_premium";
    $time_unit = 'daily';
    $period = 180;
    $amount = 45;
    require './paynow.php';
} elseif (isset($_POST['full_pro'])) {
    $sub_type = "full_pro";
    $time_unit = 'daily';
    $period = 365;
    $amount = 80;
    require './paynow.php';
}
