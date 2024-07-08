<?php
session_start();
$sec = "0.1";
setcookie("scriptPage", "homeownerloginscript.php", time() + (900 * 1), "/");
include '../required/alerts.php';

if (isset($_POST['submit'])) {
    require 'homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) || empty($password)) {
        redirect("../homeownerlogin.php?error=All Fields Are Required");
        exit();
    } else {
        $sql = "SELECT * FROM homerunhouses WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            redirect("../homeownerlogin.php?error=Sorry SQL Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $passcheck = password_verify($password, $row['passw']);

                if ($passcheck == false) {
                    redirect("../homeownerlogin.php?error=Oops!! Wrong Password");

                    exit();
                } elseif ($passcheck == true) {
                    $_SESSION['sessionowner'] = $row['home_id'];
                    redirect("../profile.php??error=You Have Logged In Successfully");

                    exit();
                }
            } else {
                redirect("../profile.php??error=Oops!! User Not Found");
                exit();
            }
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionowner'])) {
        session_destroy();
        redirect("../index.php??error=You Have Logged Out Successfully");

        exit();
    } else {
        redirect("../index.php??error=You Have Logged Out Successfully");
        exit();
    }
} else {
    redirect("../index.php??error=Access Denied");
    exit();
}
