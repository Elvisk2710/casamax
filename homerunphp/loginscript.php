<?php
session_start();
$sec = "0.1";

if (isset($_POST['submit'])) {
    require 'homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM homerunuserdb WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                $passcheck = password_verify($password, $row['passw']);

                if ($passcheck == false) {
                    header("Location: ../login.php?error=wrongpass");
                    exit();
                } elseif ($passcheck == true) {
                    $email = $row['email'];
                    $userid = $row['userid'];
                    $uni = $row['university'];

                    // Check if the user is subscribed
                    $sub_check = "SELECT * FROM subscribers WHERE user_id = ?";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sub_check)) {
                        header("Location: ../login.php?error=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $userid);
                        mysqli_stmt_execute($stmt);
                        $sub_db_check = mysqli_stmt_get_result($stmt);
                        $rowCount = mysqli_num_rows($sub_db_check);

                        if (!$rowCount > 0) {
                            setcookie("cookiestudent", $userid, time() + (86400 * 1), "/");
                            setcookie("emailstudent", $email, time() + (86400 * 1), "/");
                            $_SESSION['sessionstudent'] = $email;
                            header("Location: ../payment.php?subscribe");
                            exit();
                        } else {
                            $results = mysqli_fetch_array($sub_db_check);
                            $today = strtotime(date('y-m-d'));

                            if (strtotime($results['due_date']) < $today) {
                                $sub_check = "DELETE FROM subscribers WHERE userid = ?";
                                $stmt = mysqli_stmt_init($conn);

                                if (mysqli_stmt_prepare($stmt, $sub_check)) {
                                    mysqli_stmt_bind_param($stmt, "s", $userid);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../payment.php?subscription has ended");
                                    exit();
                                } else {
                                    header("Location: ./index.php?error=sqlerror");
                                    exit();
                                }
                            } else {
                                $_SESSION['sessionstudent'] = $email;

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
                                    header("Location: $redirectUrl?success=" . $email);
                                    exit();
                                }
                            }
                        }
                    }
                } else {
                    header("Location: ../login.php?error=wrongpass");
                    exit();
                }
            } else {
                header("Location: ../login.php?error=UserNotFound");
                exit();
            }
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionstudent'])) {
        session_destroy();
    }
    header("Location: ../index.php?error=LoggedOut");
    exit();
}
