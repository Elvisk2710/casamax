<?php
    session_start();
    require './required/ads_query.php';
    if(empty($_COOKIE['cookiestudent'])){
        header("Location: ./login.php?pleaseloginfirst");
        echo '<script type="text/javascript"> alert("PLEASE LOGIN FIRST") </script>';
        exit();
    }else{
        setcookie("cookieUserID", '', time() + (-86400 * 1), "/");
    }
    if(isset($_GET['error'])){
        echo '
        <script>
            alert('.$_GET['error'].')
        </script>

        ';
        unset($_GET['error']);
    }
    
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<?php  
    require './required/header.php';
?>
<meta name="description" content="Subscribe to casamax.co.zw to remove ads from the site">
    <link rel="icon" href="images/logowhite.png">
    <title>CasaMax Subscription</title>
    <link rel="stylesheet" href="payment.css">

</head>


<body onunload="" class="scrollable">

<?php
    require_once 'required/pageloader.php';
?>    
<div class="head">
        <a href="index.php">  <img src="images/logowhite.png" alt="home" class="logo"></a>
    </div>
        <div class="container"> 
        <div class = "status">
            <?php
                if(isset($_GET['success']) and $_GET["success"] == "true"){
                    echo '
                        <div class="div" style="text-align: center; margin: 0 auto;">
                            <h4 style="color: white; background-color: rgb(103, 171, 0); text-align: center; width: 40vw; min-width: 60px;">
                                transaction status: PAID....
                            </h4>
                        </div>                    
                    ';

                }elseif(isset($_GET['success']) and $_GET["success"] == "false"){
                      echo '
                        <div class="div" style="text-align: center; margin: 0 auto;">
                            <h4 style="color: white; background-color: rgb(200, 0, 0); text-align: center; width: 40vw; min-width: 60px;">
                                transaction status: FAILED....
                            </h4>
                        </div>                    
                    ';
                }

            ?>
        </div>    
       
            <form method="post" action="./required/payment_btn.php">

                <div class="phone_number">
                    <label for="phone" class="phone_label">Phone Number</label>
                    <input type="number" class="phone" min="0" name="phone_number" required placeholder="0777777777">
                </div>
                <br>

        <div class="subscription_buttons">
                    
            <div class="sub">
                <h5>starter</h5>
                <h2>ZWL 8 000</h2>
                <hr>
                <p>
                    This will give you acces to CasaMax services for 1 day!
                </p>
                <button type="submit" name="1day">
                    SUBSCRIBE
                </button>
            
            </div>

            <div class="sub">
                <h5>basic</h5>
                <h2>ZWL 16 000</h2>
                <hr>
                <p>
                    This will give you acces to CasaMax sevices for 3 days!
                </p>
                
                <button type="submit" name="3day">
                    SUBSCRIBE
                </button>
                   
            </div>

            <div class="sub">
                <h5>pro</h5>
                <h2>ZWL 28 000</h2>
                <hr>
                <p>
                    This will give you acces to CasaMax services for 7 days!
                </p>
                <button type="submit" name="1week">
                    SUBSCRIBE
                </button>
            
                </div>
        
        </div>
            </form>
            <div class="browse_btn">
                <a href="./index.php">
                <button>
                    browse boarding-houses instead....
                </button>
                </a>
                
                <style>
                    .browse_btn{
                        width: 20vw;
                        position: absolute;
                        display: flex;
                        text-align: center;
                        align-items: center;
                        justify-content: center;
                        margin: auto;
                        right: 50;
                        left: 50;
                    }
                    .browse_btn button{
                        border: none;
                        border-radius: 10px; 
                        color: rgb(252, 153, 82);
                        font-weight: 500;
                        margin-top: 2vw;
                        padding: 1.5vw 2vw;
                        font-size: 18px;
                        transform: translate(0%,-50%);
                        box-shadow: 3px 10px 22px 1px rgba(0, 0, 0, 0.24);
                        background-color: rgba(8, 8, 12, 1)
                        /* Lowering the shadow */
                    }
                    @media only screen and (max-width: 700px) {
                        .browse_btn{
                        width: 40vw;
                        top: 0;
                    }
                    }
                </style>
            </div>
    </div>

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
          <a href="https://www.facebook.com/Homerunzim-102221862615717/" data-tabs="timeline"><img src="./images/facebook.png" alt="" title="Our-Facebook-page"></a>
          <a href="https://www.instagram.com/casamax.co.zw/"><img src="./images/instagram.png" alt="" title="Our-Instagram-page"></a>
          <a href="https://wa.me/+263786989144"> <img src="./images/whatsapp.png" alt="" title="Our-WhatsApp-page"></a>
          <a href="mailto:casamaxzim@gmail.com?subject=Feedback to CasaMax&cc=c"> <img src="./images/mail.png" alt="" title="Email"></a>
          <a href=""><img src="./images/twitter.png" alt="" title="Our-twitter-page"></a>
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

</script>?>
</body>
</html>
