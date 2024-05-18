<?php
$sql = "SELECT * FROM homerunuserdb WHERE userid = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    // Handle SQL error
    exit('<script type="text/javascript"> alert("SQL ERROR") </script>');
} else {
    $cookiestudent = mysqli_real_escape_string($conn, $_COOKIE['cookiestudent']);
    mysqli_stmt_bind_param($stmt, "s", $cookiestudent);
    mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($results)) {

        $userid = $row['userid'];
        $uni =  $row['university'];
        $email = $row['email'];
        $check_sub = "SELECT * FROM subscribers WHERE userid = ? AND completed = 0";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $check_sub)) {
            // Handle SQL error
            exit('<script type="text/javascript"> alert("SQL ERROR") </script>');
        } else {
            mysqli_stmt_bind_param($stmt, "s", $userid);
            mysqli_stmt_execute($stmt);
            $sub_db_check = mysqli_stmt_get_result($stmt);

            if (!$sub_db_check) {
                header("Location: ../payment.php?Please Subscribe");
                exit();
            } else {
                $rowCount = mysqli_num_rows($sub_db_check);
                if ($rowCount > 0) {
                    header("Refresh:0.1; ../index.php?Already_Subscribed");
                    echo '<script type="text/javascript"> alert("You Are Already Subscribed!!") </script>';
                } else {
                    $this_date = date('y-m-d');
                    $start_at = strtotime(date($this_date));
                    $next = get_next_billing_date($start_at, null, $time_unit, $period);
                    $next_date = date('Y-m-d', $next);

                    $insert_sub = "INSERT INTO subscribers (date_dubscribed, package, number_of_houses, due_date, amount_paid_rtgs, userid, university) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $insert_sub)) {
                        // Handle SQL error
                        exit('<script type="text/javascript"> alert("SQL ERROR") </script>');
                    } else {
                        mysqli_stmt_bind_param($stmt, "sssssss", $this_date, $sub_type, $number_of_houses, $next_date, $amount, $userid, $uni);
                        if (mysqli_stmt_execute($stmt)) {
                            header("refresh:$sec;../thank_you.php?university=" . $uni . "&firstname=" . $firstname);
                            echo '<script type="text/javascript"> alert("You have successfully subscribed for our ' . $sub_type . ' package. ENJOY!!") </script>';

                            $_SESSION['sessionstudent'] = $email;
                        } else {
                            header("Location: ../payment.php");
                            echo '<script type="text/javascript"> alert("Sorry!! We Are facing Difficulties With Your Subscription") </script>';
                        }
                    }
                }
            }
        }
    }
}