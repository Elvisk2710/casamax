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
    // Get the parameters from the query string
    if (isset($_SESSION['sessionstudent'])) {
        $user_id = $_SESSION['sessionstudent'];
        $sql = "SELECT email, home_id,firstname,lastname, status
        FROM homerunhouses
        WHERE agent_id = '' OR admin_id = '' GROUP BY email, home_id";
         $student = true;
    } elseif (isset($_SESSION['sessionowner'])) {
        $user_id = $_SESSION['sessionowner'];
        $sql = "SELECT DISTINCT email,userid,status FROM homerunuserdb ";
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

            } else {
                $resultText = "No Messages Available";
            }
            if(strlen($resultText) > 28){
                $msg = substr($resultText, 0, 28) . '....' ;
                ($user_id == $rowMsg['outgoing_msg_id']) ? $you = 'You: ' : $you = '';

             }else{
                $msg = $resultText;
                $you ='';
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
                  <a href="./chat_dm.php?chat_id=' . $chat_id . '&student=' . $student . '">
                    <div class="chat_element_container">
                        <div class="chat_details">
                            <div class="chat_img">
                                <img src="../../images/background2.jpg" alt="">
                            </div>
                            <div class="chat_info">
                                <div class="chat_name">
                                    <h2>
                                        ' . $row['firstname'] . " " . $row['lastname'] . '
                                    </h2>
                                </div>
                                <div class="chat_msg">
                                    ' . $you . $msg . '
                                </div>
                            </div>
                        </div>
                        <div class="online_status">' .
                $div
                . '
                                ' . $status . '
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
