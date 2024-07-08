<?php
$sec = 0.1;
include '../required/alerts.php';

if (isset($_POST['admin_create_profile'])) {
    $access_level_max = 3;

    // Connection to the database
    require 'advertisesdb.php';

    // Initialize variables
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

    // Sanitize input data
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_var($gender, FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $address = filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS);
    $idnum = filter_var($idnum, FILTER_SANITIZE_SPECIAL_CHARS);
    $access_level = filter_var($access_level, FILTER_SANITIZE_NUMBER_INT);

    if ($password !== $confirmPass) {
        redirect(" ../admin/dashboard/index.php?error=Passwords DO Not Match" . $firstname);
    } else {

        $sql = "SELECT email FROM admin_table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            redirect(" ../admin/dashboard/index.php?error=SQL ERROR");
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $rowCount = mysqli_stmt_num_rows($stmt);
        if ($rowCount > 0) {
            redirect(" ../admin/dashboard/index.php?error=User Already ExistsR");
        }

        $hashedpass = password_hash($password, PASSWORD_DEFAULT);
        $timestamp = time(); // Current timestamp
        $randomString = bin2hex(random_bytes(4)); // Generate a random string
        $rand_num = rand(10, 100);

        if ($access_level >= 1  && $access_level <= $access_level_max) {
            $admin_id =  "admin" . $timestamp . $rand_num;

            $sql = "INSERT INTO admin_table (first_name,last_name,id_num,passw,access_level,home_address,dob,sex,contact,email,admin_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                redirect(" ../admin/dashboard/index.php?error=Stmt Prepare Failed");
            }

            mysqli_stmt_bind_param($stmt, "ssssisssiss", $firstname, $lastname, $idnum, $hashedpass, $access_level, $address, $dob, $gender, $phone, $email, $admin_id);
            if (!mysqli_stmt_execute($stmt)) {
                $error = mysqli_stmt_error($stmt);
                redirect(" ../admin/dashboard/index.php?error=$error");
            }
            redirect(" ../admin/dashboard/index.php?error=Successfully Added Admin");
        } else {
            redirect("../admin/dashboard/index.php?error=Access Level Out Of Range");
        }
    }
}
