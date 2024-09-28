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
    </div> 
        <div class="container">
        <div class="login-container">
            <div class="left-login">
                <lottie-player
                    src="https://lottie.host/12be720b-5ba7-4989-a48d-1cbd6de19286/qAUt599WBl.json"
                    background="transparent"
                    speed="1"
                    style="width: 70%; height: 70%;"
                    loop
                    autoplay>
                </lottie-player>
            </div>
            <div class="right-login">
                <header>
                    <a href="index.php">
                        <img src="../images/logoorange.png" alt="logo" class="logo">
                    </a>
                </header>
                <div class="btn-container">
                    <div>
                        <h1>Manage As:</h1>
                    </div>
                    <div class="login">
                        <a href="../profile.php"><button type="button" name="submit">
                                Landlord
                            </button>
                        </a>
                    </div>
                    <div class="login">
                        <a href="../agent/agent_profile.php"><button type="button" name="submit">
                                Accommodation Agent
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>