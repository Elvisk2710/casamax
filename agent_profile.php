<?php
session_start();
require './required/ads_query.php';
if (!isset($_GET['agent_id'])) {
    // Check if HTTP_REFERER is set
    if (isset($_SERVER['HTTP_REFERER'])) {
        // Redirect to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        // If HTTP_REFERER is not set, redirect to a default page
        redirect('Location: ./index.php?error=Access Denied');
        exit;
    }
} else {
    $user = $_GET['agent_id'];
    require_once 'homerunphp/advertisesdb.php';
    $sql = "SELECT * FROM  agents WHERE agent_id = '$user' ";
}

if ($rs_result = mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_array($rs_result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require './required/header.php';
    ?>
    <meta name="description" content="Login and enjoy vast options of homes to choose for your off-campus accommodation">
    <link rel="icon" href="images/logowhite.png">
    <link rel="stylesheet" href="profile.css">
    <title>Agent Profile</title>
</head>


<body onunload="" class="scrollable">

    <?php
    require_once 'required/pageloader.php';
    ?>

    <header>
        <a href="index.php"><img src="images/logowhite.png" alt="logo" class="logo"></a>
    </header>

    <div class="container">
        <div class="house-info">
            <h2>Agent Info</h2>
        </div>
        <br>
        <div class="address">
            <div class="address_info">
                <h3>First Name</h3>
                <p><?php echo ucfirst($row['firstname']) ?></p>
            </div>

            <div class="address_info">
                <h3>Last Name</h3>
                <p><?php echo ucfirst($row['lastname']) ?></p>
            </div>

            <div class="address_info">
                <h3>Date Joined</h3>
                <p><?php echo ucfirst($row['date_joined']) ?></p>
            </div>

            <div class="address_info">
                <h3>Gender</h3>
                <p><?php echo ucfirst($row['sex']) ?></p>
            </div>

            <div class="address_info">
                <h3>Contact</h3>
                <p><?php echo '0' . ucfirst($row['contact']) ?></p>
            </div>

            <div class="address_info">
                <h3>Email</h3>
                <p><?php echo ucfirst($row['email']) ?></p>
            </div>
            <div class="address_info">
                <h3>Tag-Line</h3>
                <p><?php echo ucfirst($row['agent_tagline']) ?></p>
            </div>
        </div>