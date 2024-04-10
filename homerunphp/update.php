<?php
session_start();
require "./advertisesdb.php";
$sec = "0.1";

if (isset($_POST['update'])) {
    require 'advertisesdb.php';
    $user = $_SESSION['sessionowner'];

    if (empty($user)) {
        header("refresh:$sec;  ../homeownerlogin.php?error=You Have To Login First");
        exit();
    } else {
        $user = $_SESSION['sessionowner']; // Use session variable instead of cookie
        $update = $_POST['availability'];

        // Validate and sanitize input
        $update = mysqli_real_escape_string($conn, $update);
        // Additional validation if needed

        $stmt = $conn->prepare("UPDATE homerunhouses SET available = ? WHERE email = ?");
        $stmt->bind_param("ss", $update, $user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("refresh:$sec; ../profile.php?success=updatesuccessful");
            echo '<script type="text/javascript"> alert("Update Successfully") </script>';
        } else {
            header("refresh:$sec; ../profile.php?error=SQLError");
            echo '<script type="text/javascript"> alert("SQLError") </script>';
        }
    }
}
