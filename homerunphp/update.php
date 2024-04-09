<?php
session_start();

$sec = "0.1";

if (isset($_POST['update'])) {
    require 'advertisesdb.php';
    $user = $_SESSION['sessionowner'];

    if (empty($user)) {
        header("refresh:$sec;  ../homeownerlogin.php?error=youhavetologinfirst");
        exit();
    } else {
        $user = mysqli_real_escape_string($conn, $_COOKIE['update']);
        $update = mysqli_real_escape_string($conn, $_POST['availability']);

        $updatesql = "UPDATE homerunhouses SET available = '$update' WHERE email = '$user'";

        $query_run = mysqli_query($conn, $updatesql);

        if ($query_run) {
            header("refresh:$sec; ../profile.php?success=updatesuccessful");
            echo '<script type="text/javascript"> alert("Update Successfully") </script>';
        } else {
            header("refresh:$sec; ../profile.php?error=SQLError");
            echo '<script type="text/javascript"> alert("SQLError") </script>';
        }
    }
}

if (isset($_POST['viewpage'])) {
    $home_id = mysqli_real_escape_string($conn, $_COOKIE['update']);
    header("refresh:$sec; ../listingdetails.php?clicked_id=$home_id");
    setcookie("clicked_id", $home_id, time() + (86400 * 1), "/");
    setcookie("viewpage", mysqli_real_escape_string($conn, $_SESSION['sessionowner']), time() + (86400 * 1), "/");
}
