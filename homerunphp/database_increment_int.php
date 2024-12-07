<?php
require './advertisesdb.php';
require '../required/common_functions.php';
try {
    // Check if the necessary GET parameters are set
    if (isset($_GET['column']) && isset($_GET['home_id'])) {
        // Sanitize the input values (optional but recommended)
        $column = $_GET['column'];
        $home_id = $_GET['home_id']; // Ensure home_id is an integer

        // Call your PHP function to increment the field
        if(incrementIntField($conn, 'homerunhouses', $column, $home_id)){
            echo "success";
        }
    } else {
        throw new Exception("Missing required parameters.");
    }
} catch (Exception $e) {
    // Catch any exceptions and display an error message
    echo "Error: " . $e->getMessage();
}
