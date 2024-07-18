<?php
// Start session
session_start();

// Connection to database
require '../../homerunphp/advertisesdb.php';
require '../../required/common_functions.php';
// API endpoint for retrieving data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $student = false;
    $chatData = [];
    $output = "";

    // Get the user ID and determine the query based on session
    if (isset($_SESSION['sessionstudent'])) {
        $user_id = $_SESSION['sessionstudent'];
        $sql = "SELECT email, home_id, firstname, lastname, status
                FROM homerunhouses
                WHERE agent_id IS NULL 
                GROUP BY email, home_id;";
        $student = true;
    } elseif (isset($_SESSION['sessionowner'])) {
        $user_id = $_SESSION['sessionowner'];
        $sql = "SELECT
    hu.email,
    hu.userid,
    hu.status,
    hu.firstname,
    hu.lastname,
    m.incoming_msg_id,
    m.outgoing_msg_id,
    hh.home_id
FROM homerunuserdb hu
JOIN messages m ON (m.incoming_msg_id = hu.userid OR m.outgoing_msg_id = hu.userid)
JOIN homerunhouses hh ON (m.incoming_msg_id = hh.home_id OR m.outgoing_msg_id = hh.home_id)
WHERE hh.home_id = '$user_id'
GROUP BY hu.email, hu.userid, hh.home_id;";
    } else {
        echo "Please Login First";
        exit();
    }

    // Execute the main query
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Check for results
    if (mysqli_num_rows($result) == 0) {
        echo $student ? "No Landlords Ready To Chat" : "No Students Ready To Chat";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $chat_id = $student ? $row['home_id'] : $row['userid'];

            // Prepare message query
            $sqlMsg = "SELECT msg, msg_id, is_read, timestamp, outgoing_msg_id
                       FROM messages
                       WHERE (incoming_msg_id = '$user_id' OR outgoing_msg_id = '$user_id')
                         AND (outgoing_msg_id = '$chat_id' OR incoming_msg_id = '$chat_id')
                       ORDER BY timestamp DESC
                       LIMIT 1";
            $resultMsg = mysqli_query($conn, $sqlMsg);

            if (!$resultMsg) {
                echo "Error: " . mysqli_error($conn);
                exit();
            }

            $rowMsg = mysqli_fetch_assoc($resultMsg);

            // Set default values if no messages found
            if ($rowMsg) {
                $resultText = $rowMsg['msg'] ?? "No Messages Available";
                $msg_id = $rowMsg['msg_id'] ?? '';
                $timestamp = $rowMsg['timestamp'] ?? 0;
                $you = ($user_id == $rowMsg['outgoing_msg_id']) ? "You: " : '';
                $msgStyle = ($rowMsg['is_read'] == 0) ? 'style="color:rgb(252,153,82)"' : '';
                $msg_date = formatTimestamp($timestamp);

            } else {
                $resultText = "No Messages Available";
                $msg_id = '';
                $timestamp = 0;
                $you = '';
                $msgStyle = '';
                $msg_date ='';
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
                                    <h2>' . htmlspecialchars(ucfirst($row['firstname']) . " " . ucfirst($row['lastname'])) . '</h2>
                                </div>
                                <div class="chat_msg" ' . $msgStyle . '>
                                    ' . htmlspecialchars($you . ucfirst($resultText)) . '
                                </div>
                            </div>
                        </div>
                        <div class="online_status">' . $div . htmlspecialchars($status) .'<br>'. $msg_date.' </div>
                    </div>
                    </div>
                  </a>'
            ];
        }

        // Sort chat data by timestamp in descending order
        usort($chatData, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        // Generate output HTML from sorted chat data
        foreach ($chatData as $chat) {
            $output .= $chat['html'];
        }

        echo $output;
    }

    // Close the connection
    mysqli_close($conn);
}
?>
