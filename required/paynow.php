<?php
try {
    // Validate and sanitize phone number
    $phone = $_POST["phone_number"];
    if (!preg_match('/^\d{10}$/', $phone)) {
        // Handle invalid phone number
        exit('Invalid phone number');
    } else {

        $platform = "";

        require_once '../Paynow-PHP-SDK-master/autoloader.php';

        $paynow = new Paynow\Payments\Paynow(
            '13433',
            'c7852d9f-43a5-4f97-8c83-efdc792be295',
            'http://example.com/gateways/paynow/update',
            'http://example.com/return?gateway=paynow'
        );

        $invoice_name = "Casamax Invoice " . time();
        $user_email = filter_var($_COOKIE['emailstudent'], FILTER_SANITIZE_EMAIL);

        if (!$payment = $paynow->createPayment($invoice_name, 'casamaxzim@gmail.com')) {
            exit('<script>alert("Failed to connect to Paynow Connection Time-Out");</script>');
        } else {
            $payment->add($sub_type, $amount);

            // Detect platform and send payment
            if (str_starts_with($phone, '071')) {
                $platform = "onemoney";
            } else if (str_starts_with($phone, '073')) {
                $platform = "telecash";
            } else {
                $platform = "ecocash";
            }

            if (!$response = $paynow->sendMobile($payment, $phone, $platform)) {
                exit('<script>alert("Failed to send SSD");</script>');
            } else {
                if ($response->success()) {
                    $pollUrl = $response->pollUrl();

                    // Listen to status update changes using AJAX after test
                    $timeout = 9;
                    $count = 0;
                    $success = false;
                    $status = $paynow->pollTransaction($pollUrl);

                    while ($success == false) {
                        sleep(3);
                        $status = $paynow->pollTransaction($pollUrl);

                        // Check if paid
                        if ($status->paid()) {
                            $success = true;
                            setcookie("success", "true", time() + (8600 * 1), "/", "", true, true);
                            $_SESSION['payment_status'] = "success";
                            require_once 'payment_btn_content.php';
                        }

                        $count++;

                        if ($count > $timeout) {
                            header('location: ../payment.php?error=TransactionTimeoutReached&success=false');
                            exit('<script>alert("Transaction Timeout Reached");</script>');
                        }
                    }
                } else {
                    header('location: ../payment.php?success=false');
                    setcookie("success", "true", time() + (8600 * 1), "/", "", true, true);
                    $_SESSION['payment_status'] = "success";
                    require_once 'payment_btn_content.php';
                    exit('<script>alert("Transaction failed");</script>');
                }
            }
        }
    }
} catch (Exception $ex) {
    // Log the error
    error_log('Failed to connect to PayNow: ' . $ex->getMessage());

    // Display a generic error message to the user
    header("location: ../payment.php?error=FailedToConnectToPayNow");
    exit;
}
