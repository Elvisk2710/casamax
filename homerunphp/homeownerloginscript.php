<?php
session_start();
$sec = "0.1";
setcookie("scriptPage", "homeownerloginscript.php", time() + (900 * 1), "/");

if (isset($_POST['submit'])) {
    require 'homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) || empty($password)) {
        header("Location: ../homeownerlogin.php?error=Empty Fields");
        exit();
    } else {
        $sql = "SELECT * FROM homerunhouses WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../homeownerlogin.php?error=SQl Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $passcheck = password_verify($password, $row['passw']);

                if ($passcheck == false) {
                    header("Location: ../homeownerlogin.php?error=Wrong Password");
                    exit();
                } elseif ($passcheck == true) {
                    $_SESSION['sessionowner'] = $row['home_id'];
                    header("Location: ../profile.php?loginsuccess");
                    exit();
                }
            } else {
                header("Location: ../homeownerlogin.php?error=User Not Found");
                exit();
            }
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionowner'])) {
        session_destroy();
        header("Location: ../index.php?error=Logged Out");
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php?error=Access Denied");
    exit();
}
