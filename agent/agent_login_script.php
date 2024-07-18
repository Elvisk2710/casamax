<?php
session_start();
require '../required/alerts.php';

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
            redirect('./index.php?error=Sql Error Prepare Failed');
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {

                $passcheck = password_verify($password, $row['passw']);

                if ($passcheck == false) {
                    redirect('./index.php?error=Wrong Password');
                } elseif ($passcheck == true) {
                    session_destroy();
                    session_start();
                    $_SESSION['sessionagent'] = $row['agent_id'];
                    $_SESSION['verified'] = $row['verified'];
                    $_SESSION['date_joined'] = $row['date_joined'];
                    redirect('./agent_profile.php?error=Logged In Successfully');
                }
            } else {
                redirect('./index.php?error=User Not Found');
            }
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionagent'])) {
        session_destroy();
        redirect('../index.php?error=Logged Out Successfully');
    } else {
        redirect('./index.php?error=You Have Successfully Logged Out');
    }
} else {
    redirect('../index.php?error=Access Denied');

}
