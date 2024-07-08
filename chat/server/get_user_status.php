// get-user-status.php
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require '../../homerunphp/advertisesdb.php';
    if (isset($_SESSION['sessionstudent'])) {
        $user_id = $_SESSION['sessionstudent'];
        $sql = "SELECT * FROM homerunuserdb WHERE userid = '$user_id'";
    } elseif (isset($_SESSION['sessionowner'])) {
        $user_id = $_SESSION['sessionowner'];
        $sql = "SELECT * FROM homerunhouses WHERE home_id = '$user_id'";
    } else {
        redirect("../../loginas.php");
    }

    if ($result = mysqli_query($conn, $sql)) {
        if ($row = mysqli_fetch_assoc($result)) {
            $status = $row['status'];
        }
    }

    echo $status;
}
?>