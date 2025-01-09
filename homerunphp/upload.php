<?php

$status = $statusMsg = 'failed';

if (!empty($_FILES["$name"]["name"][$num])) {
    // File info
    $fileTemp = $_FILES["$name"]["tmp_name"][$num];
    $fileType = pathinfo($_FILES["$name"]["name"][$num], PATHINFO_EXTENSION);
    $fileType = strtolower($fileType);

    // Allow certain file formats
    $allowedTypes = array('jpg', 'png', 'jpeg', 'heic');

    // Validate file type
    if (in_array($fileType, $allowedTypes)) {
        // Validate file size (e.g., maximum 5MB)
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        if ($_FILES["$name"]["size"][$num] <= $maxFileSize) {

            // Compress size and upload image
            if (compressImage($fileTemp, $imageUploadPath, 60)) {
                $status = 'success';
                $statusMsg = 'Image uploaded successfully';
            } else {
                $status = 'error';
                $statusMsg = 'Image compress failed!';
                throw new Exception("Compression failed: ");
            }
        } else {
            $status = 'file_size_error';
            $statusMsg = 'The file size exceeds the allowed limit.';
            throw new Exception("Compression failed: File Size Image");
        }
    } else {
        $status = 'file_type_error';
        $statusMsg = 'Some images were not uploaded due to unsupported formats. Only JPG, JPEG, PNG files are currently supported.';
        throw new Exception("Compression failed: Format Not Supported");
    }
} else {
    $status = 'empty_images';
    $statusMsg = 'No images were uploaded.';
    throw new Exception("Compression failed: No Images have been uploaded");
}
