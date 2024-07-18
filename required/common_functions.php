<?php
// Function to format timestamp for display
function formatTimestamp($timestamp)
{
    // Get the current time
    $currentTime = time();

    // Calculate the start of today and yesterday
    $startOfToday = strtotime("today", $currentTime);
    $startOfYesterday = strtotime("yesterday", $currentTime);

    // Convert the input timestamp to a Unix timestamp
    $inputTime = strtotime($timestamp);

    // Format the output based on the timestamp
    if ($inputTime >= $startOfToday) {
        // If the timestamp is from today, return the time only
        return date("H:i", $inputTime);
    } elseif ($inputTime >= $startOfYesterday) {
        // If the timestamp is from yesterday, return "Yesterday"
        return "Yesterday";
    } else {
        // If the timestamp is older, return the date
        return date("Y-m-d", $inputTime);
    }
}

// Function to sanitize a string
function sanitize_string($message)
{
    // Strip HTML and PHP tags
    $message = strip_tags($message);
    // Convert special characters to HTML entities
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    // Remove any remaining harmful text
    $message = filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return $message;
}

// Function to sanitize an integer
function sanitize_integer($input)
{
    // Remove any non-digit characters
    $sanitized = filter_var($input, FILTER_SANITIZE_NUMBER_INT);

    // Return the sanitized input, even if it's not a valid integer
    return $sanitized;
}

// Function to sanitize an email address
function sanitize_email($email)
{
    // Remove illegal characters from the email
    $sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate the sanitized email
    $validated = filter_var($sanitized, FILTER_VALIDATE_EMAIL);

    // Return the validated email, or false if validation fails
    if ($validated) {
        return $sanitized;
    } else {
        return $validated;
    }
}

/* 
 * Custom function to compress image size and 
 * upload to the server using PHP 
 */
function compressImage($source, $destination, $quality)
{
    // Get image info 
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    // Create a new image from file 
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    // Save image 
    imagejpeg($image, $destination, $quality);

    // Return compressed image path 
    return $destination;
}

// Function to get upload path based on university
function getUniLocation($uni)
{
    switch ($uni) {
        case "University of Zimbabwe":
            $uploadPath = '../housepictures/uzpictures/';
            break;
        case "Midlands State University":
            $uploadPath = '../housepictures/msupictures/';
            break;
        case "Africa University":
            $uploadPath = '../housepictures/aupictures/';
            break;
        case "Bindura State University":
            $uploadPath = '../housepictures/bsupictures/';
            break;
        case "Chinhoyi University of Science and Technology":
            $uploadPath = '../housepictures/cutpictures/';
            break;
        case "Great Zimbabwe University":
            $uploadPath = '../housepictures/gzpictures/';
            break;
        case "Harare Institute of Technology":
            $uploadPath = '../housepictures/hitpictures/';
            break;
        case "National University of Science and Technology":
            $uploadPath = '../housepictures/nustpictures/';
            break;
        default:
            $uploadPath = null;
    }
    return $uploadPath;
}

// Custom function to sanitize and validate user input
function sanitizeInput($input)
{
    // Implement your sanitization logic here
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Function to generate a random and unique filename
function generateUniqueFilename($extension)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    $length = 10;

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString . '.' . $extension;
}

// Checks if a file is a valid image
function isValidImage($file)
{
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileInfo = getimagesize($file['tmp_name']);
    return in_array($fileInfo['mime'], $allowedTypes);
}

// Checks if a file size is within the limit
function isFileSizeWithinLimit($file)
{
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    return $file['size'] <= $maxFileSize;
}

// Compresses and saves the image
function compressAndSaveImage($source, $destination, $quality)
{
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    imagejpeg($image, $destination, $quality);
    imagedestroy($image);
}

// Function to generate university code based on name
function generateUniCode($uni)
{
    switch ($uni) {
        case "University of Zimbabwe":
            $uni_code = "uz";
            break;
        case "Midlands State University":
            $uni_code = "msu";
            break;
        case "Africa University":
            $uni_code = "au";
            break;
        case "Bindura State University":
            $uni_code = "bsu";
            break;
        case "Chinhoyi University of Science and Technology":
            $uni_code = "cut";
            break;
        case "Great Zimbabwe University":
            $uni_code = "gzu";
            break;
        case "Harare Institute of Technology":
            $uni_code = "hit";
            break;
        case "National University of Science and Technology":
            $uni_code = "nust";
            break;
        default:
            $uni_code = null;
    }
    return $uni_code;
}

// Function to check student subscription status
function checkStudentSubscription($conn, $home_id, $user_id)
{
    // Update the SQL query to use prepared statements
    $sql = 'SELECT subscribers.due_date, subscribers.number_of_houses_left, homerunuserdb.userid, homerunuserdb.email, subscribers.completed
            FROM homerunuserdb
            JOIN subscribers ON homerunuserdb.userid = subscribers.user_id
            WHERE homerunuserdb.userid = ?';

    // Prepare and bind parameters for the query
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if query was successful
    if ($result) {
        $total_records = mysqli_num_rows($result);
        
        // If subscription record exists
        if ($total_records > 0) {
            $row = mysqli_fetch_array($result);
            $houses_left = $row['number_of_houses_left'];
            $user_id = $row['userid'];
            $completed = $row['completed'];
            $expiry_date = $row['due_date'];

            // Create DateTime objects for the compare date and today's date
            $compareDateTime = new DateTime($expiry_date);
            $currentDateTime = new DateTime();
            
            // Compare the dates
            if ($expiry_date > $currentDateTime) {
                $expired = false;
            } elseif ($compareDateTime < $currentDateTime) {
                $expired = true;
            } else {
                $expired = false;
            }
            
            // Check subscription status
            if ($houses_left > 0 && ($completed == 0) && ($expired == false)) {
                $houses_left_update = $houses_left - 1;

                // Prepare and bind parameters for the update query
                $stmt_update = mysqli_prepare($conn, "UPDATE subscribers SET number_of_houses_left = ? WHERE user_id = ?");
                mysqli_stmt_bind_param($stmt_update, "is", $houses_left_update, $user_id);
                
                // Execute update query
                if (mysqli_stmt_execute($stmt_update)) {
                    redirect("../chat/screens/chat_dm.php?chat_id=" . $home_id . "&student=1");
                } else {
                    redirect("../listingdetails.php?clicked_id=" . $home_id . "&error=Failed To Reach Chat Page");
                }
            } else {
                // Handle case when user has no houses left or subscription expired
                $sql_complete = "UPDATE subscribers SET completed ='1'";
                
                // Execute completion query
                if (mysqli_query($conn, $sql_complete)) {
                    redirectToPaymentPage("No Houses Left");
                } else {
                    redirectToListingDetails($home_id, "Failed To Execute Query");
                }
            }
        } else {
            // Handle case when no subscription records are found
            redirectToListingDetails($home_id, 'No records found');
        }
    } else {
        // Handle case when query execution fails
        redirectToListingDetails($home_id, 'Failed To Execute Query');
    }
}

// Function to log error messages
function logError($errorMessage)
{
    // Implement your preferred method of logging errors (e.g., file logging, database logging)
    file_put_contents('error.log', $errorMessage . PHP_EOL, FILE_APPEND);
}

// Function to redirect to listing details page with error message
function redirectToListingDetails($home_id, $errorMessage)
{
    // Implement your logic to redirect with error message
    redirect("../listingdetails.php?clicked_id=" . $home_id . "&error=$errorMessage");
}

// Function to redirect to payment page with error message
function redirectToPaymentPage($errorMessage)
{
    // Implement your logic to redirect to payment page with error message
    redirect("../payment.php?error=$errorMessage");
}
?>
