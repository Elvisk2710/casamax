<?php
session_start();

require_once '../Paynow-PHP-SDK-master/autoloader.php';

function checkPaymentStatus($pollUrl)
{
    // Send a GET request to the pollUrl using cURL or any other HTTP library of your choice
    $ch = curl_init($pollUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Parse the response
    $responseData = json_decode($response, true);

    return $responseData;
}

$paynow = new Paynow\Payments\Paynow(
    '15123',
    '6e65b63a-6da2-4685-a277-855713f19af1',
    'http://example.com/gateways/paynow/update',
    'http://example.com/return?gateway=paynow',
);

$invoice_name = "Casamax Invoice " . time();
$user_email = filter_var($_SESSION['sessionstudent'], FILTER_SANITIZE_EMAIL);

# $paynow->setResultUrl('');
# $paynow->setReturnUrl('');

$payment = $paynow->createPayment($invoice_name, $user_email);


$payment->add($sub_type, $amount);
$payment->add($user_email); // Include email as part of the item description

$response = $paynow->send($payment);


if ($response->success()) {
    var_dump($response);
    // Get the redirect URL and poll URL from the response
    $redirectUrl = $response->redirectUrl();
    $pollUrl = $response->pollUrl();

    // Redirect the user to the Paynow payment page
    header("Location: $redirectUrl");
    // Check the status of the transaction
    $paymentStatus = checkPaymentStatus($pollUrl);

    $timeout = 20;
    $count = 0;
    $success = false;

    while ($success == false) {
        sleep(2);
        $status = $paynow->pollTransaction($pollUrl);

        // Check if paid
        if ($status->paid()) {
            $success = true;
            setcookie("success", "true", time() + (8600 * 1), "/", "", true, true);
            $_SESSION['payment_status'] = "success";
            // require_once 'payment_btn_content.php';
        }

        $count++;

        if ($count > $timeout) {
            // header('location: ../payment.php?error=TransactionTimeoutReached&success=false');
            exit('<script>alert("Transaction Timeout Reached");</script>');
        }
    }
} else {
    var_dump($response);
    // header('location: ../payment.php?success=false');
    setcookie("success", "false", time() + (8600 * 1), "/", "", true, true);
    $_SESSION['payment_status'] = "failed";
    exit('<script>alert("Transaction failed");</script>');
}
