<?php
session_start();
require '../required/alerts.php';
require "./advertisesdb.php";
require '../required/common_functions.php';

$sec = "0.1";

if (isset($_POST['update'])) {
    require 'advertisesdb.php';
    $user = $_SESSION['sessionowner'];

    if (empty($user)) {
        redirect(" ../homeownerlogin.php?error=You Have To Login First");
        exit();
    } else {
        $user = sanitize_string($_SESSION['sessionowner']); // Use session variable instead of cookie
        $update = $_POST['availability'];

        // Validate and sanitize input
        $update = mysqli_real_escape_string($conn, $update);
        // Additional validation if needed

        $stmt = $conn->prepare("UPDATE homerunhouses SET available = ? WHERE home_id = ?");
        $stmt->bind_param("ss", $update, $user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            redirect(" ../profile.php?success=Update Successful");
            exit();
        } else {
            redirect(" ../profile.php?error=SQL Error");
            exit();
        }
    }
}
// updating profile info
if (isset($_POST['edit_submit'])) {

    // Check if user is logged in
    $user = $_SESSION['sessionowner'] ?? null;
    if (empty($user)) {
        redirect("../homeownerlogin.php?error=You Have To Login First");
        exit();
    }

    // Validate and sanitize inputs
    $price = $_POST['price_change'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];

    // Checkboxes default to 0 if not selected
    $kitchen = isset($_POST['kitchen']) ? 1 : 0;
    $fridge = isset($_POST['fridge']) ? 1 : 0;
    $wifi = isset($_POST['wifi']) ? 1 : 0;
    $borehole = isset($_POST['borehole']) ? 1 : 0;
    $transport = isset($_POST['transport']) ? 1 : 0;

    // Validate required fields
    if ($price === null || $price <= 0) {
        redirect("../profile.php?error=Invalid Price");
        exit();
    }
    if ($phone === null || $phone <= 0) {
        redirect("../profile.php?error=Invalid Contact Number");
        exit();
    }
    if (empty($description)) {
        redirect("../profile.php?error=Description Cannot Be Empty");
        exit();
    }

    // Update the database
    try {
        $stmt = $conn->prepare("
            UPDATE homerunhouses 
            SET price = ?, contact = ?, rules = ?, kitchen = ?, fridge = ?, wifi = ?, borehole = ?, transport = ?
            WHERE home_id = ?
        ");
        $home_id = sanitize_string($_SESSION['sessionowner']); // Use session variable instead of cookie
        $stmt->bind_param("issiiiiis", $price, $phone, $description, $kitchen, $fridge, $wifi, $borehole, $transport, $home_id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            redirect("../profile.php?success=Update Successful");
        } else {
            redirect("../profile.php?error=No Changes Made or SQL Error");
        }
    } catch (Exception $e) {
        redirect("../profile.php?error=Server Error: " . $e->getMessage());
    }
    exit();
}
?>
