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
        $sql = "SELECT * FROM homerunhouses";
        $student = true;
    } elseif (isset($_SESSION['sessionowner'])) {
        $user_id = $_SESSION['sessionowner'];
        $sql = "SELECT * FROM homerunuserdb";
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
            $output .= '
                  <a href="./chat_dm.php?chat_id='. $chat_id .'&student='.$student.'">
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
                                    This is the last message
                                </div>
                            </div>
                        </div>
                        <div class="online_status">
                            <div class="online_status_icon">
                                '.$row['status'].'
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
