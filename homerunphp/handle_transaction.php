<?php

require '../homerunphp/advertisesdb.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Assuming this is your resultUrl endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the posted variables
    $status = $_GET['status'];
    $reference = $_GET['reference'];
    $amount = $_GET['amount'];
    $paynowReference = $_GET['paynowreference'];
    $pollurl = $_GET['pollurl'];

    // Get the current date and time
    $date = date('Y-m-d H:i:s');

    // Process the payment result

    $insert_sub = "INSERT INTO transactions (status, reference, amount, paynowreference, date, pollurl) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    // Update your system with the payment status, date, and other details
    if (!mysqli_stmt_prepare($stmt, $insert_sub)) {
        // Handle SQL error
    } else {
        mysqli_stmt_bind_param($stmt, "ssisss", $status, $reference, $amount, $paynowReference, $date, $pollurl);
        // Send a response back to PayNow
        if (mysqli_stmt_execute($stmt)) {
            // You can return a JSON response or any other suitable format
            $response = [
                'status' => 'success',
                'message' => 'Payment result received and processed successfully.',
            ];
            echo json_encode($response);
        } else {
            // You can return a JSON response or any other suitable format
            $response = [
                'status' => 'error',
                'message' => 'Failed to process payment result.',
            ];
            echo json_encode($response);
        }
    }
} else {
    // Return a "Method Not Allowed" response for non-POST requests
    http_response_code(405);
    echo 'Method Not Allowed';
}
