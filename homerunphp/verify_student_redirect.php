<?php
session_start();
require './advertisesdb.php';
require '../required/alerts.php';
if (isset($_SESSION['sessionstudent'])) {
    $student = $_SESSION['sessionstudent'];
    $home_id = $_GET['home_id'];

    if ($_GET['route'] == "landlord") {
        if (isset($_POST['check_sub_chat_landlord']) || $_POST['check_sub_chat_landlord']) {
            handleSubscriptionChat($conn, $student, $home_id, "chat");
        }
    } elseif ($_GET['route'] == "agent" && isset($_GET['agent_id'])) {
        $agent_id = $_GET['agent_id'];
        if (isset($_POST['check_sub_whatsapp_agent']) || $_POST['check_sub_whatsapp_agent']) {
            handleSubscriptionAgent($conn, $student, $agent_id, $home_id, "whatsapp");
        } elseif (isset($_POST['check_sub_call_agent']) || $_POST['check_sub_call_agent']) {
            handleSubscriptionAgent($conn, $student, $agent_id, $home_id, "call");
        }
    } else {
        redirectToListingDetails($home_id, "Variable Error Occured!");
    }
} else {
    // Handle case when sessionstudent is not set
    header("Location: ../login.php?error='Login First'");
    exit;
}
function handleSubscriptionChat($conn, $student, $home_id, $contactMethod)
{
    // Update the SQL query to use prepared statements
    $sql = 'SELECT subscribers.due_date, subscribers.number_of_houses_left, homerunuserdb.userid, homerunuserdb.email, subscribers.completed
            FROM homerunuserdb
            JOIN subscribers ON homerunuserdb.userid = subscribers.user_id
            WHERE homerunuserdb.userid = ?';

    // Prepare and bind parameters for the first query
    $stmt = mysqli_prepare($conn, $sql);
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
                    redirect("../chat/screens/chat_dm.php?chat_id=" . $home_id . "&student=1");
                } else {
                    redirect("../listingdetails.php?clicked_id=" . $home_id . "&error=Failed To Reach Chat Page");
                }
            } else {
                // Handle case when user has no houses left
                $sql_complete = "UPDATE subscribers SET completed ='1'";
                if (mysqli_query($conn, $sql_complete)) {
                    // redirect to payment when the subscription is completed
                    redirectToPaymentPage("No Houses Left");
                } else {
                    // Handle case when query execution fails
                    redirectToListingDetails($home_id, "Failed To Execute Query");
                }
            }
        } else {
            // Handle case when no records are found
            redirectToListingDetails($home_id, 'No records found'); // Redirect with generic error message
        }
    } else {
        // Handle case when query execution fails
        redirectToListingDetails($home_id, 'Failed To Execute Query'); // Redirect with generic error message
    }
}
function handleSubscriptionAgent($conn, $student, $agent_id, $home_id, $contactMethod)
{
    $sql_agent = "SELECT contact FROM agents WHERE agent_id = ?";

    $stmt_agent = mysqli_prepare($conn, $sql_agent);
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
        } else {
            redirectToListingDetails($home_id, 'No Contact Method Found'); // Redirect with generic error message
        }
        header("Location: " . $url);
    } else {
        logError('Failed To Retrieve Agent Info.'); // Log the error internally
        redirectToListingDetails($home_id, 'Failed To Retrieve Agent Info'); // Redirect with generic error message
    }
}
// Additional helper functions.

function logError($errorMessage)
{
    // Implement your preferred method of logging the error, such as writing to a log file or storing in a database.
    // Make sure to handle any sensitive information appropriately.
    file_put_contents('error.log', $errorMessage . PHP_EOL, FILE_APPEND);
}

// redirect to listing page
function redirectToListingDetails($home_id, $errorMessage)
{
    // Implement your logic to redirect the user to the listing details page with an error message.
    redirect("../listingdetails.php?clicked_id=' . $home_id . '&error=$errorMessage");
}
// redirect to Payment page
function redirectToPaymentPage($errorMessage)
{
    // Implement your logic to redirect the user to the payment page with an error message.
    redirect("../payment.php?error=$errorMessage");
}
?>

<script>
    function openPage() {
        window.onload = function() {
            window.open('<?php echo $url; ?>', '_blank');
        };
    }
</script>