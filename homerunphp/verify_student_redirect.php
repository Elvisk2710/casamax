<?php
session_start();
require './advertisesdb.php';
if (isset($_SESSION['sessionstudent'])) {
    $student = $_SESSION['sessionstudent'];
    $home_id = $_GET['home_id'];

    if (isset($_GET['agent_id'])) {
        $agent_id = $_GET['agent_id'];
    }

    if ($_GET['route'] == "landlord") {
        if (isset($_POST['check_sub_whatsapp_landlord']) || $_POST['check_sub_whatsapp_landlord']) {
            handleSubscriptionLandlord($conn, $student, $home_id, "whatsapp");
        } elseif (isset($_POST['check_sub_call_landlord']) || $_POST['check_sub_call_landlord']) {
            handleSubscriptionLandlord($conn, $student, $home_id, "call");
        }
    } elseif ($_GET['route'] == "agent") {
        if (isset($_POST['check_sub_whatsapp_agent']) || $_POST['check_sub_whatsapp_agent']) {
            handleSubscriptionAgent($conn, $student, $agent_id, $home_id, "whatsapp");
        } elseif (isset($_POST['check_sub_call_agent']) || $_POST['check_sub_call_agent']) {
            handleSubscriptionAgent($conn, $student, $agent_id, $home_id, "call");
        }
    }
} else {
    // Handle case when sessionstudent is not set
    header("Location: ../login.php?error='Login First'");
    exit;
}

function handleSubscriptionLandlord($conn, $student, $home_id, $contactMethod)
{
    // Update the SQL query to use prepared statements
    $sql = 'SELECT subscribers.due_date, subscribers.number_of_houses_left, homerunuserdb.userid, homerunuserdb.email, subscribers.completed
            FROM homerunuserdb
            JOIN subscribers ON homerunuserdb.userid = subscribers.user_id
            WHERE homerunuserdb.email = ?';

    $sql_home = "SELECT contact FROM homerunhouses WHERE home_id = ?";

    // Prepare and bind parameters for the first query
    $stmt = mysqli_prepare($conn, $sql);
    $student = mysqli_real_escape_string($conn, $student); // Sanitize user input
    mysqli_stmt_bind_param($stmt, "s", $student);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // if the connection is successful
    if ($result) {
        $total_records = mysqli_num_rows($result);
        // if the user has subscribed
        if ($total_records > 0) {
            $row = mysqli_fetch_array($result);
            $houses_left = $row['number_of_houses_left'];
            $user_id = $row['userid'];
            $completed = $row['completed'];
            $expiry_date = $row['due_date'];

            // Create DateTime objects for the compare date and today's date
            $compareDateTime = new DateTime($expiry_date);
            $currentDateTime = new DateTime();
            // Compare the dates
            if ($expiry_date > $currentDateTime) {
                // The compare date is in the future
                $expired = false;
            } elseif ($compareDateTime < $currentDateTime) {
                $expired = true;
            } else {
                $expired = false;
            }
            // if the user's subscription is still valid.
            if ($houses_left > 0 && ($completed == 0) && ($expired == false)) {
                $houses_left_update = $houses_left - 1;

                // Prepare and bind parameters for the update query
                $stmt_update = mysqli_prepare($conn, "UPDATE subscribers SET number_of_houses_left = ? WHERE user_id = ?");
                mysqli_stmt_bind_param($stmt_update, "is", $houses_left_update, $user_id);
                if (mysqli_stmt_execute($stmt_update)) {
                    $stmt = mysqli_prepare($conn, $sql_home);
                    $home_id = mysqli_real_escape_string($conn, $home_id); // Sanitize user input
                    mysqli_stmt_bind_param($stmt, "s", $home_id);
                    mysqli_stmt_execute($stmt);
                    $result_home = mysqli_stmt_get_result($stmt);
                    if ($result_home) {
                        $row_home = mysqli_fetch_array($result_home);
                        $contact = $row_home['contact'];
                        $contact = preg_replace('/[^0-9]/', '', $contact); // Remove non-numeric characters

                        if ($contactMethod === "whatsapp") {
                            $url = "https://wa.me/263" . $contact . "?text=Hello.%20I%20saw%20your%20boarding%20house%20on%20CasaMax.co.zw%20and%20I%20am%20interested%20in%20being%20a%20tenant%20there.%20Is%20it%20still%20available%3F";
                        } elseif ($contactMethod === "call") {
                            $url = "tel:263" . $contact;
                        }

                        $options = [
                            'http' => [
                                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3",
                                'ignore_errors' => true // Ignore HTTP errors
                            ]
                        ];
                        $context = stream_context_create($options);
                        $response = file_get_contents($url, false, $context);
                        if ($response !== false) {
                            // Successfully retrieved the URL content
                            echo 'openPage()';
                            echo $response;
                        } else {
                            // Error occurred while opening the URL
                            header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed to execute URL request'");
                            echo "<script> alert('Failed to open the URL.')</script>";
                        }
                    }
                } else {
                    // Handle case when no records are found
                    header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed to execute stmt request'");
                    echo "<script> alert('Failed to open the URL.')</script>";
                }
            } else {
                // Handle case when user has no houses left
                $sql_complete = "UPDATE subscribers SET completed ='1'";
                if (mysqli_query($conn, $sql_complete)) {
                    header("Location: ../payment.php?error='No Houses Left or Subscription Ended Please Subscribe'");
                    echo "<script> alert('No houses left or subscription ended, Please Subscribe!!.')</script>";
                } else {
                    header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed to complete query'");
                    echo "<script> alert('Failed to complete query.')</script>";
                }
            }
        } else {
            // Handle case when no records are found
            header("Location: ../payment.php?error='No records found'");
            echo "<script> alert('Please Subscribe.')</script>";
        }
    } else {
        // Handle case when query execution fails
        header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed to execute query'");
        echo "<script> alert('Failed to execute query.')</script>";
    }
}
function handleSubscriptionAgent($conn, $student, $agent_id, $home_id, $contactMethod)
{
    $agent_id = "1708767875_c7e7d341b3731257_3520_$2y$1";
    // Update the SQL query to use prepared statements
    $sql = 'SELECT subscribers.due_date, subscribers.number_of_houses_left, homerunuserdb.userid, homerunuserdb.email, subscribers.completed
            FROM homerunuserdb
            JOIN subscribers ON homerunuserdb.userid = subscribers.user_id
            WHERE homerunuserdb.email = ?';

    $sql_agent = "SELECT contact FROM agents WHERE agent_id = ?";

    // Prepare and bind parameters for the first query
    $stmt = mysqli_prepare($conn, $sql);
    $student = mysqli_real_escape_string($conn, $student); // Sanitize user input
    mysqli_stmt_bind_param($stmt, "s", $student);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // if the connection is successful
    if ($result) {
        $total_records = mysqli_num_rows($result);
        // if the user has subscribed
        if ($total_records > 0) {
            $row = mysqli_fetch_array($result);
            $houses_left = $row['number_of_houses_left'];
            $user_id = $row['userid'];
            $completed = $row['completed'];
            $expiry_date = $row['due_date'];

            // Create DateTime objects for the compare date and today's date
            $compareDateTime = new DateTime($expiry_date);
            $currentDateTime = new DateTime();
            // Compare the dates
            if ($expiry_date > $currentDateTime) {
                // The compare date is in the future
                $expired = false;
            } elseif ($compareDateTime < $currentDateTime) {
                $expired = true;
            } else {
                $expired = false;
            }
            // if the user's subscription is still valid.
            if ($houses_left > 0 && ($completed == 0) && ($expired == false)) {
               
                    $stmt_agent = mysqli_prepare($conn, $sql_agent);
                    $agent_id = mysqli_real_escape_string($conn, $agent_id); // Sanitize user input
                    mysqli_stmt_bind_param($stmt_agent, "s", $agent_id);
                    mysqli_stmt_execute($stmt_agent);
                    $result_agent = mysqli_stmt_get_result($stmt_agent);
                    if ($result_agent) {
                        $row_agent = mysqli_fetch_array($result_agent);
                        $contact = $row_agent['contact'];
                        $contact = preg_replace('/[^0-9]/', '', $contact); // Remove non-numeric characters
                        if ($contactMethod === "whatsapp") {
                            $url = "https://wa.me/263" . $contact . "?text=Hello.%20I%20saw%20your%20boarding%20house%20on%20CasaMax.co.zw%20and%20I%20am%20interested%20in%20being%20a%20tenant%20there.%20Is%20it%20still%20available%3F";
                        } elseif ($contactMethod === "call") {
                            $url = "tel:263" . $contact;
                        }

                        $options = [
                            'http' => [
                                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3",
                                'ignore_errors' => true // Ignore HTTP errors
                            ]
                        ];
                        $context = stream_context_create($options);
                        $response = file_get_contents($url, false, $context);
                        if ($response !== false) {
                            // Successfully retrieved the URL content
                            echo 'openPage()';
                            echo $response;
                            $houses_left_update = $houses_left - 1;
                            // Prepare and bind parameters for the update query
                            $stmt_update = mysqli_prepare($conn, "UPDATE subscribers SET number_of_houses_left = ? WHERE user_id = ?");
                            mysqli_stmt_bind_param($stmt_update, "is", $houses_left_update, $user_id);
                            mysqli_stmt_execute($stmt_update);
                        } else {
                            // Error occurred while opening the URL
                            header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed to execute URL request'");
                            echo "<script> alert('Failed to open the URL.')</script>";
                        }
                    }else{
                        header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed To Retrieve Agent Info'");
                        echo "<script> alert('Failed To Retrieve Agent Info.')</script>";
                    }
            } else {
                // Handle case when user has no houses left
                $sql_complete = "UPDATE subscribers SET completed ='1'";
                if (mysqli_query($conn, $sql_complete)) {
                    header("Location: ../payment.php?error='No Houses Left or Subscription Ended Please Subscribe'");
                    echo "<script> alert('No houses left or subscription ended, Please Subscribe!!.')</script>";
                } else {
                    header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed to complete query'");
                    echo "<script> alert('Failed to complete query.')</script>";
                }
            }
        } else {
            // Handle case when no records are found
            header("Location: ../payment.php?error='No records found'");
            echo "<script> alert('Please Subscribe.')</script>";
        }
    } else {
        // Handle case when query execution fails
        header("Location: ../listingdetails.php?clicked_id=$home_id&error='Failed to execute query'");
        echo "<script> alert('Failed to execute query.')</script>";
    }
}
?>

<script>
    function openPage() {
        window.onload = function() {
            window.open('<?php echo $url; ?>', '_blank');
        };
    }
</script>