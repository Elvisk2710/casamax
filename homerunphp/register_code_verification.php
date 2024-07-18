<?php
$sec = "0.1";
// Add database connection
require 'homerunuserdb.php';
require '../required/alerts.php';
require '../required/common_functions.php';

if (isset($_POST['register_code'])) {
    $code = $_POST['code'];

    // Sanitize code input
    $code = sanitize_string($code);

    // Checking if the code is valid
    if ($code == $_COOKIE['code']) {

        // Sanitize and validate other inputs
        $email = sanitize_email($_COOKIE['email']);
        $firstname = sanitize_string($_COOKIE['firstname']);
        $lastname = sanitize_string($_COOKIE['lastname']);
        $password = $_COOKIE['password'];
        $confirmpass = $_COOKIE['confirmpass'];
        $dob = $_COOKIE['dob'];
        $gender = sanitize_string($_COOKIE['gender']);
        $contact = sanitize_integer($_COOKIE['contact']);
        $uni = sanitize_string($_COOKIE['uni']);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect("../required/code_register.php?error=Invalid Email Format");
            exit();
        }

        // Validate password and confirm password match
        if ($password !== $confirmpass) {
            redirect("../required/code_register.php?error=Passwords Do Not Match");
            exit();
        }

        // Generate university code based on selected university
        $uni_code = generateUniCode($uni);
        if ($uni_code == null) {
            redirect("../required/code_register.php?error=Invalid University Selection");
            exit();
        } else {

            // Generate user ID
            $randcode = rand(1, 99999);
            $lastid = mysqli_insert_id($conn); // Ensure you have the last inserted ID if needed
            $userid = $uni_code . $randcode . $lastid;

            // Hash password
            $hashedpass = password_hash($password, PASSWORD_DEFAULT);

            // Prepare SQL statement
            $sql = "INSERT INTO homerunuserdb (userid, firstname, lastname, passw, email, dob, sex, contact, university) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                // Bind parameters and execute statement
                mysqli_stmt_bind_param($stmt, "sssssssss", $userid, $firstname, $lastname, $hashedpass, $email, $dob, $gender, $contact, $uni);
                if (mysqli_stmt_execute($stmt)) {
                    // Clear cookies and close statement
                    setcookie("firstname", "", time() - 900, "/");
                    setcookie("lastname", "", time() - 900, "/");
                    setcookie("password", "", time() - 900, "/");
                    setcookie("confirmpass", "", time() - 900, "/");
                    setcookie("email", "", time() - 900, "/");
                    setcookie("dob", "", time() - 900, "/");
                    setcookie("gender", "", time() - 900, "/");
                    setcookie("contact", "", time() - 900, "/");
                    setcookie("uni", "", time() - 900, "/");
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    redirect("../login.php?error=You Have Successfully Registered");
                } else {
                    redirect("../required/code_register.php?error=Failed To Register User");
                }
            } else {
                redirect("../required/code_register.php?error=SQL Error");
            }
        }
    } else {
        redirect("../required/code_register.php?error=Invalid Verification Code");
    }
}
