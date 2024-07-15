<?php
session_start();
require 'advertisesdb.php';
include '../required/alerts.php';
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

    if (!empty($_FILES['identityImage']['name']) || !empty($_FILES['residencyImage']['name']) || $count = 0) {
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
            redirect("../advertise/index.php?error=Passwords Do Not Match");
        } else {
            $sql = "SELECT email FROM homerunhouses WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                redirect(" ../advertise/index.php?error=SQL Error");
            } else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);

                if ($rowCount > 0) {
                    redirect(" ../advertise/index.php?error=User Name Already Exists");
                } else {
                    $hashedpass = password_hash($password, PASSWORD_DEFAULT);
                    $timestamp = time(); // Current timestamp
                    $randomString = bin2hex(random_bytes(2)); // Generate a random string
                    $rand_num = rand(1, 100);
                    $trancated_text = substr($hashedpass, 0, 5);

                    $home_id = $timestamp . $randomString . $rand_num;
                    $home_id = preg_replace('/[^0-9]/', '', $home_id);


                    $sql = "INSERT INTO homerunhouses (home_id,email,firstname,lastname,contact,idnum,price,rules,uni,image1,image2,image3,image4,image5,image6,image7,image8,gender,kitchen,fridge,wifi,borehole,transport,adrs,people_in_a_room,passw,id_image,res_image) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
                    if (!$stmt = mysqli_stmt_init($conn)) {
                        redirect("../advertise/index.php?error=Init Failure");
                    } else {
                        // directory path to folder for verification imaages
                        $directoryPath = '../verification_images/home_verification_images/' . $home_id . '/';
                        $identityFileDestination = $directoryPath . $identityImages['name'];
                        $residencyFileDestination = $directoryPath . $residencyImages['name'];

                        if (!file_exists($directoryPath)) {
                            if (mkdir($directoryPath, 0777, true)) {
                                if (move_uploaded_file($residencyImages['tmp_name'], $residencyFileDestination) && move_uploaded_file($identityImages['tmp_name'], $identityFileDestination)) {
                                    echo "Directory created successfully.";
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        redirect("../advertise/index.php?error=SQL Error");
                                    } else {
                                        if (!mysqli_stmt_bind_param($stmt, "ssssisisssssssssssiiiiisisss", $home_id, $email, $firstname, $lastname, $phone, $idnum, $price, $description, $uni, $image1, $image2, $image3, $image4, $image5, $image6, $image7, $image8, $gender, $kitchen, $fridge, $wifi, $borehole, $transport, $address, $people, $hashedpass, $identityImages['name'], $residencyImages['name'])) {
                                            redirect("../advertise/index.php?error=Bind Param Failure");
                                        } else {
                                            if (!mysqli_stmt_execute($stmt)) {
                                                $error = mysqli_stmt_error($stmt);
                                                print("Error : " . $error);
                                                redirect("../advertise/index.php?error=$error");
                                            } else {
                                                if ($count <= 0) {
                                                    redirect("../advertise/index.php?error=NO images have been uploaded. Please Try Again");
                                                } else {

                                                    $status = 'failed';
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
                                                    }

                                                    if (!empty($uploadPath)) {
                                                        for ($num = 0; $num < $count; $num++) {
                                                            $imageUploadPath = $uploadPath . basename($_FILES["$name"]["name"][$num]);
                                                            require '../homerunphp/upload.php';
                                                            echo $num;
                                                        }
                                                        $_SESSION['sessionowner'] = $home_id;
                                                        redirect("../profile.php?error=Images Uploaded successfully");
                                                    } else {
                                                        redirect("../advertise/index.php?error=NO images have been uploaded. Please Try Again");
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    redirect("../advertise/index.php?error=Failed To Move Images");
                                }
                            } else {
                                redirect("../advertise/index.php?error=Failed To Create Directory For Verification");
                            }
                        } else {
                            redirect("../advertise/index.php?error=Directory Already Exists");
                        }
                    }
                }
            }
        }
    } else {
        redirect("../advertise/index.php?error=Please Upload The Required Documents");
    }
} else {
    redirect("../ndex.php?error=Access Denied");
}
