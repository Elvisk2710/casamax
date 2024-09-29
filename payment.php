<?php
session_start();
require './required/ads_query.php';
// if (!isset($_SESSION['sessionstudent'])) {
//     header("Location: ./login.php?pleaseloginfirst");
//     echo '<script type="text/javascript"> alert("PLEASE LOGIN FIRST") </script>';
//     exit();
// }
// if (isset($_GET['error'])) {
//     $error_name = $_GET['error'];
//     echo "
//         <script>
//             alert(" . $error_name . ")
//         </script>

//         ";
//     unset($_GET['error']);
// }

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

    <div class="container">
        <div class="head">
            <a href="index.php"> <img src="./images/logoorange.png" alt="home" class="logo"></a>
        </div>
        <div class="head-title">
            <h1>
                Plans and Pricing
            </h1>
            <br>
            <p>
                Select From The Best Plans Ensuring A Perfect Match.
            </p>
        </div>
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
                    <div class="package-name">
                        <h5>Basic</h5>
                        <p>
                            - 3 months
                        </p>
                    </div>
                    <div class="desc">
                        <p>
                        Get started with the essentials! List your boarding house for <b>3 Months</b> and showcase your property to students. Perfect for those just starting out.
                        </p>
                    </div>
                    <div class="price">
                        <h2>USD $15</h2>

                    </div>
                    <hr>
                    <div class="features">
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Manage Rental
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Chat to Students
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Connect via WhatsApp
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Email Notifications
                            </p>
                        </div>
                    </div>
                    <div class="price-btn">
                        <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="starter" value="subscriptionBtn1">
                            SUBSCRIBE
                        </button>
                    </div>
                </div>

                <div class="sub">
                    <div class="package-name">
                        <h5>Premium</h5>
                        <p>
                            - 6 months
                        </p>
                    </div>
                    <div class="desc">
                        <p>
                        Take your listings to the next level! With <b>6 months</b> of visibility on our platform for you to connect with students around Zimbabwe</p>
                    </div>
                    <div class="price">
                        <h2>USD $30</h2>
                    </div>
                    <hr>
                    <div class="features">
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Manage Rental
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Chat to Students
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Connect via WhatsApp
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Email Notifications
                            </p>
                        </div>
                    </div>
                    <div class="price-btn">
                        <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="starter" value="subscriptionBtn1">
                            SUBSCRIBE
                        </button>
                    </div>
                </div>

                <div class="sub">
                    <div class="package-name">
                        <h5>Pro</h5>
                        <p>
                            - 12 months
                        </p>
                    </div>
                    <div class="desc">
                        <p>
                        Maximize your exposure and dominate the market! Enjoy <b>12 Months</b> of your boarding house on our platform and get a chance to fill up your home as quickly as possible.
                        </p>
                    </div>
                    <div class="price">
                        <h2>USD $50</h2>
                    </div>
                    <hr>
                    <div class="features">
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Manage Rental
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Chat to Students
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Connect via WhatsApp
                            </p>
                        </div>
                        <div>
                            <img src="./images/done.png" alt="">
                            <p>
                                Email Notifications
                            </p>
                        </div>
                    </div>
                    <div class="price-btn">
                        <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="starter" value="subscriptionBtn1">
                            SUBSCRIBE
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="browse_btn">
            <a href="./advertise.php">
                <button>
                    Register Your Home.
                </button>
            </a>
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