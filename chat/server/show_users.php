<?php
// Start session
session_start();
// require cors
require '../../required/cors.php';
// Connection to database
require '../../homerunphp/advertisesdb.php';
require '../../required/common_functions.php';

// API endpoint for retrieving data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $student = false;
    $chatData = [];
    $output = "";
    $sender = null;
    $receiver = null;
    $chats = [];
    $firstname = '';
    $lastname = '';

    // Get the response type from the request
    $responseType = isset($_GET['responseType']) ? $_GET['responseType'] : 'html';

    // Get the search query from the request
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

    // Get the user ID and determine the query based on session
    if (isset($_SESSION['sessionstudent']) || isset($_GET['student'])) {
        // $user_id = $_SESSION['sessionstudent'];
        if (isset($_SESSION['sessionstudent'])) {
            $user_id = $_SESSION['sessionstudent'];
        }  elseif(isset($_GET['student'])) {
            $user_id = $_GET['student'];
        }
        $sql = "SELECT email, home_id, firstname, lastname, status
                FROM homerunhouses
                WHERE (agent_id IS NULL OR agent_id = '') 
                AND (firstname LIKE '%$searchQuery%' OR lastname LIKE '%$searchQuery%')
                GROUP BY email, home_id;";
        $student = true;
    } elseif (isset($_SESSION['sessionowner'])  || isset($_GET['landlord'])) {
        if (isset($_SESSION['sessionowner'])) {
            $user_id = $_SESSION['sessionowner'];
        } elseif(isset($_GET['landlord'])) {
            $user_id = $_GET['landlord'];
        }
        $sql = "SELECT hu.email, hu.userid, hu.status, hu.firstname, hu.lastname, m.incoming_msg_id, m.outgoing_msg_id, hh.home_id
                FROM homerunuserdb hu
                JOIN messages m ON (m.incoming_msg_id = hu.userid OR m.outgoing_msg_id = hu.userid)
                JOIN homerunhouses hh ON (m.incoming_msg_id = hh.home_id OR m.outgoing_msg_id = hh.home_id)
                WHERE hh.home_id = '$user_id'
                AND (hu.firstname LIKE '%$searchQuery%' OR hu.lastname LIKE '%$searchQuery%')
                GROUP BY hu.email, hu.userid, hh.home_id;";
    } else {
        $errorMessage = mysqli_error($conn);
        if ($responseType == 'json') {
            echo json_encode(['message' => "No Auth Provided"]);
            exit();
        } else {
            echo "Please Login First";
            exit();
        }
    }

    // Execute the main query
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $errorMessage = mysqli_error($conn);
        if ($responseType == 'json') {
            echo json_encode(['message' => $errorMessage]);
            exit();
        } else {
            echo "Error: " . $errorMessage;
            exit();
        }
    }

    // Check for results
    $number_of_chats = mysqli_num_rows($result);
    if ($number_of_chats == 0) {
        $errorMessage = $student ? "Sorry Couldn't Find Landlords Ready To Chat" : "Please wait patiently whilst students find you.";
        if ($responseType == 'json') {
            echo json_encode(['message' => $errorMessage]);
        } else {
            echo $errorMessage;
        }
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $chat_id = $student ? $row['home_id'] : $row['userid'];
            $firstname = htmlspecialchars(ucfirst($row['firstname']));
            $lastname = htmlspecialchars(ucfirst($row['lastname']));
            // Prepare message query
            $sqlMsg = "SELECT msg, msg_id, is_read, timestamp, outgoing_msg_id
                       FROM messages
                       WHERE (incoming_msg_id = '$user_id' OR outgoing_msg_id = '$user_id')
                         AND (outgoing_msg_id = '$chat_id' OR incoming_msg_id = '$chat_id')
                       ORDER BY timestamp DESC
                       LIMIT 1";

            $resultMsg = mysqli_query($conn, $sqlMsg);

            if (!$resultMsg) {
                $errorMessage = mysqli_error($conn);
                if ($responseType == 'json') {
                    echo json_encode(['message' => $errorMessage]);
                    exit();
                } else {
                    echo "Error: " . $errorMessage;
                    exit();
                }
            }

            $rowMsg = mysqli_fetch_assoc($resultMsg);

            // Set default values if no messages found
            if ($rowMsg) {
                $resultText = $rowMsg['msg'] ?? "Start A Conversation...";
                $msg_id = $rowMsg['msg_id'] ?? '';
                $timestamp = $rowMsg['timestamp'] ?? 0;
                $isRead = $rowMsg['is_read'] ?? 0;
                if ($user_id == $rowMsg['outgoing_msg_id']) {
                    $you = "You: ";
                    $sender = $user_id;
                    $receiver = $chat_id;
                } else {
                    $you = "";
                    $sender = $chat_id;
                    $receiver = $user_id;
                }
                $msgStyle = ($rowMsg['is_read'] == 0) ? 'style="color:rgb(252,153,82)"' : '';
                $msg_date = formatTimestamp($timestamp);
            } else {
                $resultText = "";
                $msg_id = '';
                $timestamp = 0;
                $you = '';
                $msgStyle = '';
                $msg_date = '';
                $sender = null;
                $receiver = null;
                $isRead = 0;
            }

            // Trim the message if it is longer than 28 characters
            if (strlen($resultText) > 28) {
                $resultText = substr($resultText, 0, 28) . '....';
            }

            $offline = ($row['status'] == "offline");
            $status = $offline ? "offline" : "online";
            $div = $offline ? '<div class="online_status_icon offline">' : '<div class="online_status_icon">';

            // Add chat data to the array
            $chatData[] = [
                'timestamp' => $timestamp,
                'html' => '
                  <a onclick="updateRead(this)" data-msg-id="' . $msg_id . '" href="./chat_dm.php?chat_id=' . $chat_id . '&student=' . $student . '">
                    <div class="chat_element_container">
                        <div class="chat_details">
                            <div class="chat_img">
                                <img src="../../images/profile_icon.png" alt="">
                            </div>
                            <div class="chat_info">
                                <div class="chat_name">
                                    <h2>' . $firstname . " " . $lastname . '</h2>
                                </div>
                                <div class="chat_msg" ' . $msgStyle . '>
                                    ' . htmlspecialchars($you . ucfirst($resultText)) . '
                                </div>
                            </div>
                        </div>
                        <div class="online_status">' . $div . '<br>' . $msg_date . ' </div>
                    </div>
                    </div>
                  </a>'
            ];
            $chatMsg = new ChatMessage(
                $chat_id,
                $sender,
                $receiver,
                $resultText,
                $timestamp,
                $firstname,
                $lastname,
                $msg_id,
                $isRead,
            );
            array_push($chats, $chatMsg);
        }
        // Sort chat data by timestamp in descending order
        usort($chatData, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        // Generate output HTML from sorted chat data
        foreach ($chatData as $chat) {
            $output .= $chat['html'];
        }

        // Check response type and return the appropriate response
        if ($responseType === 'json') {
            header('Content-Type: application/json');
            echo json_encode([
                'chats' => $chats,
                'numberOfChats' => $number_of_chats,
                'format' => $responseType
            ]);
        } else {
            echo $output;
        }
    }

    // Close the connection
    mysqli_close($conn);
}
