<?php
$sec = "0.1";
// Add database connection
require 'homerunuserdb.php';

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $confirmpass = $_POST['confirmpassword'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $uni = $_POST['university'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_var($gender, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($contact, FILTER_SANITIZE_NUMBER_INT);

    if (empty($firstname) || empty($lastname) || empty($password) || empty($confirmpass) || empty($email) || empty($dob) || empty($gender) || empty($contact) || $uni === "none") {
        header("refresh:$sec;  ../signup.php?error=emptyfields&firstname=" . urlencode($firstname));
        exit();
    } elseif ($password !== $confirmpass) {
        header("refresh:$sec; ../signup.php?error=Passwwords Do Not Match&firstname=" . urlencode($firstname));
        exit();
    } else {
        $sql = "SELECT email FROM homerunuserdb WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        // Preparing SQL statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("refresh:$sec;  ../signup.php?error=SQL Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);

            if ($rowCount > 0) {
                header("refresh:$sec; ../signup.php?error=Email Already In Use");
                echo '<script type="text/javascript"> alert("OOPS! EMAIL ALREADY EXISTS") </script>';
                exit();
            } else {
                $hashedpass = password_hash($password, PASSWORD_DEFAULT);

                $lastid = mysqli_insert_id($conn); 
                $randcode = rand(1, 99999);
                $uni_code = ''; // Initialize the variable

                switch ($uni) {
                    case "University of Zimbabwe":
                        $uni_code = "uz";
                        break;
                    case "Midlands State University":
                        $uni_code = "msu";
                        break;
                    case "Africa University":
                        $uni_code = "au";
                        break;
                    case "Bindura State University":
                        $uni_code = "bsu";
                        break;
                    case "Chinhoyi University of Science and Technology":
                        $uni_code = "cut";
                        break;
                    case "Great Zimbabwe University":
                        $uni_code = "gzu";
                        break;
                    case "Harare Institute of Technology":
                        $uni_code = "hit";
                        break;
                    case "National University of Science and Technology":
                        $uni_code = "nust";
                        break;
                }

                if (empty($uni_code)) {
                    header("refresh:$sec; ./signup.php?FailedToGenerateID");
                    echo '<script type="text/javascript"> alert("Sorry Failed To Generate Agent ID!") </script>';
                    exit();
                }

                $userid = $uni_code . "_" . $randcode . "_" . $lastid;
                $sql = "INSERT INTO homerunuserdb (firstname, lastname, passw, email, dob, sex, contact, university, userid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sssssssss", $firstname, $lastname, $hashedpass, $email, $dob, $gender, $contact, $uni, $userid);
                    if (mysqli_stmt_execute($stmt)) {
                        header("refresh:$sec; ../login.php?You Have Successfully Registered");
                        echo '<script type="text/javascript"> alert("YOU HAVE SUCCESSFULLY REGISTERED!") </script>';
                        exit();
                    } else {
                        header("refresh:$sec; ./signup.php?Failed To Generate ID");
                        echo '<script type="text/javascript"> alert("Sorry Failed to generate agent ID!") </script>';
                        exit();
                    }
                } else {
                    header("refresh:$sec; ./signup.php?Failed To Generate ID");
                    echo '<script type="text/javascript"> alert("Sorry Failed to generate agent ID!") </script>';
                    exit();
                }
            }
        }
    }
}