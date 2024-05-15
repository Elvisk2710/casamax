<?php
// api.php

// Ensure that the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit();
} else {

    // Retrieve the JSON payload from the request body
    $requestBody = file_get_contents('php://input');
    $requestData = json_decode($requestBody, true);

    // Check if the required fields are present in the request data
    if (!isset($requestData['reference']) || !isset($requestData['status']) || !isset($requestData['amount']) || !isset($requestData['paynowreference'])) {
        http_response_code(400);
        echo 'Bad Request';
        exit();
    } else {
        $userid = $requestData['userid'];
        $sub_type = $requestData['sub_type'];
        $number_of_houses = $requestData['number_of_houses'];
        $amount = $requestData['amount'];
        $uni = $requestData['uni'];

        $sql = "SELECT * FROM homerunuserdb WHERE userid = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Handle SQL error
            http_response_code(500);
            echo 'Internal Server Error';
            exit();
        } else {
            $cookiestudent = mysqli_real_escape_string($conn, $_SESSION['sessionstudent']);
            mysqli_stmt_bind_param($stmt, "s", $cookiestudent);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($results)) {
                // Retrieve the user details
                $userid = $row['userid'];
                $uni =  $row['university'];
                $email = $row['email'];

                $check_sub = "SELECT * FROM subscribers WHERE userid = ? AND completed = 0 And number_of_houses > 0";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $check_sub)) {
                    // Handle SQL error
                    http_response_code(500);
                    echo 'Internal Server Error';
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $userid);
                    mysqli_stmt_execute($stmt);
                    $sub_db_check = mysqli_stmt_get_result($stmt);

                    if (!$sub_db_check) {
                        header("Location: ../payment.php?PleaseSubscribe");
                        exit();
                    } else {
                        $rowCount = mysqli_num_rows($sub_db_check);
                        if ($rowCount > 0) {
                            header("Refresh:0.1; ../index.php?Already_Subscribed");
                            echo json_encode(['message' => 'You Are Already Subscribed!!']);
                            exit();
                        } else {
                            $this_date = date('y-m-d');
                            $start_at = strtotime(date($this_date));
                            $next = get_next_billing_date($start_at, null, $time_unit, $period);
                            $next_date = date('Y-m-d', $next);

                            $insert_sub = "INSERT INTO subscribers (date_dubscribed, package, number_of_houses, due_date, amount_paid_rtgs, userid, university) VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);

                            if (!mysqli_stmt_prepare($stmt, $insert_sub)) {
                                // Handle SQL error
                                http_response_code(500);
                                echo 'Internal Server Error';
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "sssssss", $this_date, $sub_type, $number_of_houses, $next_date, $amount, $userid, $uni);
                                if (mysqli_stmt_execute($stmt)) {
                                    header("refresh:$sec;../thank_you.php?university=" . $uni . "&firstname=" . $firstname);
                                    echo json_encode(['message' => 'You have successfully subscribed for our ' . $sub_type . ' package. ENJOY!!']);

                                    $_SESSION['sessionstudent'] = $email;
                                } else {
                                    header("Location: ../payment.php");
                                    echo json_encode(['message' => 'Sorry!! we are facing difficulties with your subscription']);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
