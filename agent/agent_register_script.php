<?php
$sec = "0.1";
$mailStatus = "failed";
//add database connection
require '../homerunphp/homerunuserdb.php';

if (isset($_POST['submit'])) {

    $tagline = $_POST['tagline'];
    $agent_fee = $_POST['agent_fee'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $confirmpass = $_POST['confirmpassword'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $id_num = $_POST['id_num'];

    $tagline = filter_var($tagline, FILTER_SANITIZE_SPECIAL_CHARS);
    $agent_fee = filter_var($agent_fee, FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $firstname = filter_var($firstname, FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($lastname, FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_var($gender, FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($contact, FILTER_SANITIZE_NUMBER_INT);
    $id_num = filter_var($id_num, FILTER_SANITIZE_SPECIAL_CHARS);


    // cookies for variables
    setcookie("tagline", $tagline, time() + (900 * 1), "/");
    setcookie("agent_fee", $agent_fee, time() + (900 * 1), "/");
    setcookie("firstname", $firstname, time() + (900 * 1), "/");
    setcookie("lastname", $lastname, time() + (900 * 1), "/");
    setcookie("password", $password, time() + (900 * 1), "/");
    setcookie("confirmpass", $confirmpass, time() + (900 * 1), "/");
    setcookie("email", $email, time() + (900 * 1), "/");
    setcookie("gender", $gender, time() + (900 * 1), "/");
    setcookie("contact", $contact, time() + (900 * 1), "/");
    setcookie("id_num", $id_num, time() + (900 * 1), "/");


    if (empty($tagline) or !isset($agent_fee) or empty($firstname) or empty($lastname) or empty($password) or empty($confirmpass) or empty($email) or empty($gender) or empty($contact) or empty($id_num)) {
        header("refresh:$sec; ./agent_register.php?error=Empty Fields&firstname=" . $firstname);
        exit();
    } else {
        if ($password !== $confirmpass) {
            header("refresh:$sec; ./agent_register.php?error=Password Do No tMatch" . $firstname);
            echo '<script type="text/javascript"> alert("Passwords Do Not Match") </script>';
            exit();
        } else {
            if (strlen($contact) > 12) {
                header("refresh:$sec;  ./agent_register.php?error=Enter Valid Phone Number" . $firstname);
                echo '<script type="text/javascript"> alert("Please Enter a Valid Phone Number") </script>';
                exit();
            } else {
                $sql = "SELECT email FROM agents WHERE email = ?";
                $stmt = mysqli_stmt_init($conn);

                // preparing sql statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("refresh:$sec;  ./agent_register.php?error=SQL Error");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $rowCount = mysqli_stmt_num_rows($stmt);

                    if ($rowCount > 0) {
                        header("refresh:$sec; ./index.php?error=Email Already In Use");
                        echo '<script type="text/javascript"> alert("OOPS! EMAIL ALREADY EXISTS, PLEASE LOGIN") </script>';
                        exit();
                    } else {
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                        $subject = 'Agent Registration';
                        require '../required/sendMail.php';
                        echo $mailStatus;
                        if ($mailStatus == "success") {
                            header("refresh:$sec; ../required/code_register.php?agent=true");
                        } else {
                            header("location: ./agent_register.php?error=Failed To Send Email!");
                        }
                        exit();
                    }
                }
            }
        }
    }
}
if (isset($_POST['register_code'])) {
    $code = $_POST['code'];
    // checking if the code is valid
    if ($code == $_COOKIE['code']) {
        require '../homerunphp/homerunuserdb.php';


        // preparing variables
        $tagline = $_COOKIE['tagline'];
        $agent_fee = $_COOKIE['agent_fee'];
        $email = $_COOKIE['email'];
        $firstname = $_COOKIE['firstname'];
        $lastname = $_COOKIE['lastname'];
        $password = $_COOKIE['password'];
        $confirmpass = $_COOKIE['confirmpass'];
        $gender = $_COOKIE['gender'];
        $contact = $_COOKIE['contact'];
        $id_num = $_COOKIE['id_num'];

        $hashedpass = password_hash($password, PASSWORD_DEFAULT);
        $timestamp = time(); // Current timestamp
        $randomString = bin2hex(random_bytes(8)); // Generate a random string
        $rand_num = rand(10, 10000);
        $truncated_text = substr($hashedpass, 0, 5);

        $agent_id = $timestamp . '_' . $randomString . '_' . $rand_num . '_' . $truncated_text;
        $currentDate = date("Y-m-d");

        if (empty($tagline) or !isset($agent_fee) or empty($firstname) or empty($lastname) or empty($password) or empty($confirmpass) or empty($email) or empty($gender) or empty($contact) or empty($id_num)) {
            header("refresh:$sec; ./agent_register.php?error=Empty Fields&firstname=" . $firstname);
            exit();
        } else {
            // preparing sql statement
            $sql = "INSERT INTO agents (firstname, lastname, passw, email, sex, contact, id_num,agent_id, agent_fee,agent_tagline,date_joined ) VALUES ('$firstname', '$lastname', '$hashedpass', '$email', '$gender', '$contact', '$id_num', '$agent_id', '$agent_fee', '$tagline','$currentDate');";

            $result = mysqli_query($conn, $sql);

            if (!$result) {

                echo '<script type="text/javascript"> alert("SORRY!! Failed to Register") </script>';
            } else {
                setcookie("tagline", $tagline, time() + (900 * 1), "/");
                setcookie("agent_fee", $agent_fee, time() + (900 * 1), "/");
                setcookie("firstname", $firstname, time() + (-900 * 1), "/");
                setcookie("lastname", $lastname, time() + (-900 * 1), "/");
                setcookie("password", $password, time() + (-900 * 1), "/");
                setcookie("confirmpass", $confirmpass, time() + (-900 * 1), "/");
                setcookie("gender", $gender, time() + (-900 * 1), "/");
                setcookie("contact", $contact, time() + (-900 * 1), "/");
                setcookie("id_num", $id_num, time() + (-900 * 1), "/");

                header("refresh:$sec; ./index.php?error=You Have Successfully Registered");
                echo '<script type="text/javascript"> alert("YOU HAVE SUCCESSFULLY REGISTERED!") </script>';
            }
            exit();
        }
    }
} else {

    header("Refresh:0.1, ../required/code_register.php");
    echo '<script type="text/javascript"> alert("SORRY YOUR CODE DOES NOT MATCH!!") </script>';
}
