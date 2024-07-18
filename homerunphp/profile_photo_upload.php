<?php
session_start();
require '../required/alerts.php';
require '../required/common_functions.php';
// Perform necessary security checks
if (isset($_POST['profile_photos']) && !empty($_SESSION['sessionowner'])) {

    // Database connection
    require 'advertisesdb.php';

    $email = $_SESSION['sessionowner'];
    $sql = "SELECT * FROM homerunhouses WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $uni = $row['uni'];

        $imageCount = 8;
        $uploadedImages = [];

        // Process each uploaded image
        for ($i = 0; $i < $imageCount; $i++) {
            $file = $_FILES['image']['name'][$i];

            if (!empty($file)) {
                $fileTmp = $_FILES['image']['tmp_name'][$i];
                $fileSize = $_FILES['image']['size'][$i];
                $fileError = $_FILES['image']['error'][$i];

                // Perform security checks on the file
                $file = sanitizeInput($file);

                if ($fileError === 0 && isValidImage($_FILES['image'][$i]) && isFileSizeWithinLimit($_FILES['image'][$i])) {
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                    $newFilename = generateUniqueFilename($fileExtension);
                    $destination = '../housepictures/' . $uni . 'pictures/' . $newFilename;

                    // Compress and save the image
                    compressAndSaveImage($fileTmp, $destination, 80);

                    $uploadedImages[] = $newFilename;
                }
            }
        }

        // Update the database with the uploaded image names
        $sql = "UPDATE homerunhouses SET image1=?, image2=?, image3=?, image4=?, image5=?, image6=?, image7=?, image8=? WHERE email=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssssss', $email, ...$uploadedImages);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Images uploaded successfully
            redirect("Location: ../profile.php?status=Profile Updated");
        } else {
            // Failed to update database
            redirect("Location: ../profile.php?status=Failed To Update Images");
        }
    } else {
        // User not found in the database
        redirect("Location: ../profile.php?error=User Not Found");
    }
} else {
    // Invalidsession or form submission
    redirect("Location: ../profile.php?error=Invalid Session");
}
