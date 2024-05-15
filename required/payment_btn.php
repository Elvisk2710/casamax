<?php
$pageloader = "waiting confirmation";
require 'pageloader.php';
$sec = 0.1;
require '../homerunphp/advertisesdb.php';
require 'subscriber_billing.php';
$this_date = date('y-m-d');


if (isset($_POST['starter'])) {
    $sub_type = "1 house subscription!!";
    $number_of_houses = 1;
    $time_unit = 'daily';
    $period = 30;
    $amount = 14;
    echo "starter";

    require './paynow.php';
} elseif (isset($_POST['basic'])) {
    $sub_type = "5 house subscription!!";
    $number_of_houses = 5;
    $time_unit = 'daily';
    $period = 30;
    $amount = 42;
    echo "basic";

    require './paynow.php';
} elseif (isset($_POST['pro'])) {
    $sub_type = "15 house subscription!!";
    $number_of_houses = 15;
    $time_unit = 'daily';
    $period = 30;
    $amount = 70;
    echo "pro";

    require './paynow.php';
}
