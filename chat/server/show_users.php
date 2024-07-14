<?php
// Start session
session_start();

// connection to databse
require '../../homerunphp/advertisesdb.php';

// API endpoint for retrieving data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $student = false;
    $output = "";
    $chat_id = "";
    $you = '';
    $countMsg = '';
    $msgStyle = '';
    // Get the parameters from the query string
    if (isset($_SESSION['sessionstudent'])) {
        $user_id = $_SESSION['sessionstudent'];
        $sql = "SELECT email, home_id, firstname, lastname, status, admin_id, agent_id
                FROM homerunhouses
                WHERE (agent_id IS NULL AND admin_id IS NULL)
                GROUP BY email, home_id;";
        $student = true;
    } elseif (isset($_SESSION['sessionowner'])) {
        $user_id = $_SESSION['sessionowner'];
        $sql = "SELECT 
                email,userid,status,firstname,lastname, m.incoming_msg_id,m.outgoing_msg_id , t.home_id
                FROM homerunuserdb h 
                INNER JOIN 
                (SELECT home_id FROM homerunhouses) t 
                JOIN messages m 
                WHERE (t.home_id = m.incoming_msg_id OR h.userid = m.incoming_msg_id) AND (h.userid = m.outgoing_msg_id OR t.home_id = m.outgoing_msg_id)
                GROUP BY email, userid;";
    } else {
        $user_id = null;
        $output .= "Please Login First";
        exit();
    }



    $result = mysqli_query($conn, $sql);
    // Prepare and execute the SQL statement
    if (mysqli_num_rows($result) == 0) {
        if ($student == false) {
            $output .= "No Students Ready To Chat";
        } else {
            $output .= "No Landlords Ready To Chat";
        }
    } else {

        while ($row = mysqli_fetch_assoc($result)) {
            if ($student == true) {
                $chat_id = $row['home_id'];
            } else {
                $chat_id =  $row['userid'];
            }
            $sqlMsg = "SELECT * 
            FROM messages
            WHERE (incoming_msg_id = '{$user_id}' OR outgoing_msg_id = '{$user_id}') 
              AND (outgoing_msg_id = '{$chat_id}' OR incoming_msg_id = '{$chat_id}')
            ORDER BY msg_id DESC
            LIMIT 1";

            $resultMsg = mysqli_query($conn, $sqlMsg);
            $rowMsg = mysqli_fetch_assoc($resultMsg);
            if (mysqli_num_rows($resultMsg) > 0) {
                $resultText = $rowMsg['msg'];
                $msg_id = $rowMsg['msg_id'];
                if ($user_id == $rowMsg['outgoing_msg_id']) {
                    $you = "You: ";
                }
                // check if message is read
                if ($rowMsg['is_read'] == 0) {
                    $countMsg = '
                <div class="msg_count">
                    
                </div>';
                    $msgStyle = 'style = "color:rgb(252,153,82)"';
                } 
            } else {
                $resultText = "No Messages Available";
                $msg_id = '';
                $countMsg = '';
                $msgStyle = '';

            }
            if (strlen($resultText) > 28) {
                $msg = substr($resultText, 0, 28) . '....';
            } else {
                $msg = $resultText;
            }



            // trimming message if the words are more than 28
            $offline = false;
            if ($row['status'] == "offline") {
                $offline = true;
                $status = $row['status'];
                $div = '<div class="online_status_icon offline">';
            } else {
                $offline = false;
                $status = $row['status'];
                $div = '<div class="online_status_icon">';
            }
            $output .= '
                  <a onclick="updateRead(this)" data-msg-id="' . $msg_id . '"href="./chat_dm.php?chat_id=' . $chat_id . '&student=' . $student . '">
                    <div class="chat_element_container" >
                        <div class="chat_details">
                            <div class="chat_img">
                                <img src="../../images/profile_icon.png" alt="">
                            </div>
                            <div class="chat_info">
                                <div class="chat_name">
                                    <h2>
                                        ' . $row['firstname'] . " " . $row['lastname'] . '
                                    </h2>
                                </div>
                                <div class="chat_msg" ' . $msgStyle . '>
                                    ' . $you . $msg . '
                                </div>
                            </div>
                        </div>
                        <div class="online_status">' .
                $div
                . '
                                ' . $status . '
                                 ' . $countMsg . '
                            </div>
                           
                        </div>
                    </div>
                </a>
            ';
        }
    }

    echo $output;
}

$conn->close();
