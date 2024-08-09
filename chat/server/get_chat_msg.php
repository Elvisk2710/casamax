<?php
session_start();
require '../../required/cors.php';
$chatMsgs = [];
require '../../required/common_functions.php';
require '../../homerunphp/advertisesdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $responseType = isset($_GET['responseType']) ? $_GET['responseType'] : 'html';

    if (isset($_SESSION['sessionstudent']) || isset($_SESSION['sessionowner']) || isset($_GET['student']) || isset($_GET['landlord'])) {
        $outgoing_id = $_GET['outgoing_id'];
        $incoming_id = $_GET['incoming_id'];

        $output = "";
        $output .= $outgoing_id;
        $sql = "SELECT * FROM messages WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id') OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id') ORDER BY msg_id ASC";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $msg_time = formatTimestamp($row['timestamp']);
                if ($responseType != 'json') {
                    if ($row['outgoing_msg_id'] === $outgoing_id) { //if this is equal to the outgoing then he is the sender
                        $output .= '
                    <div class="outgoing_message_container">
                        <div class="outgoing_message"> ' . html_entity_decode($row['msg']) . '
                            <div class="msg_time">
                                ' . $msg_time . '
                            </div>
                        </div>
                    </div>
                    ';
                    } else { //he is the msg receiver
                        if ($row['is_read'] == 0) {
                            updateIsRead($row['msg_id']);
                        }
                        $output .= '
                    <div class="incoming_message_container">
                        <div class="incoming_message">' . html_entity_decode($row['msg']) . '
                            <div class="msg_time">
                                ' . $msg_time . '
                            </div>
                        </div>
                    </div>
                    ';
                    }
                } else {
                    $chatMsgBubble = new ChatBubbleMessage($row['msg_id'], $row['outgoing_msg_id'], $row['incoming_msg_id'], html_entity_decode($row['msg']), $row['timestamp']);
                    array_push($chatMsgs, $chatMsgBubble);
                }
            }
            if ($responseType === 'json') {
                header('Content-Type: application/json');
                echo json_encode([
                    'chats' => $chatMsgs,
                    'format' => $responseType,
                    'status' => 'success',
                ]);
            } else {
                echo $output;
            }
        } else {
            sendErrorResponse($responseType, 'No messages found.',$output);
        }
    } else {
        sendErrorResponse($responseType, 'User not authenticated.',$output);
    }
}

function updateIsRead($msg_id)
{
    include '../../homerunphp/advertisesdb.php';
    $sql = "UPDATE messages SET is_read = 1 WHERE msg_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $msg_id);
    $stmt->execute();
}

function sendErrorResponse($responseType, $message,$output)
{
    if ($responseType === 'json') {
        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'error',
            'error' => $message,
        ]);
    } else {
        header("location: ../screens/index.php");
        echo $output;
    }
    exit();
}
