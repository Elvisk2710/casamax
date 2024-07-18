<?php
session_start();
$sec = "0.1";
require 'homerunuserdb.php';
include '../required/alerts.php';

if (isset($_POST['submit'])) {
    if (isset($_GET['redirect'])) {
        $redirect = $_GET['redirect'];
    }
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) || empty($password)) {
        redirect("../login.php?error=All Fields Are Required");
        exit();
    } else {
        $sql = "SELECT * FROM homerunuserdb WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            redirect("../login.php?error=Sorry SQL Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $passcheck = password_verify($password, $row['passw']);

                if ($passcheck == false) {
                    redirect("../login.php?error=Sorry Wrong Password!!");
                    exit();
                } elseif ($passcheck == true) {
                    $email = $row['email'];
                    $userid = $row['userid'];
                    $uni = $row['university'];
                    session_destroy();
                    session_start();
                    $_SESSION['sessionstudent'] = $userid;

                    // Check if the user is subscribed
                    $sub_check = "SELECT * FROM subscribers WHERE user_id = ?";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sub_check)) {
                        redirect("../login.php?error=Sorry SQL Error");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $userid);
                        mysqli_stmt_execute($stmt);
                        $sub_db_check = mysqli_stmt_get_result($stmt);
                        $rowCount = mysqli_num_rows($sub_db_check);

                        if (!$rowCount > 0) {
                            setcookie("cookiestudent", $userid, time() + (86400 * 1), "/");
                            setcookie("emailstudent", $email, time() + (86400 * 1), "/");
                            redirect("../payment.php?error=Please Subscribe");
                            exit();
                        } else {
                            $results = mysqli_fetch_array($sub_db_check);
                            $today = strtotime(date('y-m-d'));
                            if (strtotime($results['due_date']) < $today || $results['number_of_houses'] == 0 || $results['completed'] == 1) {
                                redirect("../payment.php?error=Subscription Has Ended");
                            } else {
                                // Redirect based on university
                                $universityMapping = array(
                                    "University of Zimbabwe" => "../unilistings/uzlisting.php",
                                    "Midlands State University" => "../unilistings/msulisting.php",
                                    "Africa University" => "../unilistings/aulisting.php",
                                    "Bindura State University" => "../unilistings/bsulisting.php",
                                    "Chinhoyi University of Science and Technology" => "../unilistings/cutlisting.php",
                                    "Great Zimbabwe University" => "../unilistings/gzlisting.php",
                                    "Harare Institute of Technology" => "../unilistings/hitlisting.php",
                                    "National University of Science and Technology" => "../unilistings/nustlisting.php"
                                );

                                if (array_key_exists($uni, $universityMapping)) {
                                    $redirectUrl = $universityMapping[$uni];
                                    if ($redirect == "chat") {
                                        redirect("../chat/screens/index.php?error=You Have Logged In Successfully");
                                    } else {
                                        redirect($redirectUrl . "?error=You Have Logged In Successfully");
                                    }
                                    exit();
                                }
                            }
                        }
                    }
                } else {
                    redirect("../login.php?error=Wrong Password");
                    exit();
                }
            } else {
                redirect("../login.php?error=Sorry, User Not Found");
                exit();
            }
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionstudent'])) {
        session_destroy();
    }
    redirect("../index.php?error=Logged Out");
    exit();
}
?>
