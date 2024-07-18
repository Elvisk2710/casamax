<?php
$sec = "0.1";
$mailStatus = "failed";
//add database connection
require '../homerunphp/homerunuserdb.php';
require '../required/alerts.php';

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
        redirect('./agent_register.php?error=All Fields Are Required&firstname=' . $firstname);
    } else {
        if ($password !== $confirmpass) {
            redirect('./agent_register.php?error=Password Do No tMatch' . $firstname);
        } else {
            if (strlen($contact) > 12) {
                redirect('./agent_register.php?error=Enter Valid Phone Number' . $firstname);
            } else {
                $sql = "SELECT email FROM agents WHERE email = ?";
                $stmt = mysqli_stmt_init($conn);

                // preparing sql statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    redirect('./agent_register.php?error=SQL Error');
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $rowCount = mysqli_stmt_num_rows($stmt);

                    if ($rowCount > 0) {
                        redirect('./index.php?error=Email Already In Use');
                    } else {
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                        $subject = 'Agent Registration';
                        require '../required/sendMail.php';
                        echo $mailStatus;
                        if ($mailStatus == "success") {
                            redirect(' ../required/code_register.php?error=Verification Email Sent Successfully&agent=true');
                        } else {
                            redirect(' ./agent_register.php?error=Failed To Send Email!');
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
        $randomString = bin2hex(random_bytes(1)); // Generate a random string

        $agent_id = 'agent' . $timestamp . $randomString;
        $currentDate = date("Y-m-d");

        if (empty($tagline) or !isset($agent_fee) or empty($firstname) or empty($lastname) or empty($password) or empty($confirmpass) or empty($email) or empty($gender) or empty($contact) or empty($id_num)) {
            redirect(' ./agent_register.php?error=Empty Fields&firstname=" . $firstname');
        } else {
            // preparing sql statement
            $sql = "INSERT INTO agents (firstname, lastname, passw, email, sex, contact, id_num,agent_id, agent_fee,agent_tagline,date_joined ) VALUES ('$firstname', '$lastname', '$hashedpass', '$email', '$gender', '$contact', '$id_num', '$agent_id', '$agent_fee', '$tagline','$currentDate');";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                redirect(' ./agent_register.php?error=Sorry!! Failed To Register');
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

                redirect('  ./index.php?error=You Have Successfully Registered');
            }
            exit();
        }
    }
} else {
    redirect('  ../required/code_register.php?error=Sorry Code Does Not Match');
}
