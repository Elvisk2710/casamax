<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_SESSION['sessionstudent']) || isset($_SESSION['sessionowner'])) {
        include '../../homerunphp/advertisesdb.php';
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

        $output = "";
        $sql = "SELECT * FROM messages WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id') OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id') ORDER BY msg_id ASC";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['outgoing_msg_id'] === $outgoing_id) { //if this is equal to the ougoing then he is the sender
                    $output .= '
                    <div class="outgoing_message_container">
                        <div class="outgoing_message">
                                ' . $row['msg'] . '
                        </div>
                    </div>
                    ';
                } else { //he is the msg receiver

                    $output .= '
                    <div class="incoming_message_container">
                        <div class="incoming_message">
                                ' . $row['msg'] . '
                        </div>
                    </div>
                    ';
                }
            }
            echo $output;
        }
    } else {
        header("location: ../screens/login.php");
    }
}
