<?php
session_start();
$sec = "0.1";
require 'homerunuserdb.php';
require '../required/common_functions.php';
include '../required/alerts.php';

if (isset($_POST['submit'])) {
    if (isset($_GET['redirect'])) {
        $redirect = $_GET['redirect'];
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (empty($email) || empty($password)) {
        redirect("../login.php?error=All Fields Are Required");
        exit();
    } else {
        // Usage example
        $responseJson = loginUserStudent($email, $password);
        $response = json_decode($responseJson, true);
        if ($response['status'] == 'success') {
            echo 'Login successful! User ID: ' . $response['user_id'];
            $userid = $response['user_id'];
            $uni = $response['university'];
            session_destroy();
            session_start();
            $_SESSION['sessionstudent'] =  $response['user_id'];
            echo $userid;
            // Redirect based on university
            $universityMapping = array(
                "University of Zimbabwe" => "../unilistings/uzlisting.php",
                "Midlands State University" => "../unilistings/msulisting.php",
                "Africa University" => "../unilistings/aulisting.php",
                "Bindura State University" => "../unilistings/bsulisting.php",
                "Chinhoyi University of Science and Technology" => "../unilistings/cutlisting.php",
                "Great Zimbabwe University" => "../unilistings/gzlisting.php",
                "Harare Institute of Technology" => "../unilistings/hitlisting.php",
                "National University of Science and Technology" => "../unilistings/nustlisting.php"
            );
            if (array_key_exists($uni, $universityMapping)) {
                $redirectUrl = $universityMapping[$uni];
                if ($redirect == "chat") {
                    redirect("../chat/screens/index.php?error=You Have Logged In Successfully");
                } else {
                    redirect($redirectUrl . "?error=You Have Logged In Successfully");
                }
                exit();
            }
        } else {
            redirect('../login.php?error=' . $response['message']);
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionstudent'])) {
        session_destroy();
    }
    redirect("../index.php?error=Logged Out");
    exit();
}

// handling http requests
if ($_SERVER['REQUEST'] === 'GET') {
    $email = sanitize_email($request_body['email']) ?? null;
    $password = $request_body['password'] ?? null;
    $responseJson = loginUserStudent($email, $password);
    echo json_encode($response);
    exit();
}
