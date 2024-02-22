<?php
session_start();
require '../homerunphp/advertisesdb.php';

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

if (isset($_SESSION['sessionagent'])) {

    $email = $_SESSION['sessionagent'];
    $agent_sql = "SELECT * FROM agents WHERE email = '$email' ";
    $result = mysqli_query($conn, $agent_sql);

    if (!$row = mysqli_fetch_array($result)) {
        header("refresh:$sec;  ./agent_profile.php?error=sqlerror");
        echo '<script type="text/javascript"> alert("SQL ERROR binding stms failed") </script>';
    } else {

        $agent_id = $row['agent_id'];

        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
        } else {
            $firstname = "";
        }

        if (!empty($_POST['firstname'])) {
            $lastname = $_POST['lastname'];
        } else {
            $lastname = "";
        }

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

        $price = $_POST['price'];
        $people = $_POST['people'];
        $gender = $_POST['gender'];
        $description = $_POST['description'];
        $uni = $_POST['university'];
        $spot = $_POST['spot'];
        $location = $_POST['location'];
        $email = $_SESSION['sessionagent'];
        $contact = '';

        $people = filter_var($people, FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
        $gender = filter_var($gender, FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
        $spot = filter_var($spot, FILTER_SANITIZE_NUMBER_INT);
        $location = filter_var($location, FILTER_SANITIZE_SPECIAL_CHARS);

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
        $timestamp = time(); // Current timestamp
        $randomString = bin2hex(random_bytes(4)); // Generate a random string
        $rand_num = rand(10, 1000);

        $home_id = $timestamp . '_' . $randomString . '_' . $rand_num;

        $sql = "INSERT INTO homerunhouses (home_id,email,firstname,lastname,contact,price,rules,uni,image1,image2,image3,image4,image5,image6,image7,image8,gender,kitchen,fridge,wifi,borehole,transport,people_in_a_room, agent_id, spots_available, home_location) VALUES (?,?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if (!$stmt = mysqli_stmt_init($conn)) {
            echo '<script type="text/javascript"> alert("SQL ERROR init failure") </script>';
            exit();
        } else {

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("refresh:$sec;  ./agent_profile.php?error=sqlerror");
                exit();
            } else {
                if (!mysqli_stmt_bind_param($stmt, "ssssiisssssssssssiiiiiisss", $home_id, $email, $firstname, $lastname,$contact, $price, $description, $uni, $image1, $image2, $image3, $image4, $image5, $image6, $image7, $image8, $gender, $kitchen, $fridge, $wifi, $borehole, $transport, $people, $agent_id, $spot, $location)) {
                    echo '<script type="text/javascript"> alert("SQL ERROR binding stms failed") </script>';
                } else {
                    if (!mysqli_stmt_execute($stmt)) {
                        $error = mysqli_stmt_error($stmt);
                        print("Error : " . $error);
                        echo '<script type="text/javascript"> alert("SQL ERROR execute failure") </script>';
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
                        header("refresh:$sec;  ./agent_profile.php?error=FileNotSupported");
                        echo '<script type="text/javascript"> alert("Some images were not uploaded due to unsupported images. Only JPG, JPEG, PNG files are currently supported")';
                    }
                    if ($status == 'success') {
                        header("refresh:$sec;  ./agent_profile.php?error=HomeAddedSuccessfuly");
                        echo '<script type="text/javascript"> alert("Images  Uploaded Successfully") </script>';
                    } else {
                        header("refresh:$sec;  ./agent_profile.php?error=FailedToUploadImages-FileNotSupported");
                        echo '<script type="text/javascript"> alert("Failed to upload pictures...") </script>';
                    }
                }
            }
        }
    }
}
if (isset($_POST['Update'])) {
    $home_id = $_GET['home_id'];
    $spot = $_POST['spot'];
    $available = $_POST['available'];
    $update_sql = "UPDATE homerunhouses SET spots_available = '$spot',available = '$available' WHERE home_id = '$home_id'";

    if (!mysqli_query($conn, $update_sql)) {
        header("location: ./agent_profile.php?error=FailedToUpdate");
        echo '<script type="text/javascript"> alert("Sorry! Failed to update info...") 
        </script>';
        exit();
    } else {
        header("location: ./agent_profile.php?message=updateSuccessful");
        echo '<script type="text/javascript"> alert("Your listing has been successfully updated...") 
        </script>';
    }
}
if (isset($_POST['delete'])) {
    $home_id = $_GET['home_id'];
    $sql = "DELETE FROM homerunhouses WHERE home_id = '$home_id'";
    $delete = mysqli_query($conn, $sql);
    if (!$delete) {
        header("location: ./agent_profile.php?error=Failed To Deleted");
        echo '<script type="text/javascript"> alert("Sorry! Failed to update info...") 
        </script>';
        exit();
    } else {
        header("location: ./agent_profile.php?error=Deleted");
        echo '<script type="text/javascript"> alert("Your listing has been successfully updated...") 
        </script>';
        exit();
    }
}
if (isset($_POST['edit_agent_info']) and isset($_SESSION['sessionagent'])) {

    $agent_id = $_COOKIE['agent_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $sql = "UPDATE agents SET  firstname = '$firstname',lastname = '$lastname',email = '$email', contact = '$contact' WHERE agent_id = '$agent_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['sessionagent'] = $email;
        header("refresh:$sec;  ./agent_profile.php?error=Updeate-Successful");
        echo '<script type="text/javascript"> alert("update successful") </script>';
        exit();
    } else {
        header("refresh:$sec;  ./agent_profile.php?error=Update-Failed");
        $error = mysqli_error($conn);
        print("Error : " . $error);
        echo '<script type="text/javascript"> alert("update fialed") </script>';
        exit();
    }
}
if (isset($_POST['edit_home']) and isset($_SESSION['sessionagent'])) {
    $home_id = $_GET['home_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $people = $_POST['people'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $uni = $_POST['university'];

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

    $add_home_sql = "UPDATE homerunhouses SET firstname= '$firstname', lastname = '$lastname', home_location = '$location', people_in_a_room = '$people', gender = '$gender', price = $price, rules = '$description', uni = '$uni', kitchen = '$kitchen', fridge = '$fridge', wifi = '$wifi', borehole = '$borehole', transport = '$transport' WHERE home_id = '$home_id' ";
    $result = mysqli_query($conn, $add_home_sql);
    if (!$result) {
        header("location: ./agent_profile.php?error=Update-Failed");
        echo mysqli_error($conn);
        echo '<script type="text/javascript"> alert("Your listing has failed to update...") 
            </script>';
        exit();
    } else {
        header("location: ./agent_profile.php?error=Update-successful");
        echo '<script type="text/javascript"> alert("Your listing has been successfully updated...") 
            </script>';
        exit();
    }
}
