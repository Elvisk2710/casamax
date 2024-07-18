<?php
session_start();
require '../required/alerts.php';
require "./advertisesdb.php";
require '../required/common_functions.php';

$sec = "0.1";

if (isset($_POST['update'])) {
    require 'advertisesdb.php';
    $user = $_SESSION['sessionowner'];

    if (empty($user)) {
        redirect(" ../homeownerlogin.php?error=You Have To Login First");
        exit();
    } else {
        $user = sanitize_string($_SESSION['sessionowner']); // Use session variable instead of cookie
        $update = $_POST['availability'];

        // Validate and sanitize input
        $update = mysqli_real_escape_string($conn, $update);
        // Additional validation if needed

        $stmt = $conn->prepare("UPDATE homerunhouses SET available = ? WHERE home_id = ?");
        $stmt->bind_param("ss", $update, $user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            redirect(" ../profile.php?success=Update Successful");
            exit();
        } else {
            redirect(" ../profile.php?error=SQL Error");
            exit();
        }
    }
}
