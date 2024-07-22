<?php
$sec = 0.1;
require '../required/alerts.php';

if (isset($_POST['admin_create_profile'])) {
    $access_level_max = 3;

    // Connection to the database
    require 'advertisesdb.php';

    // Include sanitization functions
    require '../required/common_functions.php';

    // Initialize variables
    $firstname = sanitize_string($_POST['firstname']);
    $lastname = sanitize_string($_POST['lastname']);
    $phone = sanitize_integer($_POST['phone']);
    $email = sanitize_email($_POST['email']);
    $idnum = sanitize_string($_POST['idnum']);
    $password = $_POST['password'];
    $confirmPass = $_POST['confirmpassword'];
    $access_level = sanitize_integer($_POST['access_level']);
    $address = sanitize_string($_POST['address']);
    $dob = sanitize_string($_POST['dob']);
    $gender = sanitize_string($_POST['gender']);

    // Ensure all required fields are sanitized and validated
    if (
        $phone === false || $access_level === false || $email === false ||
        $firstname === false || $lastname === false || $idnum === false ||
        $address === false || $dob === false || $gender === false
    ) {
        redirect("../admin/dashboard/index.php?error=Invalid input data");
        exit();
    } else {

        if ($password !== $confirmPass) {
            redirect("../admin/dashboard/index.php?error=Passwords Do Not Match");
            exit();
        } else {
            $sql = "SELECT email FROM admin_table WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                redirect("../admin/dashboard/index.php?error=SQL ERROR");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);

            if ($rowCount > 0) {
                redirect("../admin/dashboard/index.php?error=User Already Exists");
                exit();
            }

            $hashedpass = password_hash($password, PASSWORD_DEFAULT);
            $timestamp = time(); // Current timestamp
            $randomString = bin2hex(random_bytes(2)); // Generate a random string

            if ($access_level >= 1 && $access_level <= $access_level_max) {
                $admin_id = "admin" . $timestamp . $randomString;
                $sql = "INSERT INTO admin_table (first_name, last_name, id_num, passw, access_level, home_address, dob, sex, contact, email, admin_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    redirect("../admin/dashboard/index.php?error=Stmt Prepare Failed");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "ssssisssiss", $firstname, $lastname, $idnum, $hashedpass, $access_level, $address, $dob, $gender, $phone, $email, $admin_id);

                if (!mysqli_stmt_execute($stmt)) {
                    $error = mysqli_stmt_error($stmt);
                    redirect("../admin/dashboard/index.php?error=$error");
                    exit();
                }

                redirect("../admin/dashboard/index.php?error=Successfully Added Admin");
                exit();
            } else {
                redirect("../admin/dashboard/index.php?error=Access Level Out Of Range");
                exit();
            }
        }
    }
}
