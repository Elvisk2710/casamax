<?php
session_start();
if (!isset($_SESSION['sessionagent'])) {
    header("Location: ./index.php?error=please login first");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once '../required/pageloader.php';
?>

<head>
    <?php
    require '../required/header.php';
    ?>
    <meta name="description" content="Subscribe to casamax.co.zw to remove ads from the site">
    <link rel="icon" href="../images/logowhite.png">
    <title>CasaMax Subscription</title>
    <link rel="stylesheet" href="../payment.css">
</head>

<script>
    // Get all the buttons on the page
    const buttons = document.querySelectorAll('button');

    // Function to disable all buttons and replace their text with 'loading'
    function disableBtn() {
        document.querySelector(".container_loader").classList.remove("container_loader--hidden");
        document.querySelector("body").classList.add("scrollable");
    }
</script>

<body onunload="" class="scrollable">

    <div class="container">
        <div class="head">
            <a href="index.php"> <img src="../images/logoorange.png" alt="home" class="logo"></a>
        </div>
        <div class="head-title">
            <h1>
                Agent
                <br>
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
        <div class="accordian-container">
            <div class="accordion">
                <input type="checkbox" id="item1">
                <label for="item1">30 Day Subscription</label>
                <div class="content">
                    <form method="post" action="../homerunphp/agent_subscription.php">
                        <div class="subscription_buttons">
                            <div class="sub">
                                <div class="package-name">
                                    <h5>Basic</h5>
                                    <p>
                                        - 5 Houses
                                    </p>
                                </div>
                                <div class="desc">
                                    <p>
                                        Get started with the essentials! List up to <b>5</b> of your boarding houses for <b>30 Days</b> and showcase your properties to students. Perfect for those just starting out.
                                    </p>
                                </div>
                                <div class="price">
                                    <h2>USD $10</h2>
                                </div>
                                <hr>
                                <div class="features">
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Manage Rental
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Chat to Students
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Connect via WhatsApp
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Email Notifications
                                        </p>
                                    </div>
                                </div>
                                <div class="price-btn">
                                    <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="month_basic">
                                        SUBSCRIBE
                                    </button>
                                </div>
                            </div>
                            <div class="sub">
                                <div class="package-name">
                                    <h5>Premium</h5>
                                    <p>
                                        - 20 Houses
                                    </p>
                                </div>
                                <div class="desc">
                                    <p>
                                        Take your listings to the next level! With <b>20 Houses</b> for 30 days of visibility on our platform for you to connect with students around Zimbabwe</p>
                                </div>
                                <div class="price">
                                    <h2>USD $45</h2>
                                </div>
                                <hr>
                                <div class="features">
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Manage Rental
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Chat to Students
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Connect via WhatsApp
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Email Notifications
                                        </p>
                                    </div>
                                </div>
                                <div class="price-btn">
                                    <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="month_premium">
                                        SUBSCRIBE
                                    </button>
                                </div>
                            </div>
                            <div class="sub">
                                <div class="package-name">
                                    <h5>Pro</h5>
                                    <p>
                                        - 50 Houses
                                    </p>
                                </div>
                                <div class="desc">
                                    <p>
                                        Maximize your exposure and dominate the market! Enjoy <b>30 Day</b> visibility for your <b>50</b> boarding houses on our platform and get a chance to fill up your home as quickly as possible.
                                    </p>
                                </div>
                                <div class="price">
                                    <h2>USD $80</h2>
                                </div>
                                <hr>
                                <div class="features">
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Manage Rental
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Chat to Students
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Connect via WhatsApp
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Email Notifications
                                        </p>
                                    </div>
                                </div>
                                <div class="price-btn">
                                    <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="month_pro">
                                        SUBSCRIBE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="accordion">
                <input type="checkbox" id="item2">
                <label for="item2"> 180 Day Subscription</label>
                <div class="content">
                    <form method="post" action="../homerunphp/agent_subscription.php">
                        <div class="subscription_buttons">
                            <div class="sub">
                                <div class="package-name">
                                    <h5>Basic</h5>
                                    <p>
                                        - 5 Houses
                                    </p>
                                </div>
                                <div class="desc">
                                    <p>
                                        Get started with the essentials! List up to <b>5</b> of your boarding houses for <b>30 Days</b> and showcase your properties to students. Perfect for those just starting out.
                                    </p>
                                </div>
                                <div class="price">
                                    <h2>USD $20</h2>
                                </div>
                                <hr>
                                <div class="features">
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Manage Rental
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Chat to Students
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Connect via WhatsApp
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Email Notifications
                                        </p>
                                    </div>
                                </div>
                                <div class="price-btn">
                                    <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="half_basic">
                                        SUBSCRIBE
                                    </button>
                                </div>
                            </div>
                            <div class="sub">
                                <div class="package-name">
                                    <h5>Premium</h5>
                                    <p>
                                        - 20 Houses
                                    </p>
                                </div>
                                <div class="desc">
                                    <p>
                                        Take your listings to the next level! With <b>20 Houses</b> for 30 days of visibility on our platform for you to connect with students around Zimbabwe</p>
                                </div>
                                <div class="price">
                                    <h2>USD $120</h2>
                                </div>
                                <hr>
                                <div class="features">
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Manage Rental
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Chat to Students
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Connect via WhatsApp
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Email Notifications
                                        </p>
                                    </div>
                                </div>
                                <div class="price-btn">
                                    <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="half_premium">
                                        SUBSCRIBE
                                    </button>
                                </div>
                            </div>
                            <div class="sub">
                                <div class="package-name">
                                    <h5>Pro</h5>
                                    <p>
                                        - 50 Houses
                                    </p>
                                </div>
                                <div class="desc">
                                    <p>
                                        Maximize your exposure and dominate the market! Enjoy <b>180 Day</b> visibility for your <b>50</b> boarding houses on our platform and get a chance to fill up your home as quickly as possible.
                                    </p>
                                </div>
                                <div class="price">
                                    <h2>USD $250</h2>
                                </div>
                                <hr>
                                <div class="features">
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Manage Rental
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Chat to Students
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Connect via WhatsApp
                                        </p>
                                    </div>
                                    <div>
                                        <img src="../images/done.png" alt="">
                                        <p>
                                            Email Notifications
                                        </p>
                                    </div>
                                </div>
                                <div class="price-btn">
                                    <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="half_pro">
                                        SUBSCRIBE
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="accordion">
            <input type="checkbox" id="item3">
            <label for="item3">365 Day Subscription</label>
            <div class="content">
                <form method="post" action="../homerunphp/agent_subscription.php">
                    <div class="subscription_buttons">
                        <div class="sub">
                            <div class="package-name">
                                <h5>Basic</h5>
                                <p>
                                    - 10 Houses
                                </p>
                            </div>
                            <div class="desc">
                                <p>
                                    Get started with the essentials! List your boarding house for <b>365 Days</b> and showcase your 10 Boarding Houses to students. Perfect for those just starting out.
                                </p>
                            </div>
                            <div class="price">
                                <h2>USD $50</h2>
                            </div>
                            <hr>
                            <div class="features">
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Manage Rental
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Chat to Students
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Connect via WhatsApp
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Email Notifications
                                    </p>
                                </div>
                            </div>
                            <div class="price-btn">
                                <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="full_basic">
                                    SUBSCRIBE
                                </button>
                            </div>
                        </div>
                        <div class="sub">
                            <div class="package-name">
                                <h5>Premium</h5>
                                <p>
                                    - 30 Houses
                                </p>
                            </div>
                            <div class="desc">
                                <p>
                                    Take your listings to the next level! With <b>365 Days</b> of visibility on our platform for your 30 Boarding Houses to connect with students around Zimbabwe</p>
                            </div>
                            <div class="price">
                                <h2>USD $150</h2>
                            </div>
                            <hr>
                            <div class="features">
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Manage Rental
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Chat to Students
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Connect via WhatsApp
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Email Notifications
                                    </p>
                                </div>
                            </div>
                            <div class="price-btn">
                                <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="full_premium">
                                    SUBSCRIBE
                                </button>
                            </div>
                        </div>
                        <div class="sub">
                            <div class="package-name">
                                <h5>Pro</h5>
                                <p>
                                    - 60 Houses
                                </p>
                            </div>
                            <div class="desc">
                                <p>
                                    Maximize your exposure and dominate the market! Enjoy <b>365 Days</b> of visibility for your <b>60</b> Boarding Houses on our platform and get a chance to fill up your home as quickly as possible.
                                </p>
                            </div>
                            <div class="price">
                                <h2>USD $300</h2>
                            </div>
                            <hr>
                            <div class="features">
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Manage Rental
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Chat to Students
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Connect via WhatsApp
                                    </p>
                                </div>
                                <div>
                                    <img src="../images/done.png" alt="">
                                    <p>
                                        Email Notifications
                                    </p>
                                </div>
                            </div>
                            <div class="price-btn">
                                <button id="subscriptionBtn1" type="submit" onclick="disableBtn()" name="full_pro">
                                    SUBSCRIBE
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="browse_btn">
        <a href="./advertise.php">
            <button>
                Register Your Home.
            </button>
        </a>
    </div>
    </div>
    </div>
</body>

</html>