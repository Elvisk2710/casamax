<?php
session_start();
require '../../required/common_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the response type from the request
    $responseType = isset($_GET['responseType']) ? $_GET['responseType'] : 'html';

    if (isset($_SESSION['sessionstudent']) || isset($_SESSION['sessionowner']) || $_GET['mobile_api'] == true) {
        require '../../homerunphp/advertisesdb.php';
        echo $_SESSION['sessionowner'];
        echo $_SESSION['sessionstudent'];
        echo $_GET['mobile_api'];

        $outgoing_id = sanitize_string($_POST['outgoing_id']);
        $incoming_id = sanitize_string($_POST['incoming_id']);
        $message = sanitize_string(mysqli_real_escape_string($conn, $_POST['message']));

        $is_read = 0;
        $current_timestamp = time();
        $mysql_timestamp = date('Y-m-d H:i:s', $current_timestamp);

        if ($outgoing_id != null || $outgoing_id != '' || $incoming_id != null || $incoming_id != '') {
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, timestamp, is_read) 
                VALUES ('{$incoming_id}', '{$outgoing_id}', '{$message}', '{$mysql_timestamp}', '{$is_read}')";

            if (mysqli_query($conn, $sql)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'error' => mysqli_error($conn)]);
            }
        }else{
            if ($responseType === 'json') {
                header('Content-Type: application/json');
                echo json_encode([
                    'message' => 'error',
                    'error' => 'Invalid Inputs',
                ]);
            } else {
                header("location: ../screens/index.php?error=Invalid Inputs");
            }
            exit();
        }
    } else {
        if ($responseType === 'json') {
            header('Content-Type: application/json');
            echo json_encode([
                'message' => 'error',
                'error' => $message,
            ]);
        } else {
            header("location: ../screens/index.php");
        }
        exit();
    }
} else {
    echo json_encode([
        'message' => 'error',
        'error' => 'Not a valid request',
    ]);
}
