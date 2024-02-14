<?php
session_start();
require 'advertisesdb.php';

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

    // Return compressed image 
    return $destination;
}

$sec = "0.1";
if (isset($_POST['create_profile'])) {

    $name = "image";
    $countfiles = 8;
    $count = 0;
    for ($i = 0; $i < $countfiles; $i++) {
        switch ($i) {
            case 0:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image1 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image1 = "";
                }
                break;
            case 1:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image2 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image2 = "";
                }
                break;
            case 2:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image3 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image3 = "";
                }
                break;
            case 3:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image4 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image4 = "";
                }
                break;
            case 4:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image5 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image5 = "";
                }
                break;
            case 5:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image6 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image6 = "";
                }
                break;
            case 6:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image7 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image7 = "";
                }
                break;
            case 7:
                if (!empty($_FILES['image']['name'][$i])) {
                    $image8 = $_FILES['image']['name'][$i];
                    $count++;
                } else {
                    $image8 = "";
                }
                break;
        }
    }

    if (!empty($_FILES['identityImage']['name']) || !empty($_FILES['residencyImage']['name']) || !empty($_POST['admin_id'])) {
        $admin_id = $_POST['admin_id'];
        // identity image
        $identityImages = $_FILES['identityImage'];
        // residencial proof image
        $residencyImages = $_FILES['residencyImage']; 

        // declaring variables
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $idnum = $_POST['idnum'];
        $price = $_POST['price'];
        $address = $_POST['address'];
        $people = $_POST['people'];
        $gender = $_POST['gender'];
        $description = $_POST['description'];
        $uni = $_POST['university'];
        $password = $_POST['password'];
        $confirmpass = $_POST['confirmpassword'];

        $people = filter_var($people, FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
        $gender = filter_var($gender, FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
        $description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $address = filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS);
        $idnum = filter_var($idnum, FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($_POST['kitchen'])) {
            $kitchen = 1;
        } else {
            $kitchen = 0;
        }
        if (!empty($_POST['fridge'])) {
            $fridge = 1;
        } else {
            $fridge = 0;
        }
        if (!empty($_POST['wifi'])) {
            $wifi = 1;
        } else {
            $wifi = 0;
        }
        if (!empty($_POST['borehole'])) {
            $borehole = 1;
        } else {
            $borehole = 0;
        }
        if (!empty($_POST['transport'])) {
            $transport = 1;
        } else {
            $transport = 0;
        }

        // making the directory for pictures and all the information


        if ($password !== $confirmpass) {
            header("refresh:$sec; ../admin/dashboard/index.php?error=passwordsdonotmatch" . $firstname);
            echo '<script type="text/javascript"> alert("Passwords Do Not Mtatch") </script>';
            exit();
        } else {
            $sql = "SELECT email FROM homerunhouses WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("refresh:$sec;  ../admin/dashboard/index.php?error=sqlerror");
                echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);

                if ($rowCount > 0) {
                    header("refresh:$sec;  ../admin/dashboard/index.php?error=usernamealreadyexists");
                    echo '<script type="text/javascript"> alert("User Already Exists") </script>';
                    exit();
                } else {

                    $hashedpass = password_hash($password, PASSWORD_DEFAULT);
                    $timestamp = time(); // Current timestamp
                    $randomString = bin2hex(random_bytes(4)); // Generate a random string
                    $rand_num = rand(10, 1000);
                    $trancated_text = substr($hashedpass, 0, 5);

                    $home_id = $timestamp . '_' . $randomString . '_' . $rand_num . '_' . $trancated_text;

                    $sql = "INSERT INTO homerunhouses (home_id,email,firstname,lastname,contact,idnum,price,rules,uni,image1,image2,image3,image4,image5,image6,image7,image8,gender,kitchen,fridge,wifi,borehole,transport,adrs,people_in_a_room,passw,admin_id,id_image,res_image) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
                    if (!$stmt = mysqli_stmt_init($conn)) {
                        echo '<script type="text/javascript"> alert("SQL ERROR init failure") </script>';
                        exit();
                    } else {
                        // directory path to folder for verification imaages
                        $directoryPath = '../verification_images/' . $home_id .'/';
                        $identityFileDestination = $directoryPath.$identityImages['name'];
                        $residencyFileDestination = $directoryPath.$residencyImages['name'];

                        // Create the directory
                        if (!file_exists($directoryPath)) {
                            if (mkdir($directoryPath, 0777, true)) {
                                // upload verification images
                                if (move_uploaded_file($residencyImages['tmp_name'],$residencyFileDestination) && move_uploaded_file($identityImages['tmp_name'],$identityFileDestination)) {
                                    echo "Directory created successfully.";
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("refresh:$sec;  ../admin/dashboard/index.php?error=sqlerror");
                                        exit();
                                    } else {
                                        if (!mysqli_stmt_bind_param($stmt, "ssssisisssssssssssiiiiisissss", $home_id, $email, $firstname, $lastname, $phone, $idnum, $price, $description, $uni, $image1, $image2, $image3, $image4, $image5, $image6, $image7, $image8, $gender, $kitchen, $fridge, $wifi, $borehole, $transport, $address, $people, $hashedpass, $admin_id,$identityImages['name'],$residencyImages['name'])) {
                                            echo '<script type="text/javascript"> alert("SQL ERROR binding stms failed") </script>';
                                        } else {
                                            if (!mysqli_stmt_execute($stmt)) {
                                                $error = mysqli_stmt_error($stmt);
                                                print("Error : " . $error);
                                                echo '<script type="text/javascript"> alert("SQL ERROR execute failure") </script>';
                                            } else {

                                                if ($count <= 0) {
                                                    header("location:../admin/dashboard/index.php?error=Profilecreated");
                                                    $_SESSION['sessionowner'] = $email;
                                                    echo '<script type="text/javascript"> alert("NO images have been uploaded. Please go toyour profile page and upload images") 
                                                                        </script>';
                                                    exit();
                                                } else {

                                                    $status = 'failed';
                                                    if ($uni === "University of Zimbabwe") {
                                                        for ($num = 0; $num < $count; $num++) {
                                                            $imageUploadPath = '../housepictures/uzpictures/' . basename($_FILES["$name"]["name"][$num]);
                                                            require '../homerunphp/upload.php';
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
                                                if ($statusMsg == 'error') {
                                                    echo '<script type="text/javascript"> alert("Some images were not uploaded due to unsupported images. Only JPG, JPEG, PNG files are currently supported")';
                                                } elseif ($status == 'success') {
                                                    header("location:../admin/dashboard/index.php?error=Profilecreated");
                                                    $_SESSION['sessionowner'] = $email;
                                                    echo '<script type="text/javascript"> alert("Images  Uploaded Successfully") </script>';
                                                    exit();
                                                } else {
                                                    header("location:../admin/dashboard/index.php?error=Profilecreated");
                                                    $_SESSION['sessionowner'] = $email;
                                                    echo '<script type="text/javascript"> alert("NO images have been uploaded. Please go toyour profile page and upload images") 
                                                                            </script>';
                                                    exit();
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    header("location:../admin/dashboard/index.php?error=FailedToMoveImages");
                                    echo '<script type="text/javascript"> alert("Verification Images Failed") </script>';
                                    exit();
                                }
                            } else {
                                header("location:../admin/dashboard/index.php?error=FailedToCreateDirectoryForVerification");
                                echo '<script type="text/javascript"> alert("Failed to create directory") </script>';
                                exit();
                            }
                        } else {
                            header("location:../admin/dashboard/index.php?error=DirectoryAlreadyExists");
                            echo '<script type="text/javascript"> alert("Directory Already Exists") </script>';
                            exit();
                        }
                    }
                }
            }
        }
    } else {
        header("location:../admin/dashboard/index.php?error=NoVerificationImages");
        echo '<script type="text/javascript"> alert("NO images have been submitted for verification") 
</script>';
    }
}
