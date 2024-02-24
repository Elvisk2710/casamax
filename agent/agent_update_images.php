<?php
session_start();
require '../homerunphp/advertisesdb.php';
$sec = 0.1;
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
    $home_id = $_GET['home_id'];
    $uni = $_GET['uni'];
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
            case 1:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image2 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image2 = "";
                }
                break;
            case 2:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image3 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image3 = "";
                }
                break;
            case 3:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image4 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image4 = "";
                }
                break;
            case 4:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image5 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image5 = "";
                }
                break;
            case 5:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image6 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image6 = "";
                }
                break;
            case 6:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image7 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image7 = "";
                }
                break;
            case 7:
                if (!empty($_FILES['image_update']['name'][$i])) {
                    $image8 = $_FILES['image_update']['name'][$i];
                    $count++;
                } else {
                    $image8 = "";
                }
                break;
        }
    }

    $sql = "UPDATE homerunhouses SET image1 = '$image1', image2 = '$image2', image3 = '$image3', image4 = '$image4', image5 = '$image5', image6 = '$image6', image7 = '$image7', image8 = '$image8' WHERE home_id = '$home_id'";

    if (!mysqli_query($conn, $sql)) {
        $error = mysqli_stmt_error($stmt);
        header("refresh:$sec;  ./agent_profile.php?error=SQL ERROR");
        print("Error : " . $error);

        echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
    } else {
        $status = 'failed';
        $statusMsg = 'failed';
        if ($uni === "University of Zimbabwe") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/uzpictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
                echo $num;
            }
        } elseif ($uni === "Midlands State University") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/msupictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
            }
        } elseif ($uni === "Africa Univeristy") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/aupictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
            }
        } elseif ($uni === "Bindura State University") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/bsupictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
            }
        } elseif ($uni === "Chinhoyi University of Science and Technology") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/cutpictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
            }
        } elseif ($uni === "Great Zimbabwe University") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/gzpictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
            }
        } elseif ($uni === "Harare Institute of Technology") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/hitpictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.phpupload.php';
            }
        } elseif ($uni === "National University of Science and Technology") {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = '../housepictures/nustpictures/' . basename($_FILES["$name"]["name"][$num]);
                require '../homerunphp/upload.php';
            }
        } else {
            echo '<script type="text/javascript"> alert("Error while uploading") </script>';
        }
    }
    if ($status == 'error') {
        header("refresh:$sec;  ./agent_profile.php?error=CompressionError");
        echo '<script type="text/javascript"> alert("' . $statusMsg . '")  </script>';
        // echo 1;
    } elseif ($status == 'success') {
        header("refresh:$sec;  ./agent_profile.php?error=HomeAddedSuccessfuly");
        echo '<script type="text/javascript"> alert("' . $statusMsg . '") </script>';
        // echo 2;
    } elseif ($status == 'file_type_error') {
        header("refresh:$sec;  ./agent_profile.php?error=FileNotSupported");
        echo '<script type="text/javascript"> alert("' . $statusMsg . '") </script>';
        // echo 3;
    } else {
        header("refresh:$sec;  ./agent_profile.php?error=FailedToUploadImages-FileNotSupported");
        echo '<script type="text/javascript"> alert("' . $statusMsg . '") </script>';
    }
}
if (isset($_POST['verification_submit'])) {
    $agent_id = $_GET['agent_id'];
    $verification_image = $_FILES['identityImage'];
    $verification_image_name = $_FILES['identityImage']['name'];
    $sql = "UPDATE agents SET verification_image = '$verification_image_name' WHERE agent_id='$agent_id'";

    // directory path to folder for verification imaages
    $directoryPath = '../verification_images/agents_verification_images/' . $agent_id . '/';
    $verificationImageDestination = $directoryPath . $verification_image['name'];

    // checks if the folder exists
    if (!file_exists($directoryPath)) {
        // creates your folder
        if (mkdir($directoryPath, 0777, true)) {
            // uploads the file to the folder
            if (move_uploaded_file($verification_image['tmp_name'], $verificationImageDestination)) {
                // updates database
               
                if(mysqli_query($conn, $sql)){
                    header("refresh:$sec;  ./agent_profile.php?error=Verification Image Uploaded");
                    echo '<script type="text/javascript"> alert(Verification Image Upload) </script>';
                }else{
                    header("refresh:$sec;  ./agent_profile.php?error=SQL ERROR Failed To Update Database ");
                    echo '<script type="text/javascript"> alert(SQL ERROR Failed To Update Database ) </script>';
                }
            } else {
                header("refresh:$sec;  ./agent_profile.php?error=Error: Failed to upload Images ");
                echo '<script type="text/javascript"> alert(Error: Failed To Load Images ) </script>';
            }
        } else {
            header("refresh:$sec;  ./agent_profile.php?error=Failed To Make Your Directory");
            echo '<script type="text/javascript"> alert(Failed To Make Your Directory) </script>';
        }
    } else {
        header("refresh:$sec;  ./agent_profile.php?error=Your File ALready Exists");
        echo '<script type="text/javascript"> alert(Your File Already Exists) </script>';
    }
}
