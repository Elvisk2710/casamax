<?php
session_start();
$sec = "0.1";

if (isset($_POST['submit'])) {

    require 'homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) or empty($password)) {
        header("refresh:$sec; ../admin?error=emptyfields");
        echo '<script type="text/javascript"> alert("Empty Fields") </script>';
        exit();
    } else {
        $sql = "SELECT * FROM admin_table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("refresh:s$sec; ../admin?error=sqlerror");
            echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                // $passcheck = password_verify($password, $row['passw']);
                if ($password = $row['passw']) {
                    $passcheck = true;
                }
                //  checking if the password is equal to the stored password
                if ($passcheck == false) {
                    header("Refresh: $sec; URL = ../admin?error=wrongpass");
                    echo '<script type="text/javascript"> alert("Wrong Password!") </script>';
                } elseif ($passcheck == true) {
                    // starting the admin session
                    $_SESSION['sessionAdmin'] = $row['admin_id'];
                    $_SESSION['access'] = $row['access_level'];
                    header("Refresh: $sec; URL = ../admin/dashboard?error=success");
                    
                } else {
                    // for the wrong password
                    header("refresh:$sec; ../admin?error=wrongpass");
                    echo '<script type="text/javascript"> alert("Wrong Password") </script>';
                    exit();
                }
            } else {
                // if user is not found
                header("Refresh:$sec; ../admin?error=UserNotFound");
                echo '<script type="text/javascript"> alert("OOPS! Could Not Find User") </script>';
                exit();
            }
        }
    }

    // logging out 
} elseif (isset($_POST['logout'])) {

    if (isset($_SESSION['sessionstudent'])) {
        session_destroy();
    }
    header("refresh:$sec; ../index.php?error=LoggedOut");
    echo '<script type="text/javascript"> alert("You Have Successfully Logged Out") </script>';
    exit();
}
