<?php
session_start();
// connection to databse
require '../../homerunphp/advertisesdb.php';
require '../../required/common_functions.php';
$student = false;
$_GET['chat_id']=true;
if (isset($_SESSION['sessionstudent'])) {
    $sender_id = $_SESSION['sessionstudent'];
    $student = true;
} elseif (isset($_SESSION['sessionowner'])) {
    $sender_id = $_SESSION['sessionowner'];
    $student = false;
} else {
    header("location: ../../loginas.php?redirect=chat");
    exit();
}
// API endpoint for retrieving data
if ($student == false) {
    $sql = "SELECT * FROM homerunhouses WHERE home_id = '$sender_id'";
} else {
    $sql = "SELECT * FROM homerunuserdb WHERE userid = '$sender_id'";
}

if ($results = mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_array($results);
    $name = $row['firstname'];
    $lastname = $row['lastname'];
    if ($student == false) {
        $home_id = $row['home_id'];
    }
    $status = $row['status'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once '../../required/header.php';
    ?>
    <meta name="description" content="Login as a Student and enjoy vast options of homes to choose for your off-campus accommodation">
    <link rel="icon" href="../../images/logowhite.png">
    <link rel="stylesheet" href="../css/index.css">
    <title>CasaMax Chats</title>

</head>

<body onunload="" class="scrollable">

    <?php
    require_once '../../required/pageloader.php';
    ?>
    <div class="container">
        <div class="header">
            <div class="header_img">
                <img src="../../images/logowhite.png" alt="">
            </div>
            <div class="header_info">
                <div class="name">
                    <div class="name_value" style="color: white;">
                        <h2>
                            <?php echo $name ?>
                        </h2>
                    </div>
                    <div class="name_value" style="color: white;">
                        <h2>
                            <?php echo $lastname ?>
                        </h2>
                    </div>
                </div>
                <div class="status">
                    <p>
                        <?php echo $status ?>
                    </p>
                </div>
            </div>
            <div class="logout">
                <?php
                if ($student == false) {
                ?>
                    <a href='https://localhost/casamax/listingdetails.php?clicked_id=<?php echo $home_id ?>'>
                        <button class="logout_btn">
                            My Home
                        </button>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="search">
            <div class="search_bar">
            <input type="text" id="searchInput" placeholder="Search by name or surname">

            </div>
            <!-- <div class="search_icon">
                <img src="../../images/searchicon.webp" alt="search icon">
            </div> -->
        </div>
        <div class="chat_list_container">
            <div class="chat_list">

            </div>
        </div>
    </div>
    <script src="../scriptjs/get_users.js"></script>
    <script src="../scriptjs/user_status.js"></script>

</body>

</html>