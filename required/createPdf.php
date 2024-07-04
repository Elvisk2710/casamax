<?php
session_start();
// Define the API function
require_once '../homerunphp/advertisesdb.php';

// Check if the user is authenticated
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (empty($_SESSION['sessionAdmin'])) {
        $data = [
            'error' => 'Failed to generate PDF'
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    } else {
        // Fetch data from the database
        $admin_id = $_SESSION['sessionAdmin'];
        $sql_home = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id'";
        $sql_verify = "SELECT * FROM homerunhouses WHERE admin_id = '$admin_id' AND verified = '1'";

        $result = mysqli_query($conn, $sql_home);

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // Close the database connection
        mysqli_close($conn);

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Encode the data as JSON and print it
        echo json_encode($data);
    }
}

// Call the API function
