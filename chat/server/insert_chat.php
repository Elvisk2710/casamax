<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION['sessionstudent']) || isset($_SESSION['sessionowner'])) {
        include '../../homerunphp/advertisesdb.php';
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        if (!empty($message)) {
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id,outgoing_msg_id,msg) VALUES ('{$incoming_id}','{$outgoing_id}','{$message}')") or die();
        }
    } else {
        header("location: ../screens/login.php");
    }
}
