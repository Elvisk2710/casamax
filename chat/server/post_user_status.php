<?php
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../homerunphp/advertisesdb.php';

    // Get the request body
    $requestBody = file_get_contents('php://input');
    $data = json_decode($requestBody, true);

    // Get the user's status from the request body
    $status = $data['status'];

    // Update the user's status in your database or session
    if (isset($_SESSION['sessionstudent'])) {
        $user_id = $_SESSION['sessionstudent'];
        $sql = "UPDATE homerunuserdb SET status = '$status' WHERE userid = '$user_id'";
    } elseif (isset($_SESSION['sessionowner'])) {
        $user_id = $_SESSION['sessionowner'];
        $sql = "UPDATE homerunhouses SET status = '$status' WHERE home_id = '$user_id'";
    }else{
        exit();
    }

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo $status;
    }
} else {
    // Return an error response for non-POST requests
    http_response_code(405);
    echo 'Method not allowed';
}
?>