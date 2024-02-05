<?php 
    session_start();
    require './required/ads_query.php';
    if(empty($_SESSION['sessionowner'])){
        header("Location:homeownerlogin.php?PleaseLogin");
        echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
        exit();
    }else{
        $user = $_SESSION['sessionowner'];
        require_once 'homerunphp/advertisesdb.php';
        $sql = "SELECT * FROM  homerunhouses WHERE email = '$user' ";
    
    }
    
    if ($rs_result = mysqli_query($conn,$sql)){
        $row = mysqli_fetch_array($rs_result);
        $home_id = $row['home_id'];
        setcookie("update", $home_id, time() + (86400 * 1), "/");

    }
    
    if (empty($user)){
        echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
        header("refresh:$sec; ../homeownerlogin.php?error=youhavetologinfirst");
        exit();
    }else{
            
        if($row['uni']=="University of Zimbabwe"){

            setcookie("uni_folder", "uzpictures", time() + (86400 * 1), "/");    
            $location = "housepictures/uzpictures/";
        }elseif($row['uni']=="Midlands State University"){
            setcookie("uni_folder", "msupictures", time() + (86400 * 1), "/");    

            $location = "housepictures/msupictures/";
        }elseif($row['uni'] == "Africa Univeristy"){
            setcookie("uni_folder", "aupictures", time() + (86400 * 1), "/");    

            $location = "housepictures/aupictures/";
        }elseif($row['uni'] == "Bindura State University"){
            setcookie("uni_folder", "bsupictures", time() + (86400 * 1), "/");    

            $location = "housepictures/bsupictures/";
        }elseif($row['uni'] == "Chinhoyi University of Science and Technology"){
            setcookie("uni_folder", "cutpictures", time() + (86400 * 1), "/");    

            $location = "housepictures/cutpictures/";
        }elseif($row['uni'] == "Great Zimbabwe University"){
            setcookie("uni_folder", "gzpictures", time() + (86400 * 1), "/");    

            $location = "housepictures/gzpictures/";
        }elseif($row['uni'] == "Harare Institute of Technology"){
            setcookie("uni_folder", "hitpictures", time() + (86400 * 1), "/");    

            $location = "housepictures/hitpictures/";
        }elseif($row['uni'] == "National University of Science and Technology"){
            setcookie("uni_folder", "nustpictures", time() + (86400 * 1), "/");    

            $location = "housepictures/hitpictures/";
        }else{
            header("Location:./index.php?error=sqlerror");
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php  
    require './required/header.php';
?>
<meta name="description" content="Login and control how your boarding house is viewed on the platform">
    <link rel="icon" href="images/logowhite.png">
    <link rel="stylesheet" href="profile.css">
    <title>My Profile</title>
</head>
<script>
 
</script>

<body onunload="" class="scrollable">

<?php
    require_once 'required/pageloader.php';

    echo'    
        <header>
        
        <a href="index.php"><img src="images/logowhite.png" alt="logo" class="logo"></a>
        ';
    if($row['available'] != 1){
        // alerts whether the house is being shown on the platfrom or not.
        echo '
        <div class="alert_off">

        <p> Your current listing is not visible on CasaMax. To make it visible click available and update <a href="#available">Right Here!</a></p>
        
        </div>';
    }
    echo '
        <h1>
            
            HEY '. ucfirst($row['firstname']).'!
            
        </h1>
        </header>
    ';
    if(!empty($row['image1'])){
    echo'
    <div class="profile-photo">

    <img src="'.$location.$row["image1"].'" alt="">

    </div>';
    }
    if(empty($row['image1']) and empty($row['image2'])and empty($row['image3'])and empty($row['image4'])and empty($row['image5'])and empty($row['image6'])and empty($row['image7'])and empty($row['image8'])){
    
    echo'
    <div class="add_photos">
        <p>YOUR PROFILE DOES NOT HAVE ANY PHOTOS. PLEASE ADD YOUR PHOTOS HERE!!</p>
        <form action="homerunphp/profile_photo_upload.php" enctype="multipart/form-data" method="POST" class="photo_form">
        <div class="profile_page_photo_upload">
     
            <div>
                
            <img title="Choose an Image" src="./images/addimage.png" id="image1" onclick="triggerClick()">
            <input type="file" onchange="displayImage2(this)" id="inputimage1" name="image[]" multiple >
            <br>
                <h3 style="color: rgb(8, 8, 12);">
                    Add Upto 8 Images
                </h3>
            </div>

        </div>
        <button class="photo_button" name="profile_photos">
            Submit
        </button>
        </form>
    </div>';
    }

        echo '
        <div class="container">


        <div class="house-info">
            <h2>YOUR HOUSE INFO</h2>

        </div>
    <div class="table">
    <table>
            <tr>
                <th class="value">$'.$row['price'].'</th>
                <th class="value">'.$row['people_in_a_room'].'</th>
                <th class="value">'.$row['gender'].'</th>
            </tr>
            <tr>
                <th>AMOUNT PER MONTH</th>
                <th>PEOPLE IN A ROOM</th>
                <th>GIRLS, BOYS OR BOTH</th>
            </tr>
        </table>
    </div>
    <br>
';
if($row['verified'] == 0){
    echo' <div class="verification_div">

    <p>Hey! Thanks for signing up, we just need to verify your account</p>
    <label class="verify_label" onclick="open_Verification_popup()">VERIFY</label>

    </div>';
}
   
echo'
    <br>
    <div class="address">
        <div class = "address_info">
        <h3>ADDRESS</h3>
        <p>'.$row['adrs'].'</p>
        </div>

        <div class = "address_info">
        <h3>PHONE</h3>
        <p>0'.$row['contact'].'</p>
        </div>

        <div class = "address_info">
        <h3>EMAIL</h3>
        <p>'.$row['email'].'</p>
        </div>

    </div>
        ';
        ?>
        <div class="edit">
        <button type='button' class='edit-btn' onclick="openForm()" >Edit My info</button>
        </div>

            <div class='profile-bottom'>

                <form action="homerunphp/update.php" method="POST">
                <p>Is your Home...</p>

                    <label for='available'>
                        <input type='radio' name='availability' id='available' value='1' >
                        Available
                    </label> or
                    <label for='occupied'>
                        <input type='radio' name='availability' id='occupied' value='0' >
                        Occupied
                    </label>

                    <br>

                <button class='update' name="update">
                    Update
                </button>

                    <p class='desc'>
                        this will allow your home to either be removed temporarily (Occupied) or be placed back onto the platform (Available) 
                    </p>
                    </div>
                    
                    <button class="update" name="viewpage">
                    Page Preview
                    </button>
                </div>       
                
              

                </div>
                </form>

                </div>
            
  

<div id="popup">
<div class="background">
<div class="form-popup" id="myForm">

  <form action="homerunphp/action_page.php" class="form-container" method="POST">
    <h1>Edit Info</h1>

    <div>
    <label for="rooms">Number of Rooms:</label>
    <input type="number" placeholder="number of rooms"  min="0" name="rooms" required>
    </div>

    <div>
    <label for="price">Price:</label>
    <input type="number" placeholder="price"  min="0" name="price" required>
    </div>

    <div>
    <label for="adrs" class="adress">Address:</button>
    <input type="text" class="address" name="adrs" required>
    </div>

    <div>
        <label for="uname">First-Name:</label>
        <input type="text" id="frstnme" name="firstname" placeholder="Enter your First-Name" required>
        
    </div>
    <div>
        <label for="uname">Last-Name:</label>
        <input type="text" id="lstnme" name="lastname" placeholder="Enter your Last-Name" required>
        
    </div>
    <div>
        <label>Contact:</label>
        <input type="number" name="phone"  min="0" placeholder="enter phone-number" required>

    </div>

    <button type="submit" name="submit" class="btn">Submit</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
  </form>
</div>
</div>
</div>
    </div>
    <div id="verify_popup">
        <img class="mail_img" src="./images/mail.png" alt="mail">
        <p>To verify your account, you need to:</p>
        <ol type="a">
            <li>
                Send proof of residence from 3 months prio to the date of submission (i.e water bill) with the surname matching the surname of the registered person.
            </li>
            <li>
                The email should be sent from the email which logs into CasaMax
            </li>
        </ol>

       
            <a href="mailto:casamaxzim@gmail.com?subject=Email Verification&cc=c"> 
                <button onclick="close_Verification_popup()">
                    VERIFY 
                </button>
            </a>
       
        <p>Verification will be done in the next 7 working days. If you are facing challenges with  verification<a href="https://wa.me/+263786989144"> CONTACT US!</a></p>
    </div>

    <script >

        function triggerClick() {
        document.getElementById('inputimage1').click();
        }
        
        // edit info onclick
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }
        
        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }

        function open_Verification_popup(){
            document.getElementById("verify_popup").style.display = "block";
        }

        function close_Verification_popup(){
            document.getElementById("verify_popup").style.display = "none";
        }


    </script>

</body>
</html>