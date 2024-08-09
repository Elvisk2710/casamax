<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you
    // want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

session_start();
require '../required/common_functions.php';
require '../vendor/autoload.php'; // Ensure JWT library is loaded

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

const JWT_SECRET = 'your_secret_key_here'; // Use a secure and long secret key


if (isset($_POST['submit'])) {
    $sec = "0.1";
    require 'homerunuserdb.php';
    include '../required/alerts.php';

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
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['email'])) {
        $email = sanitize_email($_GET['email']) ?? null;
        $password = $_GET['password'] ?? null;
        if ($email != null && $password != null) {
            $responseJson = loginUserStudent($email, $password);
            $responseData = json_decode($responseJson, true);

            if ($responseData['status'] == 'success') {
                // Create JWT token
                $payload = [
                    'iss' => "https://casamax.co.zw", // Issuer
                    'aud' => "https://casamax.co.zw", // Audience
                    'iat' => time(), // Issued at
                    'exp' => time() + (60 * 60  * 24 * 30 ), // Expiration time (30 days)
                    'user_id' => $responseData['user_id'],
                    'university' => $responseData['university'],
                    'message' => $responseData['message'],
                    'status' => $responseData['status'],
                    'type' => 'student',
                    'firstname' => $responseData['firstname'],
                    'lastname' => $responseData['lastname'],

                ];
                $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');
                echo json_encode(['status' => 'success', 'token' => $jwt]);
                exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => $responseData['message']]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Empty Fields']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'no-body']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
}

