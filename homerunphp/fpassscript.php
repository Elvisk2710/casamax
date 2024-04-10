<?php

session_start();
$table = $_COOKIE['page_pass'];

require 'homerunuserdb.php';

if (isset($_POST['submit_code'])) {
    $code = $_POST['code'];

    if ($code == $_COOKIE['code']) {
        $email = $_COOKIE['email'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $sql = "SELECT * FROM  $table WHERE email = '$email'";

        $results = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($results)) {

            $hashed_password = password_hash($_COOKIE['password'], PASSWORD_DEFAULT);
            $sqlupdate = "UPDATE $table SET passw  = '$hashed_password' WHERE email = '$email' ";
            $updatesql = mysqli_query($conn, $sqlupdate);

            if ($sqlupdate) {
                setcookie("code", '', time() + (-900 * 1), "/");
                setcookie("password", '', time() + (-900 * 1), "/");
                header("Refresh:0.1, ../" . $_COOKIE['loginPage'] . "");
                echo '<script type="text/javascript"> alert("YOU HAVE SUCCESSFULLY CHANGED YOUR PASSWORD") </script>';
            }
        }
    } else {
        header("Refresh:0.1, ../required/code.php");
        echo '<script type="text/javascript"> alert("SORRY YOUR CODE DOES NOT MATCH!!") </script>';
    }
} elseif (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($password != $confirm_pass) {
        echo '<script type="text/javascript"> alert("OOPS! Passwords Do Not Match") </script>';
        header("Refresh:0.1, ../required/fpass.php");
        if (empty($email) or empty($password) or empty($confirm_pass)) {
            echo '<script type="text/javascript"> alert("Please Fill Out The Form") </script>';
        }
    } else {
        setcookie("password", $password, time() + (900 * 1), "/");

        $sql = "SELECT * FROM $table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("refresh:s$sec; ../" . $_COOKIE['loginPage'] . "?error=sqlerror");
            echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $firstname = $row['firstname'];
                setcookie("email", $email, time() + (900 * 1), "/");
                $subject = 'code to change password';

                require "../required/sendMail.php";
                if ($mailStatus = "success") {
                    header("refresh:0.1; ../required/code.php");
                    echo "<script>
            alert('Email has been sent successfully')
        </script>";
                } else {
                    header("Refresh:0.1, ../" . $_COOKIE['loginPage'] . "?error=Failed To Send Mail!");
                }
            } else {
                header("Refresh:0.1, ../required/fpass.php");
                echo '<script> alert("No user found with this email!!")</script>';
            }
        }
    }
}
