<?php
    require './required/ads_query.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    require './required/header.php';
?>
    <meta name="description" content="Let us assist you in finding your boarding house that suits you as a student for the upcoming semester">
    <link rel="icon" href="images/logowhite.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>Help!</title>
    <link rel="stylesheet" href="aboutus.css">

</head>


<body onunload="" class="scrollable">

<?php
    require_once 'required/pageloader.php';
?>    
    <header>
        <a href="index.php"> <img src="./images/logowhite.png" alt="" class="logo"></a>
        <h1>

        How Can We Help You?

        </h1>
    </header>

    <div class="container">

        <h2>
            Are You A Student Trying To Register?
        </h2>

        <div class="col">

            <br>
            <div class="left-col">
            <img src="images/student_cap.png" alt="">

            </div>
            <div class="right-col">
            <p>
                    <a href="signup.php"> Click Right Here </a>
                    To Register And Make A Run For Your New Home!
            </p>
            <p>
                Already Registered? 
                <a href="login.php"> LogIn</a>
                Instead!
            </p>
          </div>
        </div>
            <h2>
                Are You A Home Owner Trying To Register?
            </h2>

        <div class="col">

        <div class="left-col">        
                <img src="images/homeowner_house2.png" alt="">
            </div>
            <div class="right-col"> 
                <p>
                <a href="advertise/index.php"> Click Right Here </a>
                To Register Your Home!
                </p>
                <p>
                    Already Registered? 
                    <a href="homeownerlogin.php"> LogIn</a>
                    Instead!
                </p>
            </div>
       
        </div>
        <br>
        <h2>
            Are You An Agent Trying To Register?
        </h2>

        <div class="col">
            <br>

<div class="left-col">        
        <img src="images/agent.png" alt="">
    </div>
    <div class="right-col"> 
        <p>
        <a href="./agent/agent_register.php"> Click Right Here </a>
        To Register As An Agent!
        </p>
        <p>
            Already Registered? 
            <a href="./agent/index.php"> LogIn</a>
            Instead!
        </p>
    </div>
<br>
</div>
        <p style = "margin-bottom: 0;">We would love to hear from you.
            <br>email us:
        </p>
        <p style = "color: rgb(252,153,82)">
        <a href="mailto:info@casamax.co.zw?subject=Feedback to Casamax&cc=c">info@casamax.co.zw</a>
         
        </p>

    </div>

</body>