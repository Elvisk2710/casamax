<?php
session_start();
require './advertisesdb.php';
require '../required/alerts.php';
require '../required/common_functions.php';
if (isset($_SESSION['sessionstudent'])) {
    $student = $_SESSION['sessionstudent'];
    $home_id = $_GET['home_id'];

    if ($_GET['route'] == "landlord") {
        if (isset($_POST['check_sub_chat_landlord']) || $_POST['check_sub_chat_landlord']) {
            handleSubscriptionChat($conn, $student, $home_id);
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
function handleSubscriptionChat($conn, $student, $home_id)
{
    checkStudentSubscription($conn, $home_id, $student);
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
