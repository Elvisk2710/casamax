<?php
// Start session
session_start();

// connection to database
require '../../homerunphp/advertisesdb.php';

// update_is_read.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $postData = json_decode(file_get_contents('php://input'), true);

    if (isset($_POST['sender']) && $_POST['sender'] != '' && isset($_POST['receiver']) && $_POST['receiver'] != '') {
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];

        // Perform the update query
        $sql = "UPDATE messages SET is_read = 1 WHERE (incoming_msg_id = ? OR incoming_msg_id = ?) AND (outgoing_msg_id = ? OR outgoing_msg_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $sender, $receiver, $sender, $receiver);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Message read status updated successfully."]);
        } else {
            echo json_encode(["error" => "Error updating message read status: " . $stmt->error]);
        }
    } else {
        echo json_encode(["error" => "Missing 'sender' or 'receiver' parameter in the request."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
