<?php
session_start();

require_once '../Paynow-PHP-SDK-master/autoloader.php';

$paynow = new Paynow\Payments\Paynow(
    '15123',
    '6e65b63a-6da2-4685-a277-855713f19af1',
    'http://example.com/gateways/paynow/update',
    'http://example.com/return?gateway=paynow',
);

$invoice_name = "Casamax Invoice " . time();
$user_email = filter_var($_SESSION['sessionstudent'], FILTER_SANITIZE_EMAIL);

$paynow->setResultUrl('https://localhost/casamax/homerunphp/handle_transaction.php');
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

    $timeout = 30;
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
            require_once 'payment_btn_content.php';
        }

        $count++;

        if ($count > $timeout) {
            header('location: ../payment.php?error=Transaction TimeOut Reached&success=false');
            exit('<script>alert("Transaction Timeout Reached");</script>');
        }
    }
} else {
    var_dump($response);
    header('location: ../payment.php?success=false');
    setcookie("success", "false", time() + (8600 * 1), "/", "", true, true);
    $_SESSION['payment_status'] = "failed";
    exit('<script>alert("Transaction failed");</script>');
}
