<?php
$sec = "0.1";
// Add database connection
require 'homerunuserdb.php';

if (isset($_POST['register_code'])) {
    $code = $_POST['code'];

    // Checking if the code is valid
    if ($code == $_COOKIE['code']) {

        // Preparing variables
        $email = $_COOKIE['email'];
        $firstname = $_COOKIE['firstname'];
        $lastname = $_COOKIE['lastname'];
        $password = $_COOKIE['password'];
        $confirmpass = $_COOKIE['confirmpass'];
        $dob = $_COOKIE['dob'];
        $gender = $_COOKIE['gender'];
        $contact = $_COOKIE['contact'];
        $uni = $_COOKIE['uni'];

        $lastid = mysqli_insert_id($conn); 

        $randcode = rand(1, 99999);
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
            header("refresh:$sec; ./required/code_register.php?FailedToGenerateID");
            echo '<script type="text/javascript"> alert("Sorry Failed to generate agent ID!") </script>';
            exit();
        }

        $userid = $uni_code . "_" . $randcode . "_" . $lastid;

        $sql = "INSERT INTO homerunuserdb (userid, firstname, lastname, passw, email, dob, sex, contact, university) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            $hashedpass = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssssssss", $userid, $firstname, $lastname, $hashedpass, $email, $dob, $gender, $contact, $uni);
            if (mysqli_stmt_execute($stmt)) {
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
                header("refresh:$sec; ../login.php?youhavesuccessfullyregistered");
                echo '<script type="text/javascript"> alert("YOU HAVE SUCCESSFULLY REGISTERED!") </script>';
                exit();
            } else {
                header("refresh:$sec; ./required/code_register.php?FailedToGenerateID");
                echo '<script type="text/javascript"> alert("Sorry Failed to generate agent ID!") </script>';
                exit();
            }
        } else {
            header("refresh:$sec; ./required/code_register.php?FailedToGenerateID");
            echo '<script type="text/javascript"> alert("Sorry Failed to generate agent ID!") </script>';
            exit();
        }
    } else {
        header("Refresh:0.1, ../required/code_register.php");
        echo '<script type="text/javascript"> alert("SORRY YOUR CODE DOES NOT MATCH!!") </script>';
    }
}
?>