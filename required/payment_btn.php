<?php
$pageloader = "waiting confirmation";
require 'pageloader.php';
$sec = 0.1;
require '../homerunphp/advertisesdb.php';
require 'subscriber_billing.php';
$this_date = date('y-m-d');


if (isset($_POST['1day'])) {
    $sub_type = "1 house";
    $number_of_houses = 1;
    $time_unit = 'daily';
    $period = 1;
    $amount = 8000;

    require './paynow.php';
} elseif (isset($_POST['4day'])) {
    $sub_type = "5 house";
    $number_of_houses = 5;
    $time_unit = 'daily';
    $period = 3;
    $amount = 16000;

    require './paynow.php';
} elseif (isset($_POST['1week'])) {
    $sub_type = "10 house";
    $number_of_houses = 10;
    $time_unit = 'daily';
    $period = 7;
    $amount = 28000;

    require './paynow.php';
}
