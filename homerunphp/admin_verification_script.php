<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connection to the database
    require_once './advertisesdb.php';
    var_dump($_POST);   
    if (isset($_POST['home_id'])) {
        $home_id = $_POST['home_id'];
    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE homerunhouses SET verified = '1' WHERE home_id = ?");
    $stmt->bind_param("s", $home_id); // "s" represents a string, adjust the data type if necessary

    // Execute the prepared statement
    $result = $stmt->execute();

    if ($result) {
        $response = [
            'status' => 'success',
            'verified' => $home_id,
            'message' => 'Verification successful' // Add the message field
        ];
        // Set the appropriate headers
        header('Content-Type: application/json');

        // Send the response
        header("refresh: 0.01; ../admin/admin_listings_dashboard/index.php?UpdateSuccessful");
        echo json_encode($response);
        echo '<script type="text/javascript"> alert("Update Successful") </script>';
        exit();
    } else {
        $response = [
            'status' => 'failed',
            'verified' => $home_id,
            'message' => 'Verification failed' // Add the message field
        ];
        // Set the appropriate headers
        header('Content-Type: application/json');
        header("refresh: 0.01; ../admin/admin_listings_dashboard/index.php?UpdateFailed");
        echo json_encode($response);
        echo '<script type="text/javascript"> alert("Update Failed") </script>';
        exit();
        // Send the response
        
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}else{
    $response = [
        'status' => 'failed',
        'verified' => $home_id,
        'message' => 'empty variables' // Add the message field
    ];
    // Set the appropriate headers
    header('Content-Type: application/json');

    // Send the response
    echo json_encode($response);
    header('Content-Type: application/json');
    header("refresh: 0.01; ../admin/admin_listings_dashboard/index.php?MissingVariables");
    echo json_encode($response);
    echo '<script type="text/javascript"> alert("Empty Fields") </script>';
    exit();
}
}