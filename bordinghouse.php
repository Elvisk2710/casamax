<?php
    session_start();
    require './required/ads_query.php';
    require_once 'homerunphp/advertisesdb.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    require './required/header.php';
?>
    <meta name="description" content="View Boarding Houses available on casamax.co.zw which are ready for students to rent">
    <link rel="icon" href="images/logowhite.png">
    <link rel="stylesheet" href="./index.css">
    <title>All Bording Houses</title>
    
    </head>

<body onunload="" class="scrollable">
    <?php
    require 'required/pageloader.php';
    ?> 
    <?php
        $page_name = "bordinghouse.php";
                // home link
        echo '<div class="head">

        <a href="index.php">  
        <img src="./images/logoblack.png" alt="" class="logo">
        </a>

        </div> 
        <br>';
            
        $num_per_page = 10;

        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }else{
            $page = 1;
        }

        $start_from = ($page-1)*10;

        $sql = "SELECT * FROM  homerunhouses LIMIT $start_from,$num_per_page ";
        $result = mysqli_query($conn,$sql);
        $total_records = mysqli_num_rows($result);


    ?>
    

    <nav id="navBar" class="navbar-white">

   

    <h3 class="smltxt">CasaMax</h3>
    <img src="images/menu.png" alt="menu" onclick="togglebtn()" class="fas">
            <br>
            <a href="./index.php" class="home">HOME</a>
            <a href="./bordinghouse.php">BOARDING-HOUSE</a>
            <a href="./advertise/index.php">ADVERTISE</a>
            <a href="./help.php">HELP</a>
            <?php
            if(!isset($_SESSION['sessionstudent'])){
                echo '<a href="./loginas.php" class="sign_in" name="loginbtn">LOGIN</a>';
            }else{
                echo '<a href="./student_profile.php" class="sign_in" name="loginbtn">MY PROFILE</a>';
            }
        ?>
    </nav>

        <?php

        //params to connect to the database
    if(!$conn){
        die("Database Connection Failed!");
    }
    ?>

    <!-- listing  -->

    <div class="container">
    <h2 style= "margin: 0 auto; text-align: center;">
        All Bording Houses
    </h2>;

    <div style= "margin: 0 auto; text-align: center;">

    <h3 style= "margin: 0 auto; text-align: center; font-weight: 400; margin: 10px; color:  rgba(252, 153, 82, 0.7); font-size: 15px;">
    jump straight to bording-houses near your university!!
    <h3>

    <select name="university" id="dropdown" style= "margin: 0 auto; text-align: center;"
    onChange="window.location.href=this.value">

        <option value="All">Choose a University</option>
        <option value="unilistings/uzlisting.php">University of Zimbabwe</option>
        <option value="unilistings/msulisting.php">Midlands State University</option>
        <option value="unilistings/aulisting.php">Africa Univeristy</option>
        <option value="unilistings/bsulisting.php">Bindura State University</option>
        <option value="unilistings/cutlisting.php">Chinhoyi University of Science and Technology</option>
        <option value="unilistings/gzlisting.php">Great Zimbabwe University</option>
        <option value="unilistings/hitlisting.php">Harare Institute of Technology</option>
        <option value="unilistings/nustlisting.php">National University of Science and Technology</option>


    </select>
    </div>

    <?php

    while ($row = mysqli_fetch_array($result)){

        if($row['uni'] == "University of Zimbabwe"){
            $folder = "uzpictures";
        }elseif($row['uni'] == "National University of Science and Technology"){
            $folder = "nustpictures";
        }elseif($row['uni'] == "Midlands State University"){
            $folder = "msupictures";
        }elseif($row['uni'] == "Harare Institute of Technology"){
                $folder = "hitpictures";
        }elseif($row['uni'] == "Great Zimbabwe University"){
                $folder = "gzpictures";
        }elseif($row['uni'] == "Chinhoyi University of Science and Technology"){
                $folder = "cutpictures";
        }elseif($row['uni'] == "Bindura State University"){
                $folder = "bsupictures";
        }elseif($row['uni'] == "Africa Univeristy"){
                $folder = "aupictures";
        }

        if($row['available']==1){
        
            echo '<div class="list-container">
                
            <div class="left-col">';

            echo"<div class='house'>";
            echo"<div class='house-img'>";
        
            echo "<a href='listingdetails.php' onclick='GetName(this.id)' id = '" .$row['email']. "'><img src='./housepictures/$folder/".$row['image1']."'></a>";
        
            echo "</div>";
            echo "<div class='house-info'> 

            <h3>"
            . $row['gender']." Boarding House 
            </h3><br>

            <h3 style = 'color: rgb(252, 153, 82);'>Amenities</h3>";

            if($row['kitchen'] == "1"){
                $kitchenimg = "images/checkmark.png";
            }else{
                $kitchenimg = "images/crossmark.png ";
            }
            if($row['fridge'] == "1"){
                $fridgeimg = "images/checkmark.png";
            }else{
                $fridgeimg = "images/crossmark.png ";
            }
            if($row['wifi'] == "1"){
                $wifiimg = "images/checkmark.png";
            }else{
                $wifiimg = "images/crossmark.png ";
            }
            if($row['borehole'] == "1"){
                $boreholeimg = "images/checkmark.png";
            }else{
                $boreholeimg = "images/crossmark.png ";
            }
        
    echo "<p>
            Kitchen <img src='" .$kitchenimg ."' style='height:8%; width:8%; margin-left:8%;'>
        <br> 

            Fridge <img src='" .$fridgeimg ."' style='height:8%; width:8%; margin-left: 8%;'>
        <br>

            Wifi <img src='" .$wifiimg ."' style='height:8%; width:8%; margin-left: 8%;'>
        <br>  
        
            Borehole <img src='" .$boreholeimg ."' style='height:8%; width:8%; margin-left: 8%;'>
        <br>
        
        </p>
            <h3>";
            echo " <div class='house-price'>
                    <p>". $row['people_in_a_room'] ." IN A ROOM</p>
                    <h4>";
            echo $row['price'] . "<span>/ month</span>";
            echo " </h4>
                    </div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        
        }
    }
    ?>

    <?php
        require "required/listing-pagination.php";
    ?>
    <!-- footer -->
    <div class="footer">
                <h3 class="abt">
                <a href="aboutus.php">About</a> CasaMax
                </h3>
                <p>
                Looking for a House to Rent?
            Welcome to CasaMax, where we provide all the available
            Homes and Rental properties at the tip of your fingers
            </p>
            
        
            <div class="socialicons">
            <a href="https://www.facebook.com/Homerunzim-102221862615717/"><img src="./images/facebook.png" alt=""></a>
            <a href="https://www.instagram.com/casamax.co.zw/"><img src="./images/instagram.png" alt=""></a>
            <a href="https://wa.me/+263786989144"> <img src="./images/whatsapp.png" alt=""></a>
            <a href="mailto:casamaxzim@gmail.com?subject=Feedback to HomeRun&cc=c"> <img src="./images/mail.png" alt=""></a>
            <a href=""><img src="./images/twitter.png" alt=""></a>
        </div>
        </div>
    </div>
    
    <script>

        var navBar = document.getElementById("navBar");

        function togglebtn(){

            navBar.classList.toggle("hidemenu")
        }

    </script>
    <script>

        var dropdown = document.getElementById("dropdown");

        function togglebtn1(){

            navBar.classList.toggle("hideuni")
        }

    </script>

    <script type="text/javascript">

    function GetName(clicked_id){

        var name = clicked_id;
        createCookie("clicked_id", name , "10"); 
    }
    function createCookie(name, value, hours) { 
        var expires; 
        
        if (days) { 
            var date = new Date(); 
            date.setTime(date.getTime() + (hours * 60 * 60 * 1000)); 
            expires = "; expires=" + date.toGMTString(); 
        } 
        else { 
            expires = ""; 
        } 
        
        document.cookie = escape(name) + "=" + 
            escape(value) + expires + "; path=/"; 
    } 
    function createCookie(name, value, days) { 
        var expires; 
        
        if (days) { 
            var date = new Date(); 
            date.setTime(date.getTime() + (days * 24 * 60 * 1000)); 
            expires = "; expires=" + date.toGMTString(); 
        } 
        else { 
            expires = ""; 
        } 
        
        document.cookie = escape(name) + "=" + 
            escape(value) + expires + "; path=/"; 
    } 


    </script>
</body>
</html>
