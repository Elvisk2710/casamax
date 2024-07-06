<?php

session_start();
require 'advertisesdb.php';

$sec = "0.1";

if (isset($_POST['submit'])) {
    $user = $_SESSION['sessionowner'];

    if (empty($user)) {
        header("refresh:$sec; ../homeownerlogin.php?error=youhavetologinfirst");
        echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
        exit();
    } else {

        $_SESSION['sessionUser'] = $user;
        $rooms = $_POST['rooms'];
        $price = $_POST['price'];
        $address = $_POST['adrs'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];

        $rooms = filter_var($rooms, FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
        $address = filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS);


        $sql = "UPDATE homerunhouses SET firstname = '$firstname', lastname ='$lastname' ,contact = '$phone', price = '$price', people_in_a_room = '$rooms',adrs ='$address' WHERE email = '$user'";

        $query_run = mysqli_query($conn, $sql);

        if (!$query_run) {
            header("refresh:$sec;  ../profile.php?error=SQL Error");
            echo '<script type="text/javascript"> alert("SQL Error") </script>';
        } else {
            header("refresh:$sec; ../profile.php?error=Update Success");
            $_SESSION['sessionowner'] = $email;
            echo '<script type="text/javascript"> alert("Update Successfully") </script>';

            exit();
        }
    }
} elseif (isset($_POST['student_submit'])) {
    $user = $_SESSION['sessionstudent'];

    if (empty($user)) {
        header("refresh:$sec; ../login.php?error=You Have To Login First");
        echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
        exit();
    } else {

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $contact = $_POST['contact'];
        $uni = $_POST['university'];

        $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
        $gender = filter_var($gender, FILTER_SANITIZE_SPECIAL_CHARS);
        $contact = filter_var($contact, FILTER_SANITIZE_NUMBER_INT);
        $uni = filter_var($uni, FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "UPDATE homerunuserdb SET firstname = '$firstname', lastname = '$lastname', dob = '$dob', sex = '$gender', contact = '$contact', university = '$uni' WHERE userid = '$user'";

        $query_run = mysqli_query($conn, $sql);
        if (!$query_run) {
            header("refresh:$sec;  ../student_profile.php?error=SQL Error");
            echo '<script type="text/javascript"> alert("SQL Error") </script>';
        } else {
            header("refresh:$sec; ../student_profile.php?error=Update Success");
            echo '<script type="text/javascript"> alert("Update Successfully") </script>';
            exit();
        }
    }
} elseif (isset($_POST['student_logout'])) {
    session_unset();
    header("location: ../login.php");
} else {
    header("refresh:$sec;  ../index.php?error=Access Denied");
    echo '<script type="text/javascript"> alert("Access Denied") </script>';
}
