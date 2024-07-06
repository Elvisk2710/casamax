<?php
session_start();
// connection to databse
require '../../homerunphp/advertisesdb.php';
$student = false;
if (isset($_SESSION['sessionstudent'])) {
    $sender_id = $_SESSION['sessionstudent'];
    $student = true;
} elseif (isset($_SESSION['sessionowner'])) {
    $sender_id = $_SESSION['sessionowner'];
    $student = false;
} else {
    echo "Please Login";
}
// API endpoint for retrieving data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $output = "";
    if (!isset($_GET['chat_id']) && !isset($_GET['student'])) {
        header("location: ./login.php");
        echo "<script>alert('Access Denied')</script>";
        $output .= "Access Denied";
    } else {
        $chat_id = $_GET['chat_id'];
        $student = $_GET['student'];
        if ($student == 1) {
            $sql = "SELECT * FROM homerunhouses WHERE home_id = '$chat_id'";
        } else {
            $sql = "SELECT * FROM homerunuserdb WHERE userid = '$chat_id'";
        }
        if ($results = mysqli_query($conn, $sql)) {
            $row = mysqli_fetch_array($results);
            $name = $row['firstname'];
            $lastname = $row['lastname'];
            if ($student == false) {
                $home_id = $row['userid'];
            }
            $status = $row['status'];
            $output .= "
                    
            ";
        }
    }
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
    <title>CasaMax Chat Room</title>

</head>

<body onunload="" class="scrollable">

    <?php
    require_once '../../required/pageloader.php';
    ?>
    <div class="container">
        <div class="header">
            <div class="header_img">
                <img src="../../images/background2.jpg" alt="">
            </div>
            <div class="header_info">
                <div class="name">
                    <div class="name_value">
                        <h2>
                            <?php echo $name ?>
                        </h2>
                    </div>
                    <div class="name_value">
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
                    <a href='https://localhost/casamax/listingdetails.php?clicked_id=<?php echo $chat_id ?>'>
                        <button class="logout_btn">
                            View Home
                        </button>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="chat_container">

        </div>
        <form class="text_area" autocomplete="off">
            <input type="text" name="outgoing_id" value="<?php echo $sender_id ?>" hidden>
            <input type="text" name="incoming_id" value="<?php echo $chat_id ?>" hidden>

            <div class="input_msg">
                <input name="message" class="input_field" placeholder="Type your message here">
            </div>
            <div class="input_icon">
                <button>
                    send
                </button>
            </div>
        </form>
    </div>
</body>
<script src="../scriptjs/chats.js"></script>

</html>