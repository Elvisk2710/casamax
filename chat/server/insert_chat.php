<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['sessionstudent']) || isset($_SESSION['sessionowner'])) {
        include '../../homerunphp/advertisesdb.php';
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $created_at = date('Y-m-d H:i:s'); // Format the date and time
        $is_read = 0; // Set the is_read column to 0 (unread)
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, created_at, is_read) VALUES ('{$incoming_id}', '{$outgoing_id}', '{$message}', '{$created_at}', '{$is_read}')");
    }
} else {
    header("location: ../screens/login.php");
}
