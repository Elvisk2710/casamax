<?php
$sql = "SELECT * FROM homerunuserdb WHERE userid = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    // Handle SQL error
    redirect('../profile.php?error=SQL Error');
} else {
    mysqli_stmt_bind_param($stmt, "s", $home_id);
    mysqli_stmt_execute($stmt);
    $results = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($results)) {

        $userid = $row['home_id'];
        $email = $row['email'];
        $check_sub = "SELECT * FROM subscribers WHERE home_id = ? AND subscription_status != done";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $check_sub)) {
            // Handle SQL error
            redirect('../payment.php?error=SQL Error');
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
                    redirect('../index.php?errorAlready Subscribed');
                } else {
                    $this_date = date('y-m-d');
                    $start_at = strtotime(date($this_date));
                    $next = get_next_billing_date($start_at, null, $time_unit, $period);
                    $next_date = date('Y-m-d', $next);

                    $insert_sub = "INSERT INTO subscribers (subscription_date, subsctiption_package, expiry_date, home_id,subscription_status) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $insert_sub)) {
                        // Handle SQL error
                        redirect('../payment.php?error=SQL Error');
                    } else {
                        mysqli_stmt_bind_param($stmt, "sssssss", $this_date, $sub_type, $next_date, $userid, $uni);
                        if (mysqli_stmt_execute($stmt)) {
                            header("refresh:$sec;../thank_you.php?university=" . $uni . "&firstname=" . $firstname);
                            redirect(`../thank_you.php?sub_tyoe={$sub_type}&next_date={$next_date}`);
                            $_SESSION['sessionowner'] = $userid;
                        } else {
                            redirect('../payment.php?error=Failed To Process Transaction');
                        }
                    }
                }
            }
        }
    }
}
