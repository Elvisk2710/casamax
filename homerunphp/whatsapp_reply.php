<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Set headers to allow cross-origin requests (CORS) if necessary
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Require database connection and your WhatsAppResponse class
    require './advertisesdb.php';
    require '../required/common_functions.php';

    // Retrieve data from GET request
    $university = isset($_GET['university']) ? $_GET['university'] : '';
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
    $price = isset($_GET['price']) ? (int)$_GET['price'] : 0;

    // SQL query to fetch data with bound parameters
    $sql = 'SELECT * FROM homerunhouses WHERE uni = ? AND (gender = ? OR gender = "mixed") AND price <= ? AND contact != 0 ORDER BY price DESC LIMIT 10';
    
    $stmt = mysqli_stmt_init($conn);

    // Prepare the statement
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssi', $university, $gender, $price);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Get the result
            $result = mysqli_stmt_get_result($stmt);
            // Check if any records were found
            if (mysqli_num_rows($result) > 0) {
                // Initialize an array to hold WhatsAppResponse objects
                $responses = [];
                // Fetch each row and map it to a WhatsAppResponse object
                while ($row = mysqli_fetch_assoc($result)) {
                    $response = new WhatsAppResponse(
                        $row['id'],
                        $row['home_id'],
                        $row['contact'],
                        $row['price'],
                        $row['firstname'],
                        $row['lastname'],
                        $row['adrs'],
                        $row['people_in_a_room'],
                        $row['kitchen'],
                        $row['fridge'],
                        $row['wifi'],
                        $row['borehole'],
                        $row['transport'],
                    );
                    // Add the object to the responses array
                    $responses[] = $response;
                }
                // Return the mapped objects as a JSON object
                http_response_code(200);
                echo json_encode($responses);
            } else {
                // No records found
                http_response_code(404);
                echo json_encode(array("message" => "No records found."));
            }
        } else {
            // Handle errors in executing the prepared statement
            http_response_code(500);
            echo json_encode(array("message" => "Failed to execute statement: " . mysqli_stmt_error($stmt)));
        }
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle errors in preparing the statement
        http_response_code(500);
        echo json_encode(array("message" => "Failed to prepare statement: " . mysqli_error($conn)));
    }
    // Close the MySQLi connection
    mysqli_close($conn);
} else {
    // Handle incorrect request method
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed. Use GET request."));
}
