<?php
// Include database connection
require './advertisesdb.php';

// Set headers for JSON response and CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $input = json_decode(file_get_contents("php://input"), true);

    // Check required fields
    if (!isset($input['contact']) || !isset($input['status']) || !isset($input['date'])) {
        echo json_encode(["error" => "Required fields: contact, status, date"]);
        exit;
    }

    // Assign variables from input and escape them to prevent SQL injection
    $contact = mysqli_real_escape_string($conn, $input['contact']);
    $status = mysqli_real_escape_string($conn, $input['status']);
    $date = mysqli_real_escape_string($conn, $input['date']); // Expected to be in a format like 'YYYY-MM-DD'

    // Prepare SQL query for inserting the conversation
    $sql = "INSERT INTO initiated_messages (contact, status, date) 
            VALUES ('$contact', '$status', '$date')";

    // Execute the query and check if the insertion is successful
    if (mysqli_query($conn, $sql)) {
        // Get the last inserted ID (conversation_id)
        $conversation_id = mysqli_insert_id($conn);

        echo json_encode([
            "success" => true,
            "conversation_id" => $conversation_id,
            "message" => "Conversation initiated successfully"
        ]);
    } else {
        echo json_encode(["error" => "Failed to initiate conversation: " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["error" => "Invalid request method. Use POST."]);
}

// Close the database connection
mysqli_close($conn);
?>
