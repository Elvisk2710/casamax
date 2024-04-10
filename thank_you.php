<?php
    session_start();
    $uni = $_GET['university'];
    if($uni == "University of Zimbabwe" ){
             $location = "./unilistings/uzlisting.php?success=loginsuccess";

        }elseif($uni =="Midlands State University"){
             $location = "./unilistings/msulisting.php?success=loginsuccess";

        }elseif($uni =="Africa Univeristy"){
             $location = "./unilistings/aulisting.php?success=loginsuccess";

        }elseif($uni =="Bindura State University"){
             $location = "./unilistings/bsulisting.php?success=loginsuccess";

        }elseif($uni =="Chinhoyi University of Science and Technology"){
             $location ="./unilistings/cutlisting.php?success=loginsuccess";

        }elseif($uni =="Great Zimbabwe University"){
             $location = "./unilistings/gzlisting.php?success=loginsuccess";

        }elseif($uni =="Harare Institute of Technology"){
             $location = "./unilistings/hitlisting.php?success=loginsuccess";

        }elseif($uni =="National University of Science and Technology"){
             $location = "./unilistings/nustlisting.php?success=loginsuccess";
        }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require './required/header.php';
    ?>
    <meta name="description" content="Thank you for subscribing to casamax.co.zw">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <link rel="stylesheet" href="thank_you.css">
    
</head>

<body onunload="" class="scrollable">
<?php
    // require 'required/pageloader.php';
?>  
    <header>
        <a href="index.php"><img src="images/logoblack.png" alt="logo" title="Home" class="logo"></a>
    </header>

            
    <div class="container">
            <div class="header">
            <h1>
                You have successfully subscribed!
            </h1>
            </div>

            <!-- <img src="images/studenthomes.jpg" alt="your home" class="student_image" style="width:300px; height:150px"> -->
            <div class="circle_loader ">
                <div class="checkmark draw">

                </div>
            </div>
            
            <div class="text">
            <p>
                Thank you <?php echo ucfirst($_GET['firstname'])?> for subscribing to CasaMax. Please share our website to help your friends find off-campus accommodation with the least amount of effort😃😃
            </p>
            </div>

            <a href="<?php echo $_COOKIE['subscriptionRedirect']?>">
            <button>
                click to find your next home
            </button>
            </a>
    </div>

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
          <a href="https://www.facebook.com/profile.php?id=100093414304668" data-tabs="timeline"><img src="./images/facebook.png" alt="" title="Our-Facebook-page"></a>
          <a href="https://www.instagram.com/casamax.co.zw/"><img src="./images/instagram.png" alt="" title="Our-Instagram-page"></a>
          <a href="https://wa.me/+263786989144"> <img src="./images/whatsapp.png" alt="" title="Our-WhatsApp-page"></a>
          <a href="mailto:casamaxzim@gmail.com?subject=Feedback to CasaMax&cc=c"> <img src="./images/mail.png" alt="" title="Email"></a>
          <a href=""><img src="./images/twitter.png" alt="" title="Our-twitter-page"></a>
      </div>
    </div>
</body>
<script>
        window.addEventListener("load", () =>{
            setTimeout(()=> {
                document.querySelector(".circle_loader").classList.add("load_complete");
                document.querySelector(".checkmark").classList.remove("checkmark");
            }, 2000 )
        });
    </script>
</html>
