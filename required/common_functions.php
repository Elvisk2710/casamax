<?php
// send email function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
// send admin verification email
function sendAdminVerificationEmail($email, $firstname, $subject, $admin_id)
{

    require '../phpMailer/PHPMailer-master/src/Exception.php';
    require '../phpMailer/PHPMailer-master/src/PHPMailer.php';
    require '../phpMailer/PHPMailer-master/src/SMTP.php';
    $mailStatus = '';
    try {
        $message = '
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Thank You for Using Casamax.co.zw</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #ffffff;
                    color: rgb(8, 8, 12);
                    line-height: 1.6;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    background-color: #ffffff;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                h2 {
                    color: rgb(252, 153, 82);
                }
                .verification-code {
                    margin-top: 20px;
                    font-size: 18px;
                    padding: 10px;
                    background-color: rgb(252, 153, 82);
                    color: white;
                    border-radius: 4px;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: rgb(8, 8, 12);
                }
                .footer a {
                    color: rgb(8, 8, 12);
                    text-decoration: underline;
                }
            </style>
            </head>
            <body>
                <div class="email-container">
                    <h2>Thank You for Using Casamax.co.zw</h2>
                    <p>Dear ' . ucfirst(htmlspecialchars($firstname)) . ',</p>
                    <p>Thank you for choosing Casamax.co.zw. Your satisfaction is important to us.</p>
                    <p>Your home has been added to our platform successfully by Admin Id: ' . $admin_id . '. If you had not consented to us having your home please contact:</p>
                    <div class="verification-code"> whatsApp: +263 78 698 9144</div>
                    <p>Or</p>
                    <div class="verification-code"> email: info@casamax.co.zw</div>
                    <p>If you have any questions or need further assistance, please feel free to contact us.</p>
                    <div class="footer">
                        <p>This email is sent from Casamax.co.zw. For more information, please review our <a href="https://casamax.co.zw/privacy_policy.html">Privacy Policy</a> and <a href="https://casamax.co.zw/disclaimer.html">Disclaimer</a>.</p>
                    </div>
                </div>
            </body>
            </html>
        ';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;
        $mail->Username = 'casamaxzim@gmail.com';
        $mail->Password = 'znvsyhhgoivwzyds';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('casamaxzim@gmail.com', 'Casamax Investments');

        // Validate and sanitize email address
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $mailStatus = 'failed';
            return $mailStatus;
        } else {
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if (!$mail->send()) {
                $mailStatus = "failed";
                return $mailStatus;
                echo 'Email sending failed: ' . $mail->ErrorInfo;
                echo '<script>alert("Email sending failed: ' . $mail->ErrorInfo . '")</script>';
            } else {
                $mailStatus = "success";
                return $mailStatus;
                echo '<script>alert("Email sent successfully")</script>';
            }
        }
    } catch (Exception $e) {
        redirect(' ./agent_register.php?error=SMTP connection failed: ' . $e->getMessage());
        exit();
    }
}
// send advertisement verification email
function sendAdvertiseVerificationEmail($email, $firstname, $subject)
{

    require '../phpMailer/PHPMailer-master/src/Exception.php';
    require '../phpMailer/PHPMailer-master/src/PHPMailer.php';
    require '../phpMailer/PHPMailer-master/src/SMTP.php';
    $mailStatus = '';
    $message = '
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Thank You for Using Casamax.co.zw</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #ffffff;
                    color: rgb(8, 8, 12);
                    line-height: 1.6;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    background-color: #ffffff;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                h2 {
                    color: rgb(252, 153, 82);
                }
                .verification-code {
                    margin-top: 20px;
                    font-size: 18px;
                    padding: 10px;
                    background-color: rgb(252, 153, 82);
                    color: white;
                    border-radius: 4px;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: rgb(8, 8, 12);
                }
                .footer a {
                    color: rgb(8, 8, 12);
                    text-decoration: underline;
                }
            </style>
            </head>
            <body>
                <div class="email-container">
                    <h2>Thank You for Using Casamax.co.zw</h2>
                    <p>Dear ' . ucfirst(htmlspecialchars($firstname)) . ',</p>
                    <p>Thank you for choosing Casamax.co.zw. Your satisfaction is important to us.</p>
                    <p>Your home has been added to our platform successfullu. If you had not consented to us having your home please contact:</p>
                    <div class="verification-code"> whatsApp: +263 78 698 9144</div>
                    <p>Or</p>
                    <div class="verification-code"> email: info@casamax.co.zw</div>
                    <p>If you have any questions or need further assistance, please feel free to contact us.</p>
                    <div class="footer">
                        <p>This email is sent from Casamax.co.zw. For more information, please review our <a href="https://casamax.co.zw/privacy_policy.html">Privacy Policy</a> and <a href="https://casamax.co.zw/disclaimer.html">Disclaimer</a>.</p>
                    </div>
                </div>
            </body>
            </html>
        ';
    try {

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;
        $mail->Username = 'casamaxzim@gmail.com';
        $mail->Password = 'znvsyhhgoivwzyds';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('casamaxzim@gmail.com', 'Casamax Investments');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Validate and sanitize email address
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $mailStatus = 'failed';
            return $mailStatus;
        } else {
            if (!$mail->send()) {
                $mailStatus = "failed";
                return $mailStatus;
                echo 'Email sending failed: ' . $mail->ErrorInfo;
                echo '<script>alert("Email sending failed: ' . $mail->ErrorInfo . '")</script>';
            } else {
                $mailStatus = "success";
                return $mailStatus;
                echo '<script>alert("Email sent successfully")</script>';
            }
        }
    } catch (Exception $e) {
        redirect(' ./agent_register.php?error=SMTP connection failed: ' . $e->getMessage());
        exit();
    }
}
// logging in student
function loginUserStudent($email, $password)
{
    // Database credentials
    try {
        require '../homerunphp/advertisesdb.php';
    } catch (Exception $e) {
        return json_encode(array('status' => 'error', 'message' => 'Database file include failed: ' . $e->getMessage()));
    }

    // Check if connection was successful
    if ($conn->connect_error) {
        return json_encode(array('status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error));
    }

    $sql = "SELECT userid, passw, university FROM homerunuserdb WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        return json_encode(array('status' => 'error', 'message' => 'Failed to prepare SQL statement: ' . mysqli_error($conn)));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);

    if (!mysqli_stmt_execute($stmt)) {
        return json_encode(array('status' => 'error', 'message' => 'Failed to execute SQL statement: ' . mysqli_stmt_error($stmt)));
    }

    mysqli_stmt_bind_result($stmt, $id, $hashed_password, $university);

    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($password, $hashed_password)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return json_encode(array('status' => 'success', 'user_id' => $id, 'university' => $university));
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return json_encode(array('status' => 'error', 'message' => 'Invalid password'));
        }
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return json_encode(array('status' => 'error', 'message' => 'No user found with the given email'));
    }
}
// checkign student subscription
function checkStudentSubscription($user_id)
{
    // Database connection
    require '../homerunphp/advertisesdb.php';

    // Check if connection was successful
    if ($conn->connect_error) {
        echo json_encode(array('status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error));
        return;
    }

    // SQL query to check subscription
    $sub_check = "SELECT * FROM subscribers WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);

    // Prepare the SQL statement
    if (!mysqli_stmt_prepare($stmt, $sub_check)) {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to prepare SQL statement: ' . mysqli_error($conn)));
        mysqli_close($conn);
        return;
    }

    // Bind parameters and execute statement
    mysqli_stmt_bind_param($stmt, "s", $user_id);

    if (!mysqli_stmt_execute($stmt)) {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to execute SQL statement: ' . mysqli_stmt_error($stmt)));
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return;
    }

    // Get the result
    $sub_db_check = mysqli_stmt_get_result($stmt);

    if ($sub_db_check === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to retrieve result set: ' . mysqli_stmt_error($stmt)));
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return;
    }

    $rowCount = mysqli_num_rows($sub_db_check);

    // Check if the user is not subscribed
    if ($rowCount <= 0) {
        setcookie("cookiestudent", $user_id, time() + (86400 * 1), "/");
        setcookie("emailstudent", $email, time() + (86400 * 1), "/");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: ../payment.php?error=Please Subscribe");
        exit();
    } else {
        $results = mysqli_fetch_array($sub_db_check);
        $today = strtotime(date('Y-m-d'));

        if (strtotime($results['due_date']) < $today || $results['number_of_houses'] == 0 || $results['completed'] == 1) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: ../payment.php?error=Subscription Has Ended");
            exit();
        } else {
            echo json_encode(array('status' => 'success', 'message' => 'Failed to retrieve result set: ' . mysqli_stmt_error($stmt)));
        }
        // Close the statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
// loggin in landlord
function loginUserLandlord($email, $password)
{
    // Database credentials
    try {
        require '../homerunphp/advertisesdb.php';
    } catch (Exception $e) {
        return json_encode(array('status' => 'error', 'message' => 'Database file include failed: ' . $e->getMessage()));
    }

    // Check if connection was successful
    if ($conn->connect_error) {
        return json_encode(array('status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error));
    }

    $sql = "SELECT home_id, passw FROM homerunhouses WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        return json_encode(array('status' => 'error', 'message' => 'Failed to prepare SQL statement: ' . mysqli_error($conn)));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);

    if (!mysqli_stmt_execute($stmt)) {
        return json_encode(array('status' => 'error', 'message' => 'Failed to execute SQL statement: ' . mysqli_stmt_error($stmt)));
    }

    mysqli_stmt_bind_result($stmt, $id, $hashed_password,);

    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($password, $hashed_password)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return json_encode(array('status' => 'success', 'user_id' => $id));
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return json_encode(array('status' => 'error', 'message' => 'Invalid password'));
        }
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return json_encode(array('status' => 'error', 'message' => 'No user found with the given email'));
    }
}
