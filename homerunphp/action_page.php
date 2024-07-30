<?php

session_start();
require 'advertisesdb.php';
include '../required/alerts.php';
require '../required/common_functions.php';

if (isset($_POST['submit'])) {
    $user = $_SESSION['sessionowner'];

    if (empty($user)) {
        redirect("../homeownerlogin.php?error=You Have To Login First");
        exit();
    } else {

        $_SESSION['sessionUser'] = $user;
        $rooms = $_POST['rooms'];
        $price = $_POST['price'];
        $address = $_POST['adrs'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];

        $rooms = sanitize_string($rooms);
        $phone = sanitize_integer($phone);
        $firstname = sanitize_string($firstname);
        $lastname = sanitize_string($lastname);
        $price = sanitize_integer($price);
        $address = sanitize_string($address);


        $sql = "UPDATE homerunhouses SET firstname = '$firstname', lastname ='$lastname' ,contact = '$phone', price = '$price', people_in_a_room = '$rooms',adrs ='$address' WHERE home_id = '$user'";

        $query_run = mysqli_query($conn, $sql);

        if (!$query_run) {
            redirect("../profile.php?error=SQL ERROr");
        } else {
            redirect("../profile.php?error=Update Successful");
        }
    }
} elseif (isset($_POST['student_submit'])) {
    $user = $_SESSION['sessionstudent'];

    if (empty($user)) {
        redirect("../login.php?error=You Have To Login First");
    } else {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $contact = $_POST['contact'];
        $uni = $_POST['university'];

        $firstname = sanitize_string($firstname);
        $lastname = sanitize_string($lastname);
        $gender = sanitize_string($gender);
        $contact = sanitize_integer($contact);
        $uni = sanitize_string($uni);

        $sql = "UPDATE homerunuserdb SET firstname = '$firstname', lastname = '$lastname', dob = '$dob', sex = '$gender', contact = '$contact', university = '$uni' WHERE userid = '$user'";

        $query_run = mysqli_query($conn, $sql);
        if (!$query_run) {
            redirect("../student_profile.php?error=SQL Error");
        } else {
            redirect(" ../student_profile.php?error=Update Success");
        }
    }
} elseif (isset($_POST['student_logout'])) {
    session_unset();
    redirect(" ../login.php?error=You Have Logged Out Successfully");
} else {
    redirect(" ../index.php?error=Access Denied");
}
