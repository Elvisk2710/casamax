<?php
session_start();
$sec = "0.1";
require '../required/alerts.php';
require '../required/common_functions.php';
require 'homerunuserdb.php';

if (isset($_POST['submit'])) {

    $email = sanitize_email($_POST['email']);
    $password = sanitize_string($_POST['password']);

    if (empty($email) || empty($password)) {
        redirect("../admin?error=All Fields Are Required");
    } else {
        $sql = "SELECT * FROM admin_table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            redirect("../admin?error=SQL Error");
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $storedPassword = $row['passw'];
                if (password_verify($password, $storedPassword)) {
                    // Password verification using password_verify function
                    session_destroy();
                    session_start();
                    $_SESSION['sessionAdmin'] = $row['admin_id'];
                    $_SESSION['access'] = $row['access_level'];
                    redirect("../admin/dashboard?error=You Have Logged In Successfully");
                } else {
                    // Incorrect password
                    redirect("../admin?error=Wrong Password");
                }
            } else {
                // User not found
                redirect("../admin?error=User Not Found");
            }
        }
    }
}elseif (isset($_POST['employee_submit'])){
    $email = sanitize_email($_POST['email']);
    $password = sanitize_string($_POST['password']);

    if (empty($email) || empty($password)) {
        redirect("../employeeDashboard?error=All Fields Are Required");
    } else {
        $sql = "SELECT * FROM admin_table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            redirect("../employeeDashboard?error=SQL Error");
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $storedPassword = $row['passw'];
                if (password_verify($password, $storedPassword)) {
                    // Password verification using password_verify function
                    session_destroy();
                    session_start();
                    $_SESSION['sessionEmployee'] = $row['admin_id'];
                    $_SESSION['access'] = $row['access_level'];
                    redirect("../employeeDashboard/dashboard?error=You Have Logged In Successfully");
                } else {
                    // Incorrect password
                    redirect("../employeeDashboard?error=Wrong Password");
                }
            } else {
                // User not found
                redirect("../employeeDashboard?error=User Not Found");
            }
        }
    }

} elseif (isset($_POST['logout'])) {

    if (isset($_SESSION['sessionAdmin']) || isset($_SESSION['sessionEmployee'])) {
        session_destroy();
    }
    redirect("../index.php?error=You Have Logged Out Successfully");
}
