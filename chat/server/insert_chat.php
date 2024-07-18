<?php
session_start();
require '../../required/common_functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['sessionstudent']) || isset($_SESSION['sessionowner'])) {
        include '../../homerunphp/advertisesdb.php';
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $outgoing_id = sanitize_string($outgoing_id);

        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $incoming_id = sanitize_string($incoming_id);

        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $message = sanitize_string($message);

        $is_read = 0; // Set the is_read column to 0 (unread)
        $current_timestamp = time();
        $mysql_timestamp = date('Y-m-d H:i:s', $current_timestamp);
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, timestamp, is_read) VALUES ('{$incoming_id}', '{$outgoing_id}', '{$message}', '{$mysql_timestamp}', '{$is_read}')");
    }
} else {
    header("location: ../screens/login.php");
}
