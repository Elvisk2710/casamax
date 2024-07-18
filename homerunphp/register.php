<?php
$sec = "0.1";
// Add database connection
require 'homerunuserdb.php';
require '../required/alerts.php';
require '../required/common_functions.php';

if (isset($_POST['submit'])) {
    $firstname = sanitize_string($_POST['firstname']);
    $lastname = sanitize_string($_POST['lastname']);
    $password = $_POST['password'];
    $confirmpass = $_POST['confirmpassword'];
    $email = sanitize_email($_POST['email']);
    $dob = $_POST['dob'];
    $gender = sanitize_string($_POST['gender']);
    $contact = sanitize_integer($_POST['contact']);
    $uni = $_POST['university'];

    if (empty($firstname) || empty($lastname) || empty($password) || empty($confirmpass) || empty($email) || empty($dob) || empty($gender) || empty($contact) || $uni === "none") {
        redirect("../signup.php?error=emptyfields&firstname=" . urlencode($firstname));
        exit();
    } elseif ($password !== $confirmpass) {
        redirect("../signup.php?error=Passwords Do Not Match&firstname=" . urlencode($firstname));
        exit();
    } else {
        // Check if email already exists
        $sql = "SELECT email FROM homerunuserdb WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            redirect("refresh:$sec; ../signup.php?error=SQL Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);

            if ($rowCount > 0) {
                redirect("../signup.php?error=Email Already In Use");
                exit();
            } else {
                // Generate university code
                $uni_code = generateUniCode($uni);

                if (empty($uni_code) || $uni_code == null) {
                    redirect("../signup.php?error=Failed To Generate ID");
                    exit();
                }

                // Generate user ID
                $randcode = rand(1, 99999);
                $lastid = mysqli_insert_id($conn); // Ensure you have the last inserted ID if needed
                $userid = $uni_code . $randcode . $lastid;

                // Hash password
                $hashedpass = password_hash($password, PASSWORD_DEFAULT);

                // Prepare SQL statement
                $sql = "INSERT INTO homerunuserdb (firstname, lastname, passw, email, dob, sex, contact, university, userid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sssssssss", $firstname, $lastname, $hashedpass, $email, $dob, $gender, $contact, $uni, $userid);
                    if (mysqli_stmt_execute($stmt)) {
                        redirect("../login.php?success=You Have Successfully Registered");
                        exit();
                    } else {
                        redirect("../signup.php?error=Failed To Register User");
                        exit();
                    }
                } else {
                    redirect("../signup.php?error=SQL Error");
                    exit();
                }
            }
        }
    }
}
