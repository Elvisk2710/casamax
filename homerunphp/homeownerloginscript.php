<?php
session_start();

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    exit(0);
}

setcookie("scriptPage", "homeownerloginscript.php", time() + (900 * 1), "/");

require '../required/common_functions.php';
require '../vendor/autoload.php'; // Ensure JWT library is loaded

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

const JWT_SECRET = 'your_secret_key_here'; // Use a secure and long secret key

if (isset($_POST['submit'])) {
    require 'homerunuserdb.php';
    require '../required/alerts.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (empty($email) || empty($password)) {
        redirect("../homeownerlogin.php?error=All Fields Are Required");
        exit();
    } else {
        session_unset();
        $responseJson = loginUserLandlord($email, $password);
        $response = json_decode($responseJson, true);
        if ($response['status'] == 'success') {
            $_SESSION['sessionowner'] = $response['user_id'];
            redirect("../profile.php?error=You Have Logged In Successfully");
            exit();
        } else {
            redirect('../homeownerlogin.php?error=' . $response['message']);
            exit();
        }
    }
} elseif (isset($_POST['logout'])) {
    if (isset($_SESSION['sessionowner'])) {
        session_destroy();
    }
    redirect("../index.php?success=You Have Logged Out Successfully");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json'); // Ensure response is JSON

    if (isset($_GET['email'])) {
        $email = sanitize_email($_GET['email']) ?? null;
        $password = $_GET['password'] ?? null;

        if ($email != null && $password != null) {
            $responseJson = loginUserLandlord($email, $password);
            $responseData = json_decode($responseJson, true);

            if ($responseData['status'] == 'success') {
                // Create JWT token
                $payload = [
                    'iss' => "https://casamax.co.zw", // Issuer
                    'aud' => "https://casamax.co.zw", // Audience
                    'iat' => time(), // Issued at
                    'exp' => time() + (60 * 60 * 24 * 30), // Expiration time (30 days)
                    'user_id' => $responseData['user_id'],
                    'message' => $responseData['message'],
                    'status' => $responseData['status'],
                    'type' => 'landlord',
                    'firstname' => $responseData['firstname'],
                    'lastname' => $responseData['lastname'],
                ];

                $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');
                echo json_encode(['status' => 'success', 'token' => $jwt]);
                exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => $responseData['message']]);
                exit();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Empty Fields']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'no-body']);
        exit();
    }
} else {
    header('Content-Type: application/json'); // Ensure response is JSON
    echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
    exit();
}
