<?php
session_start();
require 'advertisesdb.php';
include '../required/alerts.php';
require '../required/common_functions.php';

if (isset($_POST['create_profile']) && isset($_SESSION['sessionAdmin'])) {

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

    if (!empty($_FILES['identityImage']['name']) || !empty($_FILES['residencyImage']['name'])) {
        $admin_id = ($_SESSION['sessionAdmin']);
        // identity image
        $identityImages = $_FILES['identityImage'];
        // residencial proof image
        $residencyImages = $_FILES['residencyImage'];

        // declaring variables
        $firstname = sanitize_string($_POST['firstname']);
        $lastname = sanitize_string($_POST['lastname']);
        $phone = sanitize_integer($_POST['phone']);
        $email = sanitize_email($_POST['email']);
        $idnum = sanitize_string($_POST['idnum']);
        $price = sanitize_integer($_POST['price']);
        $address = sanitize_string($_POST['address']);
        $people = sanitize_integer($_POST['people']);
        $gender = sanitize_string($_POST['gender']);
        $description = sanitize_string($_POST['description']);
        $uni = sanitize_string($_POST['university']);
        $password = $_POST['password'];
        $confirmpass = $_POST['confirmpassword'];

        // Ensure all required fields are sanitized and validated
        if (
            $phone === false || $people === false || $email === false ||
            $firstname === false || $lastname === false || $idnum === false ||
            $price === false || $address === false || $description === false ||
            $gender === false || $uni === false || $admin_id === false || $count < 1
        ) {
            redirect("../admin/dashboard/index.php?error=Invalid input data");
            exit();
            exit();
        } else {

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
                redirect("../admin/dashboard/index.php?error=Passwords Do Not Match" . $firstname);
                exit();
            } else {
                $sql = "SELECT email FROM homerunhouses WHERE email = ?";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    redirect("../admin/dashboard/index.php?error=SQL Error");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $email);$sql_home = "SELECT * FROM agents WHERE verified != '1' OR verification_image IS NOT NULL";
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $rowCount = mysqli_stmt_num_rows($stmt);

                    if ($rowCount > 0) {
                        redirect(" ../admin/dashboard/index.php?error=User Already Exists");
                        exit();
                    } else {

                        $hashedpass = password_hash($password, PASSWORD_DEFAULT);
                        $timestamp = time(); // Current timestamp
                        $randomString = bin2hex(random_bytes(2)); // Generate a random string
                        $rand_num = rand(1, 100);
                        $truncated_text = substr($hashedpass, 0, 5);

                        $home_id = $timestamp . $randomString . $rand_num;
                        $home_id = preg_replace('/[^0-9]/', '', $home_id);

                        $sql = "INSERT INTO homerunhouses (home_id,email,firstname,lastname,contact,idnum,price,rules,uni,image1,image2,image3,image4,image5,image6,image7,image8,gender,kitchen,fridge,wifi,borehole,transport,adrs,people_in_a_room,passw,admin_id,id_image,res_image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        if (!$stmt = mysqli_stmt_init($conn)) {
                            redirect(" ../admin/dashboard/index.php?error=SQL Error Init Failed");
                            exit();
                        } else {
                            // directory path to folder for verification images
                            $directoryPath = '../verification_images/home_verification_images/' . $home_id . '/';
                            $identityFileDestination = $directoryPath . $identityImages['name'];
                            $residencyFileDestination = $directoryPath . $residencyImages['name'];

                            // Create the directory
                            if (!file_exists($directoryPath)) {
                                if ($count <= 0) {
                                    redirect(" ../admin/dashboard/index.php?error=Profile Created!! NO images have been uploaded. Please go to your profile page and upload images");
                                    exit();
                                } else {
                                    if (mkdir($directoryPath, 0777, true)) {
                                        // upload verification images
                                        if (move_uploaded_file($residencyImages['tmp_name'], $residencyFileDestination) && move_uploaded_file($identityImages['tmp_name'], $identityFileDestination)) {
                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                redirect(" ../admin/dashboard/index.php?error=Stmt Prepare Error");
                                                exit();
                                            } else {
                                                if (!mysqli_stmt_bind_param($stmt, "ssssisisssssssssssiiiiisissss", $home_id, $email, $firstname, $lastname, $phone, $idnum, $price, $description, $uni, $image1, $image2, $image3, $image4, $image5, $image6, $image7, $image8, $gender, $kitchen, $fridge, $wifi, $borehole, $transport, $address, $people, $hashedpass, $admin_id, $identityImages['name'], $residencyImages['name'])) {
                                                    redirect(" ../admin/dashboard/index.php?error=SQL ERROR binding stms failed");
                                                    exit();
                                                } else {
                                                    if (!mysqli_stmt_execute($stmt)) {
                                                        $error = mysqli_stmt_error($stmt);
                                                        redirect(" ../admin/dashboard/index.php?error=$error");
                                                        exit();
                                                    } else {
                                                        // check if there are any pictures
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
                                                        } elseif ($uni === "Africa University") {
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
                                                                require '../homerunphp/upload.php';
                                                            }
                                                        } elseif ($uni === "National University of Science and Technology") {
                                                            for ($num = 0; $num < $count; $num++) {
                                                                $imageUploadPath = '../housepictures/nustpictures/' . basename($_FILES["$name"]["name"][$num]);
                                                                require '../homerunphp/upload.php';
                                                            }
                                                        } else {
                                                            redirect(" ../admin/dashboard/index.php?error=Error While Uploading");
                                                            exit();
                                                        }

                                                        if ($status != 'success') {
                                                            redirect("  ../admin/dashboard/index.php?error=$statusMsg");
                                                            exit();
                                                        } else {
                                                            redirect("../admin/dashboard/index.php?error=Profile Created");
                                                            exit();
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            redirect(" ../admin/dashboard/index.php?error=Failed To Move Images");
                                            exit();
                                        }
                                    } else {
                                        redirect(" ../admin/dashboard/index.php?error=Failed To Make Directory");
                                        exit();
                                    }
                                }
                            } else {
                                redirect("../admin/dashboard/index.php?error=Directory Already Exists");
                                exit();
                            }
                        }
                    }
                }
            }
        }
    } else {
        redirect("../admin/dashboard/index.php?error=No Verification Images");
        exit();
    }
} else {
    redirect("../admin/index.php?error=Please Login");
    exit();
}
