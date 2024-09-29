<?php
session_start();
require_once '../../homerunphp/advertisesdb.php';
if (empty($_SESSION['sessionAdmin'])) {
    redirect('../index.php?error=Please Login');
    exit();
} elseif (isset($_GET['AdminHomeID'])) {
    $home_id = $_GET['AdminHomeID'];
    $sql = "SELECT * FROM homerunhouses WHERE home_id = '$home_id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        redirect('../index.php?error=Sql Error');
        exit();
    } else {
        $row = mysqli_fetch_array($result);
    }
    $res_image = $row['res_image'];
    $res_location = '../../verification_images/home_verification_images/' . $home_id . '/' . $res_image;
    $id_image = $row['id_image'];
    $id_location = '../../verification_images/home_verification_images/' . $home_id . '/' . $id_image;
} elseif (isset($_GET['AdminAgentID'])) {
    $agent_id = $_GET['AdminAgentID'];
    $sql = "SELECT * FROM agents WHERE agent_id = '$agent_id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        redirect('../index.php?error=Sql Error');
        exit();
    } else {
        $row = mysqli_fetch_array($result);
    }
    $id_image = $row['verification_image'];
    $id_location = '../../verification_images/agents_verification_images/' . $agent_id . '/' . $id_image;
    
} else {
    redirect('./index.php?error=Sorry Id Is Not Set');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Documents</title>
    <link rel="icon" href="../../images/logowhite.png">
    <link rel="stylesheet" href="./admin_listings_dashboard.css">
</head>
<?php
include './verify_popup.php';
require '../../required/pageloader.php';
?>

<body>
    <div class="view_documents_pop_up" id="view_documents_pop_up">
        <div class="pop_up_content">
            <?php if (isset($_GET['AdminHomeID'])) { ?>
                <div class="image_container">
                    <div class="image_div">
                        <label id="verification_image" for="verification_image">ID Image</label>
                        <img src='<?php echo $id_location ?>' alt="ID Image" id="idImage">
                    </div>
                    <div class="image_div">
                        <label id="verification_image" for="verification_image">Proof Of Residency Image</label>
                        <img src='<?php echo $res_location ?>' alt="Proof Of Residency Image" id="resImage">
                    </div>
                </div>
            <?php } elseif (isset($_GET['AdminAgentID'])) { ?>
                <div class="image_container">
                    <div class="image_div">
                        <label id="verification_image" for="verification_image">ID Image</label>
                        <img src='<?php echo $id_location ?>' alt="ID Image" id="idImage">
                    </div>
                    <div class="image_div">
                        <ul>
                            <li>
                                <label for="name">Name:</label>
                                <h4 id="name"><?php echo $row['firstname']?></h4>
                            </li>
                            <li>
                                <label for="lastname">LastName:</label>
                                <h4 id="lastname"><?php echo $row['lastname']?></h4>
                            </li>
                            <li>
                                <label for="id">ID Number:</label>
                                <h4 id="id"><?php echo $row['id_num']?></h4>
                            </li>
                            <li>
                                <label for="email">Email:</label>
                                <h4 id="email"><?php echo $row['email']?></h4>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <br>
            <div class="verify_div">
                <?php
                if ($_GET['verified'] != 1) {
                ?>
                    <button class="action_button" onclick="openVerify()">
                        Verify
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>
<script>
    // Get the Id image
    var idImage = document.getElementById('idImage');

    // Add a click event listener to the image
    idImage.addEventListener('click', function() {
        // Open the image in a new window or tab
        window.open(idImage.src, '_blank');
    });

    // Get the proof of res image
    var resImage = document.getElementById('resImage');

    // Add a click event listener to the image
    resImage.addEventListener('click', function() {
        // Open the image in a new window or tab
        window.open(resImage.src, '_blank');
    });
</script>

</html>
<script src="../../jsfiles/onclickscript.js"></script>