<?php
session_start();
require '../homerunphp/advertisesdb.php';
require '../required/alerts.php';
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

    // Return compressed image 
    return $destination;
}
if (isset($_POST['update_images'])) {
    $home_id = mysqli_real_escape_string($conn, $_GET['home_id']);
    $uni = mysqli_real_escape_string($conn, $_GET['uni']);
    $name = "image_update";
    $countfiles = 8;
    $count = 0;

    for ($i = 0; $i < $countfiles; $i++) {
        switch ($i) {
            case 0:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image1 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image1 = "";
                }
                break;
                // Handle other cases similarly
        }
    }

    $sql = "UPDATE homerunhouses SET image1 = ?, image2 = ?, image3 = ?, image4 = ?, image5 = ?, image6 = ?, image7 = ?, image8 = ? WHERE home_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssi', $image1, $image2, $image3, $image4, $image5, $image6, $image7, $image8, $home_id);

    if (!mysqli_stmt_execute($stmt)) {
        $error = mysqli_stmt_error($stmt);
        redirect('./agent_profile.php?error=Error: '. $error);
    } else {
        $status = 'failed';
        $statusMsg = 'failed';

        $uploadPath = ''; // Initialize the upload path variable

        // Set the upload path based on the university
        switch ($uni) {
            case "University of Zimbabwe":
                $uploadPath = '../housepictures/uzpictures/';
                break;
            case "Midlands State University":
                $uploadPath = '../housepictures/msupictures/';
                break;
            case "Africa Univeristy":
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
                // Handle other universities similarly
        }

        if (!empty($uploadPath)) {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = $uploadPath . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
            }
        } else {
            redirect('./agent_profile.php?error=Error While Uploading');

        }
    }

    mysqli_stmt_close($stmt);

    if ($status == 'error') {
        redirect('./agent_profile.php?error=Compression Error');
    } elseif ($status == 'success') {
        redirect('./agent_profile.php?error=Home Added Successfully');
    } elseif ($status == 'file_type_error') {
        redirect('./agent_profile.php?error=File Not Supported');
    } else {
        redirect('./agent_profile.php?error=Failed To Upload Images-FileNotSupported');
    }
}
if (isset($_POST['verification_submit'])) {
    $agent_id = $_SESSION['sessionagent'];
    $verification_image = $_FILES['identityImage'];
    $verification_image_name = mysqli_real_escape_string($conn, $_FILES['identityImage']['name']);
    $sql = "UPDATE agents SET verification_image = '$verification_image_name' WHERE agent_id='$agent_id'";

    // directory path to folder for verification images
    $directoryPath = '../verification_images/agents_verification_images/' . $agent_id . '/';
    $verificationImageDestination = $directoryPath . basename($verification_image_name);

    // checks if the folder exists
    if (!file_exists($directoryPath)) {
        // creates your folder
        if (mkdir($directoryPath, 0777, true)) {
            // uploads the file to the folder
            if (move_uploaded_file($verification_image['tmp_name'], $verificationImageDestination)) {
                // updates database
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    if(mysqli_stmt_execute($stmt)){
                        redirect(' ./agent_profile.php?error=Verification Image Uploaded');
                    }else{
                        redirect(' ./agent_profile.php?error=Failed To Upload Verification Image');
                    }
                } else {
                    redirect(' ./agent_profile.php?error=SQL ERROR Failed To Update Database');
                }
            } else {
                redirect('./agent_profile.php?error=Error: Failed to upload Images');
            }
        } else {
            redirect(' ./agent_profile.php?error=Failed To Make Your Directory');
        }
    } else {
        redirect(' ./agent_profile.php?error=Your File Already Exists');
    }
}
