<?php
session_start();
$sec = "0.1";

if (isset($_POST['submit'])) {

    require 'homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) || empty($password)) {
        header("refresh:$sec; ../admin?error=emptyfields");
        echo '<script type="text/javascript"> alert("Empty Fields") </script>';
        exit();
    } else {
        $sql = "SELECT * FROM admin_table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("refresh:$sec; ../admin?error=sqlerror");
            echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $storedPassword = $row['passw'];
                if (password_verify($password, $storedPassword)) {
                // if ($password == $row['passw']) {
                    // Password verification using password_verify function
                    $_SESSION['sessionAdmin'] = $row['admin_id'];
                    $_SESSION['access'] = $row['access_level'];
                    header("Refresh: $sec; URL = ../admin/dashboard?error=success");
                    exit();
                } else {
                    // Incorrect password
                    header("Refresh: $sec; URL = ../admin?error=wrongpass");
                    echo '<script type="text/javascript"> alert("Wrong Password!") </script>';
                    exit();
                }
            } else {
                // User not found
                header("Refresh:$sec; ../admin?error=UserNotFound");
                echo '<script type="text/javascript"> alert("OOPS! Could Not Find User") </script>';
                exit();
            }
        }
    }
} elseif (isset($_POST['logout'])) {

    if (isset($_SESSION['sessionAdmin'])) {
        session_destroy();
    }
    header("refresh:$sec; ../index.php?error=LoggedOut");
    echo '<script type="text/javascript"> alert("You Have Successfully Logged Out") </script>';
    exit();
}
