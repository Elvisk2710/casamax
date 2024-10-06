<?php
session_start();
require_once '../Paynow-PHP-SDK-master/autoloader.php';
require '../homerunphp/advertisesdb.php';
$paynow = new Paynow\Payments\Paynow(
    '15123',
    '6e65b63a-6da2-4685-a277-855713f19af1',
    'http://example.com/gateways/paynow/update',
    'http://example.com/return?gateway=paynow'
);

$invoice_name = "Casamax Invoice " . time();
$user_id = filter_var($_SESSION['sessionowner'], FILTER_SANITIZE_EMAIL);

$sql = "SELECT * FROM homerunhouses WHERE home_id = $user_id";

$result = mysqli_query($conn, $sql);
if ($row = mysqli_fetch_assoc($result)) {
    $user_email = $row['email'];
}

$paynow->setResultUrl('https://casamax.co.zw/homerunphp/handle_transaction.php');

$payment = $paynow->createPayment($invoice_name, $user_email);
$payment->add($sub_type, $amount);
$payment->add($user_email); // Include email as part of the item description

    $response = $paynow->send($payment);

    if ($response->success()) {
        $redirectUrl = $response->redirectUrl();
        $pollUrl = $response->pollUrl();

        // Redirect the user to the Paynow payment page
        header("Location: $redirectUrl");

        // Use a background process to poll the transaction status
        $transactionStatus = pollTransactionStatus($paynow, $pollUrl);

        if ($transactionStatus['paid']) {
            setcookie("success", "true", time() + (8600 * 1), "/", "", true, true);
            $_SESSION['payment_status'] = "success";
            require_once 'payment_btn_content.php';
        } else {
            setcookie("success", "false", time() + (8600 * 1), "/", "", true, true);
            $_SESSION['payment_status'] = "failed";
        }
    } else {
        $errorMessage = $response->errors();
        error_log($errorMessage);
        header('location: ../payment.php?error=' . urlencode($errorMessage) . '&success=false');
        setcookie("success", "false", time() + (8600 * 1), "/", "", true, true);
        $_SESSION['payment_status'] = "failed";
        exit('<script>alert("Transaction failed: ' . $errorMessage . '");</script>');
    }

function pollTransactionStatus($paynow, $pollUrl)
{
    $timeout = 30;
    $count = 0;
    $success = false;

    while (!$success) {
        sleep(1);
        $status = $paynow->pollTransaction($pollUrl);

        if ($status->paid()) {
            $success = true;
            return ['paid' => true];
        }

        $count++;

        if ($count > $timeout) {
            $errorMessage = "Transaction Timeout Reached";
            error_log($errorMessage);
            return ['paid' => false, 'error' => $errorMessage];
        }
    }
}
