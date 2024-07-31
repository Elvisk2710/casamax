<?php
session_start();
setcookie("scriptPage", "homeownerloginscript.php", time() + (900 * 1), "/");
require '../required/alerts.php';
require '../required/common_functions.php';

if (isset($_POST['submit'])) {
    require 'homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) || empty($password)) {
        redirect("../homeownerlogin.php?error=All Fields Are Required");
        exit();
    } else {
        $responseJson = loginUserLandlord($email, $password);
        $response = json_decode($responseJson, true);
        if ($response['status'] == 'success') {
            echo 'Login successful! User ID: ' . $response['user_id'];
            $_SESSION['sessionowner'] = $response['user_id'];
            redirect("../profile.php?success=You Have Logged In Successfully");
            exit();
        } else {
            redirect('../homeownerlogin.php?error=' . $response['message']);
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionowner'])) {
        session_destroy();
        redirect("../index.php?success=You Have Logged Out Successfully");
        exit();
    } else {
        redirect("../index.php?success=You Have Logged Out Successfully");
        exit();
    }
} else {
    redirect("../index.php?error=Access Denied");
    exit();
}

// handling http requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $email = sanitize_email($request_body['email']) ?? null;
    $password = $request_body['password'] ?? null;
    if($email != null && $password !=null){
        $responseJson = loginUserLandlord($email, $password);
        echo $responseJson;
        exit();
    }else{
        return;
    }
   
}
