<?php
// Start session
session_start();

// connection to databse
require '../../homerunphp/advertisesdb.php';

// update_is_read.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);

    if (isset($postData['msg_id']) && $postData['msg_id'] != '') {
        $msg_id = $postData['msg_id'];
        echo "Received msg_id: " . $msg_id . "\n";
        // Perform the update query with the $msg_id
        $sql = "UPDATE messages SET is_read = 1 WHERE msg_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $msg_id);
        if ($stmt->execute()) {
            echo "Message read status updated successfully.";
        } else {
            echo "Error updating message read status: " . $stmt->error;
        }
    } else {
        echo "Missing 'msg_id' parameter in the request.";
    }
} else {
    echo "Invalid request method.";
}
