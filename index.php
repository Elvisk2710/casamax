<?php
if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || 
    $_SERVER['HTTPS'] == 1) ||  
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&   
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
{
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

    session_start();
    require './required/ads_query.php';
    setcookie("search", "search", time() + (-86400 * 1), "/");
    setcookie("filter", "filter", time() + (-86400 * 1), "/");
    setcookie("page_name", "", time() + (-86400 * 1), "/");
    setcookie("uni_folder", "", time() + (-86400 * 1), "/");    
    setcookie("clicked_id", "", time() + (-86400 * 1), "/");   
    setcookie("pricesearch", "", time() + (-86400 * 1), "/");    
    setcookie("code", "", time() + (-900 * 1), "/");    
    setcookie("email","", time() + (-900 * 1), "/");   
    
      //  pop-up for install
    require './required/app_install.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-site-verification" content="3DpOPyMzbY1JYLNtsHzbAZ_z6o249iU0lE5DYE_mLJA" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CasaMax LandingPage</title>
    <link rel="stylesheet" href="index.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <meta name="description" content=" Student boarding-houses in Zimbabwe at affordable prices....">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" type="image/png" href="./images/logowhite.png">
    <meta name="theme-color" content="#08080C"/>
    <link rel="apple-touch-icon" href="images/android-icon-192x192-seochecker-manifest-4016.png">
    <!--<script async src="https://fundingchoicesmessages.google.com/i/pub-5154867814880124?ers=1" nonce="FAQn2jAMsnFBc1XDFT5Hkg"></script>-->
    <!--<script nonce="FAQn2jAMsnFBc1XDFT5Hkg">(function() {function signalGooglefcPresent() {if (!window.frames['googlefcPresent']) {if (document.body) {const iframe = document.createElement('iframe'); iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;'; iframe.style.display = 'none'; iframe.name = 'googlefcPresent'; document.body.appendChild(iframe);} else {setTimeout(signalGooglefcPresent, 0);}}}signalGooglefcPresent();})();</script>-->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5154867814880124"   crossorigin="anonymous"></script>
<!-- Google tag (gtag.js) -->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-M41618R5FH"></script>-->
<!--<script>-->
<!--  window.dataLayer = window.dataLayer || [];-->
<!--  function gtag(){dataLayer.push(arguments);}-->
<!--  gtag('js', new Date());-->

<!--  gtag('config', 'G-M41618R5FH');-->
<!--</script>-->
<!--</script>-->
    
</head>
<script src="index.js"></script>

<body onunload="" >

<div class="container ">

    <header>
        <a href="index.php">
           <img src="images/logowhite.png" alt="logo" class="logo">
        </a>

       <nav id="navBar">
        <h3 class="smltxt">CasaMax</h3>
        <img src="images/menu.webp" alt="menu" onclick="togglebtn()" class="fas">
        <br>
        <a href="https://casamax.co.zw/" class="home">HOME</a>
        <a href="bordinghouse.php">BOARDING-HOUSE</a>
        <a href="./manage/index.php">MANAGE RENTAL</a>
        <a href="advertise_as/index.php">ADVERTISE</a>
        <a href="help.php">HELP</a>
        <a href="loginas.php" class="sign_in" name="loginbtn">LOGIN</a>
      
    </nav>
    
<!-- popup for cookie consent -->
<div class="consent hide">
<button  class="cookie_btn">
        I UNDERSTAND!
    </button>
    <img src="images/cookies3.webp" alt="">
    <h2>
        We Use Cookies!!
    </h2>
    <p>
    We use cookies and other technologies to help personalize content and provide for a better experience. Without cookies some functionalities will not function properly!!
    </p>
   
    

    <script>
         window.onload = function(){
        const cookieBox = document.querySelector(".consent"),
        acceptBtn = cookieBox.querySelector("button");
        acceptBtn.onclick = ()=>{
           document.cookie = "HomeRun=HomeRunCookie; max-age="+60*60*24*30;
           if(document.cookie){
            cookieBox.classList.add("hide");
           }else{
            alert("Cookie can't be set! Please visit your setting and remove cookie restrictions for this site")
           }
        }
        let checkCookie = document.cookie.indexOf("HomeRun=HomeRunCookie");
        checkCookie != -1 ? cookieBox.classList.add("hide"): cookieBox.classList.remove("hide");
    }
    </script>
</div>

<!-- main content -->
    <h1>
        Casa,<br>
        Max
    </h1>
   <a href="#cta" style="color:white; text-decoration: none;  animation: text 2s ease infinite;">Click to know about us!</a>
        
        <p class="srch-p">
            Find Your Next Home    
        </p>
    <div class="search-bar">
        <form method="POST" action="homerunphp/searchaction.php">

        <div class="search-form">
        <div class="left-col"> 
            
            <select name="university" id="dropdown">

                <option value="none">Choose a University</option>
                <option value="University of Zimbabwe">University of Zimbabwe</option>
                <option value="Midlands State University">Midlands State University</option>
                <option value="Africa Univeristy">Africa Univeristy</option>
                <option value="Bindura State University">Bindura State University</option>
                <option value="Chinhoyi University of Science and Technology">Chinhoyi University of Science and Technology</option>
                <option value="Great Zimbabwe University">Great Zimbabwe University</option>
                <option value="Harare Institute of Technology">Harare Institute of Technology</option>
                <option value="National University of Science and Technology">National University of Science and Technology</option>

            
            </select>  
   
        </div>

        <div class="right-col">
          <input type="number" name="pricesearch"  min="0" placeholder="Max amount per Month in USD$?" required title="Enter an amount in USD">

        </div>

        </div>

        <div class="search-btn">
               
            <button name=" ">
                <img src="images/searchicon.webp" alt="search">

            </button>

        </div>
        </form>
    </div>
    </header>
<!-- BROWSE Student -->
    <div class="containersub">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5154867814880124"
                crossorigin="anonymous"></script>
                <ins class="adsbygoogle"
                style="display:block"
                data-ad-format="fluid"
                data-ad-layout-key="-f9+5v+4m-d8+7b"
                data-ad-client="ca-pub-5154867814880124"
                data-ad-slot="8966832753"></ins>

            <script>
                
                    (adsbygoogle = window.adsbygoogle || []).push({});
                
            </script>
        <hr>
        <h2 class="sub-title">
            BROWSE
            <p>
                (BOARDING HOUSES BY UNI)
            </p>
        </h2>
       <hr>
        <div class="browse">

        <a href="./unilistings/uzlisting.php">  
            <div>             
                <img src="./images/UZ.webp" alt="">

                <h3>University of Zimbabwe</h3> 
                
            </div> 
        </a>
        <a href="unilistings/aulisting.php">

            <div>
                <img src="./images/AU.webp" alt="">

                <h3>
                    Africa University
                </h3>

            </div>
            </a>

            <a href="unilistings/cutlisting.php">
            <div>

                <img src="./images/CUT.webp" alt="">
                
                <h3>
                    Chinhoyi University of Technology
                </h3>
            </div> 
            </a>

            <a href="unilistings/gzlisting.php">
            <div>
                <img src="./images/GZ.webp" alt="">
                
                <h3>
                    Great Zimbabwe University
                </h3>
            </div> 
            </a>

            <a href="unilistings/hitlisting.php">
            <div>
                <img src="./images/HIT.webp" alt="">
                
                <h3>
                    Harare Institute of Technology
                </h3>
            </div> 
            </a>

            <a href="unilistings/msulisting.php">
            <div>
                <img src="./images/MSU.webp" alt="">
                <h3>
                    Midlands State University
                </h3>
               
            </div>
            </a>

            <a href="unilistings/nustlisting.php">
            <div>
                <img src="./images/NUST.webp" alt="">
                <h3>
                    National University of Science and Technology
                </h3>

            </div> 
            </a>

            <a href="unilistings/bsulisting.php">
            <div>
                <img src="./images/BSU.webp" alt="">
                <h3>
                    Bindura University of Science and Education
                </h3>
        
            </div>
            </a>
            </div>
            
            <!--Google Ads-->
            
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5154867814880124"
                 crossorigin="anonymous">
            </script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-format="autorelaxed"
                 data-ad-client="ca-pub-5154867814880124"
                 data-ad-slot="3508250228"></ins>
            <script>
                window.onload = function(){
                 (adsbygoogle = window.adsbygoogle || []).push({});
                }
            </script>

        <div class="cta" id="cta">
            <h3>
                Sharing Is Earning
            </h3>
            <p>
                Grasp The Great Opportunity to make money with shared spaces.
            </p>
           
                <a href="know_more.php"> <button  class="cta-btn"> Know More  </button></a>
           
        </div>
    </div>
    <hr>
   
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
           <p class="abt">
              <a href="../privacy_policy.html">Our Privacy Policy</a> 
      
              <a href="../disclaimer.html">Disclaimer</a>
          </p>

         
      
        <div class="socialicons">
          <a href="https://www.facebook.com/Homerunzim-102221862615717/" data-tabs="timeline"><img src="./images/facebook.png" alt="" title="Our-Facebook-page"></a>
          <a href="https://www.instagram.com/homerunzim/"><img src="./images/instagram.png" alt="" title="Our-Instagram-page"></a>
          <a href="https://wa.me/+263786989144"> <img src="./images/whatsapp.png" alt="" title="Our-WhatsApp-page"></a>
          <a href="mailto:homerunzim@gmail.com?subject=Feedback to HomeRun&cc=c"> <img src="./images/mail.png" alt="" title="Email"></a>
          <a href=""><img src="./images/twitter.png" alt="" title="Our-twitter-page"></a>
      </div>
    </div>
  </div>
   
 <script  src="./jsfiles/onclickscript.js"></script>
<script src="app.js"></script>
</body>

</html> 