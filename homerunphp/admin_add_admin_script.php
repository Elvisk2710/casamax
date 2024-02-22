<?php
$sec = 0.1;
if (isset($_POST['admin_create_profile'])) {

    $access_level_max = 3;
    // connection to database
    require 'advertisesdb.php';
    // initialising variables
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $idnum = $_POST['idnum'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirmpassword'];
    $access_level = $_POST['access_level'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_var($gender, FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $address = filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS);
    $idnum = filter_var($idnum, FILTER_SANITIZE_SPECIAL_CHARS);
    $access_level = filter_var($access_level, FILTER_SANITIZE_NUMBER_INT);

    if ($password !== $confirmPass) {
        header("refresh:$sec; ../admin/dashboard/index.php?error=passwordsdonotmatch" . $firstname);
        echo '<script type="text/javascript"> alert("Passwords Do Not Mtatch") </script>';
        exit();
    } else {
        $sql = "SELECT email FROM admin_table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("refresh:$sec; ../admin/dashboard/index.php?error=sqlerror");
            echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);
            if ($rowCount > 0) {
                header("refresh:$sec; ../admin/dashboard/index.php?error=userAlreadyExists");
                echo '<script type="text/javascript"> alert("User Already Exists") </script>';
                exit();
            } else {
                $hashedpass = password_hash($password, PASSWORD_DEFAULT);
                $timestamp = time(); // Current timestamp
                $randomString = bin2hex(random_bytes(4)); // Generate a random string
                $rand_num = rand(10, 100);

                if ($access_level >= 1  && $access_level <= $access_level_max) {
                    $admin_id =  "admin".'_'.$timestamp . '_'. $rand_num;

                    $sql = "INSERT INTO admin_table (first_name,last_name,id_num,passw,access_level,home_address,dob,sex,contact,email,admin_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                    if (!$stmt = mysqli_stmt_init($conn)) {
                        header("refresh:$sec; ../admin/dashboard/index.php?error=initFailure");
                        echo '<script type="text/javascript"> alert("SQL ERROR init failure") </script>';
                        exit();
                    } else {
                        
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("refresh:$sec; ../admin/dashboard/index.php?error=prepareFailed");
                            echo '<script type="text/javascript"> alert("SQL stmt prepare failure") </script>';
                            exit();
                        } else {
                            
                            if (!mysqli_stmt_bind_param($stmt, "ssssisssiss", $firstname, $lastname, $idnum, $password, $access_level, $address, $dob, $gender, $phone, $email, $admin_id)) {
                                header("refresh:$sec; ../admin/dashboard/index.php?error=initFailure");
                                echo '<script type="text/javascript"> alert("SQL ERROR binding stms failed") </script>';
                            } else {
                                if (!mysqli_stmt_execute($stmt)) {
                                    $error = mysqli_stmt_error($stmt);
                                    print("Error : " . $error);
                                    header("refresh:$sec; ../admin/dashboard/index.php?error=$error");
                                    echo '<script type="text/javascript"> alert("SQL ERROR execute failure") </script>';
                                } else {
                                    header("refresh:$sec; ../admin/dashboard/index.php?error=SuccessfullyAddedAdmin");
                                    echo '<script type="text/javascript"> alert("Adding Admin Agent Was Successful") </script>';
                                }
                            }
                        }
                    }
                } else {
                    header("refresh:$sec; ../admin/dashboard/index.php?error=accessLevelOutOfRange");
                    echo '<script type="text/javascript"> alert("Access Level Is Out Of Range") </script>';
                    exit();
                }
            }
        }
    }
}
