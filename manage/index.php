<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require '../required/header.php';
    ?>
    <link rel="icon" href="../images/logowhite.png">
    <link rel="stylesheet" href="../signup.css">
    <title>CasaMax Advertise As</title>

</head>

<body onunload="" class="scrollable">

    <?php
    require_once '../required/pageloader.php';
    ?>
    <header>
        <a href="../index.php">
            <img src="../images/logowhite.png" alt="logo" class="logo">
        </a>
    </header>
    <div class="container">

        <div>
            <h1>Manage As</h1>
        </div>
        <div class="login">
            <a href="../profile.php"><button type="button" name="submit">
                    LANDLORD
                </button>
            </a>
        </div>
        <div class="login">
            <a href="../agent/agent_profile.php"><button type="button" name="submit">
                    ACCOMMODATION AGENT
                </button></a>
        </div>

    </div>
</body>

</html>