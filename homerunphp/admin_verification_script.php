<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include '../required/alerts.php';
require '../required/common_functions.php';

// Verify if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for necessary data
    if (isset($_POST['home_id'])) {
        $home_id = $_POST['home_id'];

        // Sanitize user input
        $home_id = sanitize_string($home_id);

        // Validate input
        if (empty($home_id)) {
            $response = [
                'status' => 'failed',
                'message' => 'Missing home ID'
            ];
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
            redirect("../admin/admin_listings_dashboard/index.php?error=Home Id Not Valid");
            exit();
        }

        // Connection to the database
        require_once './advertisesdb.php';

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE homerunhouses SET verified = '1' WHERE home_id = ?");
        $stmt->bind_param("s", $home_id); // "s" represents a string, adjust the data type if necessary

        // Execute the prepared statement
        $result = $stmt->execute();

        if ($result) {
            $response = [
                'status' => 'success',
                'verified' => $home_id,
                'message' => 'Verification successful'
            ];
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($response);
            redirect("../admin/admin_listings_dashboard/index.php?error=Home Verified Successfully");
            exit();
        } else {
            $response = [
                'status' => 'failed',
                'verified' => $home_id,
                'message' => 'Verification failed'
            ];
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode($response);
            redirect("../admin/admin_listings_dashboard/index.php?error=Failed To Verify Home Successfully");
            exit();
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    }elseif(isset($_POST['agent_id'])) {
        $agent_id = $_POST['agent_id'];

        // Sanitize user input
        $agent_id = sanitize_string($agent_id);

        // Validate input
        if (empty($agent_id)) {
            $response = [
                'status' => 'failed',
                'message' => 'Missing home ID'
            ];
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
            redirect("../admin/admin_listings_dashboard/index.php?error=Home Id Not Valid");
            exit();
        }

        // Connection to the database
        require_once './advertisesdb.php';

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE agents SET verified = '1' WHERE agent_id = ?");
        $stmt->bind_param("s", $agent_id); // "s" represents a string, adjust the data type if necessary

        // Execute the prepared statement
        $result = $stmt->execute();

        if ($result) {
            $response = [
                'status' => 'success',
                'verified' => $agent_id,
                'message' => 'Verification successful'
            ];
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($response);
            redirect("../admin/admin_listings_dashboard/index.php?error=Agent Verified Successfully");
            exit();
        } else {
            $response = [
                'status' => 'failed',
                'verified' => $agent_id,
                'message' => 'Verification failed'
            ];
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode($response);
            redirect("../admin/admin_listings_dashboard/index.php?error=Failed To Verify Agent Successfully");
            exit();
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();

    }else {
        $response = [
            'status' => 'failed',
            'message' => 'Missing home ID'
        ];
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($response);
        redirect("../admin/admin_listings_dashboard/index.php?error=Error: Missing Home Id");
        exit();
    }
} else {
    $response = [
        'status' => 'failed',
        'message' => 'Invalid request method'
    ];
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode($response);
    redirect("../admin/admin_listings_dashboard/index.php?error=Error: Invalid Request Method");
    exit();
}
