<?php
    session_start();

    if (isset($_POST['homeAdminSession'])) {
        // Retrieve the dynamic value from the AJAX request
        $homeAdminSession = $_POST['homeAdminSession'];
    
        // Set the session variable
        $_SESSION['homeAdminSession'] = $homeAdminSession;
    
        // Return a response (optional)
        echo 'Session variable set.';
    } else {
        echo 'No dynamic value received.';
    }
?>