<?php
$pageloader = "Loading Please Wait";
// require './pageloader.php';
require '../homerunphp/advertisesdb.php';
require 'subscriber_billing.php';
$this_date = date('y-m-d');

if (isset($_POST['basic'])) {
    $sub_type = "basic";
    $time_unit = 'daily';
    $period = 90;
    $amount = 25;
    require './paynow.php';
} elseif (isset($_POST['premium'])) {
    $sub_type = "premium";
    $time_unit = 'daily';
    $period = 180;
    $amount = 45;
    require './paynow.php';
} elseif (isset($_POST['pro'])) {
    $sub_type = "pro";
    $time_unit = 'daily';
    $period = 365;
    $amount = 80;
    require './paynow.php';
}
