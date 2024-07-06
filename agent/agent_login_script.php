<?php
session_start();
$sec = "0.1";


if (isset($_POST['submit'])) {
    setcookie("scriptPage", "./index.php", time() + (900 * 1), "/");

    require '../homerunphp/homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);


    if (empty($email) or empty($password)) {
        header("refresh:$sec;  ./index.php?error=Empty Fields");
        echo '<script type="text/javascript"> alert("Empty Fields") </script>';
        exit();
    } else {
        $sql = "SELECT * FROM agents WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("refresh:$sec;   ./index.php?error=SQl Error");
            echo '<script type="text/javascript"> alert("SQL Error") </script>';
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {

                $passcheck = password_verify($password, $row['passw']);

                if ($passcheck == false) {
                    header("refresh:$sec;  ./index.php?error=Wrong Password");
                    echo '<script type="text/javascript"> alert("Wrong Password") </script>';
                    exit();
                } elseif ($passcheck == true) {
                    session_destroy();
                    session_start();
                    $_SESSION['sessionagent'] = $row['email'];
                    $_SESSION['sessionagentId'] = $row['agent_id'];
                    $_SESSION['verified'] = $row['verified'];
                    $_SESSION['date_joined'] = $row['date_joined'];
                    header("refresh:$sec;  ./agent_profile.php?error=Logged In Successfully");
                    echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                    exit();
                }
            } else {
                header("refresh:$sec;   ./index.php?error=User Not Found");
                echo '<script type="text/javascript"> alert("User Not Found") </script>';
                exit();
            }
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionagent'])) {
        session_destroy();
        header("refresh:$sec; ../index.php?error=Logged Out");
        echo '<script type="text/javascript"> alert("You Have Successfully Logged Out") </script>';
        exit();
    } else {
        header("refresh:$sec; ../index.php");
        echo '<script type="text/javascript"> alert("You Have Successfully Logged Out") </script>';
        exit();
    }
} else {
    header("refresh:$sec;  ../index.php?error=Access Denied");
    echo '<script type="text/javascript"> alert("Access Denied") </script>';
    exit();
}
