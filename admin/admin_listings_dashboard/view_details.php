<?php
session_start();
require_once '../../homerunphp/advertisesdb.php';
if (empty($_SESSION['sessionAdmin'])) {
    header("Location:../index.php?PleaseLogin");
    echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
    exit();
}else if (!isset($_GET['AdminHomeID'])) {
    header("Location:../index.php?PleaseLogin");
    echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
    exit();
} else {
   $home_id = $_GET['AdminHomeID'];
   $sql = "SELECT * FROM homerunhouses WHERE home_id = '$home_id'";
   $result = mysqli_query($conn,$sql);
   if(!$result){
    header("Location:./index.php?SQL Error");
    echo '<script type="text/javascript"> alert("SQL Error") </script>';
    exit();
   }else{
    $row = mysqli_fetch_array($result);
   }
}

$res_image = $row['res_image'];
$res_location = '../../verification_images/' . $home_id . '/' . $res_image;
$id_image = $row['id_image'];
$id_location = '../../verification_images/' . $home_id . '/' . $id_image;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificatio Documents</title>
</head>

<body>
    <div class="view_documents_pop_up" id="view_documents_pop_up">
        <div class="pop_up_content">
            <div class="image_container">
                <div class="image_div">
                    <label for="verification_image">ID Image</label>
                    <img id="verification_image" src='<?php echo $res_location ?>' alt="ID Image">
                </div>
                <div class="image_div">
                    <label for="verification_image">Proof Of Residency Image</label>
                    <img id="verification_image" src='<?php echo $res_location ?>' alt="Proof Of Residency Image">
                </div>
            </div>
            <?php echo $home_id ?>
            <div class="verify_div">
                <button class="action_button" onclick="openVerify()">
                    Verify
                </button>
                <button class="view_button" onclick="closeDocs()">
                    Close
                </button>
            </div>
        </div>
    </div>
</body>

</html>