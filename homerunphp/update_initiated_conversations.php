<?php
// Set headers for JSON response and CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require './advertisesdb.php';

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get JSON input
    $input = json_decode(file_get_contents("php://input"), true);

    // Check required fields
    if (!isset($input['contact']) || !isset($input['status'])) {
        echo json_encode(["error" => "Required fields: contact, status"]);
        exit;
    }

    // Assign variables from input and escape them to prevent SQL injection
    $contact = mysqli_real_escape_string($conn, $input['contact']);
    $status = mysqli_real_escape_string($conn, $input['status']);

    try {
        // Find the ID of the most recent conversation record for the given contact
        $sql_select = "SELECT id FROM initiated_messages WHERE contact = '$contact' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql_select);

        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the conversation ID
            $row = mysqli_fetch_assoc($result);
            $conversation_id = $row['id'];

            // Update the status of the last conversation record
            $sql_update = "UPDATE initiated_messages SET status = '$status' WHERE id = $conversation_id";
            if (mysqli_query($conn, $sql_update)) {
                echo json_encode([
                    "success" => true,
                    "message" => "Conversation status updated successfully"
                ]);
            } else {
                throw new Exception("Failed to update conversation status");
            }
        } else {
            echo json_encode(["error" => "No conversation found for the specified contact"]);
        }
    } catch (Exception $e) {
        // Roll back if there was an error
        mysqli_rollback($conn);
        echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request method. Use PUT."]);
}

// Close the database connection
mysqli_close($conn);
