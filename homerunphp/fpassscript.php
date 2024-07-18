<?php
include '../required/alerts.php';
session_start();
$table = $_COOKIE['page_pass'];

require 'homerunuserdb.php';
require '../required/common_functions.php';

if (isset($_POST['submit_code'])) {
    $code = $_POST['code'];

    if ($code == $_COOKIE['code']) {
        $email = sanitize_email($_COOKIE['email']);

        $sql = "SELECT * FROM $table WHERE email = '$email'";
        $results = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($results)) {
            $hashed_password = password_hash($_COOKIE['password'], PASSWORD_DEFAULT);
            $sqlupdate = "UPDATE $table SET passw = '$hashed_password' WHERE email = '$email'";
            $updatesql = mysqli_query($conn, $sqlupdate);

            if ($updatesql) {
                setcookie("code", '', time() + (-900 * 1), "/");
                setcookie("password", '', time() + (-900 * 1), "/");
                redirect("../" . $_COOKIE['loginPage'] . "?message=YOU HAVE SUCCESSFULLY CHANGED YOUR PASSWORD");
                exit();
            } else {
                redirect("../required/code.php?error=Failed to update password. Please try again.");
            }
        } else {
            redirect("../required/code.php?error=No user found with this email.");
        }
    } else {
        redirect("../required/code.php?error=SORRY YOUR CODE DOES NOT MATCH!!");
    }
} elseif (isset($_POST['submit'])) {
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($password != $confirm_pass) {
        redirect("../required/fpass.php?error=OOPS! Passwords Do Not Match");
    } elseif (empty($email) || empty($password) || empty($confirm_pass)) {
        redirect("../required/fpass.php?error=Please Fill Out The Form");
    } else {
        setcookie("password", $password, time() + (900 * 1), "/");

        $sql = "SELECT * FROM $table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            redirect("../" . $_COOKIE['loginPage'] . "?error=SQL Error");
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $firstname = $row['firstname'];
                setcookie("email", $email, time() + (900 * 1), "/");
                $subject = 'Code to Change Password';

                require "../required/sendMail.php";
                if ($mailStatus == "success") {
                    redirect("../required/code.php?message=Email has been sent successfully");
                } else {
                    redirect("../" . $_COOKIE['loginPage'] . "?error=Failed To Send Mail!");
                }
            } else {
                redirect("../required/fpass.php?error=No user found with this email!!");
            }
        }
    }
} else {
    redirect("../required/fpass.php");
}
?>
