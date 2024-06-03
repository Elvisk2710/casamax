<?php
session_start();
require './required/ads_query.php';
if (!isset($_SESSION['sessionstudent'])) {
    header("Location: ./login.php?pleaseloginfirst");
    echo '<script type="text/javascript"> alert("PLEASE LOGIN FIRST") </script>';
    exit();
}
if (isset($_GET['error'])) {
    $error_name = $_GET['error'];
    echo "
        <script>
            alert(" . $error_name . ")
        </script>

        ";
    unset($_GET['error']);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once 'required/pageloader.php';
?>

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

    <div class="head">
        <a href="index.php"> <img src="images/logowhite.png" alt="home" class="logo"></a>
    </div>
    <div class="container">
        <div class="status">
            <?php
            if (isset($_GET['success']) and $_GET["success"] == "true") {
                echo '
                        <div class="div" style="text-align: center; margin: 0 auto;">
                            <h4 style="color: white; background-color: rgb(103, 171, 0); text-align: center; width: 40vw; min-width: 60px;">
                                transaction status: PAID....
                            </h4>
                        </div>                    
                    ';
            } elseif (isset($_GET['success']) and $_GET["success"] == "false") {
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

            <div class="subscription_buttons">

                <div class="sub">
                    <h5>Starter</h5>
                    <h2>ZIG 14</h2>
                    <hr>
                    <p>
                        This will give you acces to contact 1 <b>CasaMax Home</b> The Subscription expires in a month
                    </p>
                    <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="starter" value="subscriptionBtn1">
                        SUBSCRIBE
                    </button>
                </div>

                <div class="sub">
                    <h5>Basic</h5>
                    <h2>ZIG 42 </h2>
                    <hr>
                    <p>
                        This will give you acces to contact 5 <b>CasaMax Homes</b> The Subscription expires in a month
                    </p>
                    <button id="subscriptionBtn2" type="submit" onclick="disableBtn()" name="basic" value="subscriptionBtn2">
                        SUBSCRIBE
                    </button>
                </div>
                <div class="sub">
                    <h5>Pro</h5>
                    <h2>ZWL 70</h2>
                    <hr>
                    <p>
                        This will give you acces to contact 15 <b>CasaMax Homes</b>. The Subscription expires in a month
                    </p>
                    <button id="subscriptionBtn3" type="submit" onclick="disableBtn()" name="pro" value="subscriptionBtn3">
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
            <a href="https://www.facebook.com/profile.php?id=100093414304668" data-tabs="timeline"><img src="./images/facebook.png" alt="" title="Our-Facebook-page"></a>
            <a href="https://www.instagram.com/casamax.co.zw/"><img src="./images/instagram.png" alt="" title="Our-Instagram-page"></a>
            <a href="https://wa.me/+263786989144"> <img src="./images/whatsapp.png" alt="" title="Our-WhatsApp-page"></a>
            <a href="mailto:casamaxzim@gmail.com?subject=Feedback to CasaMax&cc=c"> <img src="./images/mail.png" alt="" title="Email"></a>
            <a href=""><img src="./images/twitter.png" alt="" title="Our-twitter-page"></a>
        </div>
    </div>
    </div>

    <script>
        var navBar = document.getElementById("navBar");

        function togglebtn() {

            navBar.classList.toggle("hidemenu")
        }
    </script>
    <script>
        var dropdown = document.getElementById("dropdown");

        function togglebtn1() {

            navBar.classList.toggle("hideuni")
        }

        function disableBtn() {
            document.querySelector(".container_loader").classList.remove("container_loader--hidden");
            document.querySelector("body").classList.add("scrollable");
         }
    </script>
</body>

</html>