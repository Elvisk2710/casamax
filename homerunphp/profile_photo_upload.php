<?php
session_start();

// Perform necessary security checks
if (isset($_POST['profile_photos']) && !empty($_SESSION['sessionowner'])) {
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
        mysqli_stmt_bind_param($stmt, 'ssssssssss', ...$uploadedImages, $email);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Images uploaded successfully
            header("Location: ../profile.php?status=Profile Created");
            exit();
        } else {
            // Failed to update database
            header("Location: ../profile.php?error=Failed To Upload Images");
            exit();
        }
    } else {
        // User not found in the database
        header("Location: ../profile.php?error=User Not Found");
        exit();
    }
} else {
    // Invalidsession or form submission
    header("Location: ../profile.php?error=Invalid Session");
    exit();
}
