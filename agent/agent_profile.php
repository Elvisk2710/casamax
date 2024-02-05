<?php
    session_start();
    require_once '../homerunphp/advertisesdb.php';

    if(empty($_SESSION['sessionagent'])){
        header("Location:index.php?PleaseLogin");
        echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
        exit();
    }else{
        $user = $_SESSION['sessionagent'];
        $sql = "SELECT * FROM  agents WHERE email = '$user' ";
        setcookie("update", $user, time() + (86400 * 1), "/");
        if ($rs_result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_array($rs_result);
            $agent_id = $row['agent_id'];
            setcookie("agent_id",$agent_id,time()+(900 * 1), "/");
            $sql_home = "SELECT * FROM  homerunhouses WHERE agent_id = '$agent_id' "; 

            if (!$home_result = mysqli_query($conn,$sql_home)){
                header("Location:index.php?SQL_ERROR");
                echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
                exit();
            }
        }else{
            header("Location:index.php?PleaseLogin");
            echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
            exit();
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-48DWXXLG5F"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-48DWXXLG5F');
</script>
<link rel="icon" href="../images/logowhite.png">
    <meta name="google-site-verification" content="3DpOPyMzbY1JYLNtsHzbAZ_z6o249iU0lE5DYE_mLJA" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="agent_profile_css.css">
    <title>Agent Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <meta name="description" content=" Quick and Easy way to find your next home off-campus for tertiary students at an affordable price....">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#08080C"/>
    <link rel="apple-touch-icon" href="images/android-icon-192x192-seochecker-manifest-4016.png">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@300&family=Oswald:wght@600&family=Quicksand&family=Source+Sans+3:wght@200&display=swap" rel="stylesheet">
    <style> @import url('https://fonts.googleapis.com/css2?family=Inconsolata:wght@300&family=Oswald:wght@600&family=Quicksand&family=Source+Sans+3:wght@200&display=swap'); </style>
     <script async src="https://fundingchoicesmessages.google.com/i/pub-5154867814880124?ers=1" nonce="FAQn2jAMsnFBc1XDFT5Hkg"></script><script nonce="FAQn2jAMsnFBc1XDFT5Hkg">(function() {function signalGooglefcPresent() {if (!window.frames['googlefcPresent']) {if (document.body) {const iframe = document.createElement('iframe'); iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;'; iframe.style.display = 'none'; iframe.name = 'googlefcPresent'; document.body.appendChild(iframe);} else {setTimeout(signalGooglefcPresent, 0);}}}signalGooglefcPresent();})();</script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5154867814880124"   crossorigin="anonymous"></script>
</head>

<body onunload="" class="scrollable">
<?php
    require_once '../required/pageloader.php';
?>
<header>

    <div class="logo_container">
    <a href="../index.php"><img src="../images/logowhite.png" alt="logo" class="logo"></a>
    <?php if(isset($_GET['error'])){
        $error = $_GET['error'];
        echo '<div class="error" id = "error">
            <h1>'.
                $error
            .'</h1>
        </div>';
    }?>
        <div class="logout_div">
            <form action="./agent_login_script.php" method="post">
                <button class="edit_info_button" name="logout">
                    Log-Out
                </button>
            </form>
        </div>
    </div>

    <div class="header_container">

    <br>
    <div class="details">    
    <div class="name">
    <h1>
       Hey  <?php echo $row['lastname'].' '.$row['firstname'] ?>!
    </h1>
    </div>
    <div class="agent_details">    
  

        <span>
            <h3>
                Agent ID
            </h3>
            <p>
              <?php echo $row['agent_id']?>
            </p>
        </span>
        <span>
            <h3>
                Contact
            </h3>
            <p>
            <?php echo $row['contact']?>
            </p>
        </span>
        <span>
            <h3>
                Email
            </h3>
            <p>
            <?php echo $row['email']?>
            </p>
        </span>
        <span>
            <h3>
                Verified
            </h3>
            <p>
            <?php 
            if ($row['verified'] == 1){
                echo 'Yes';
            }else{
                echo 'No';
            }
            ?>
            </p>
        </span>
    </div>
    </div>
    
    </div>

    <div class="change_info">
        <button class="change_info_btn" onclick="open_agent_change_info()">
            Change My Info
        </button>
    </div>
</header>
<br>
<div class="label">
    <h1>
        My Listings...
    </h1>
</div>
<div class="container">
    <?php
    
while($home_row = mysqli_fetch_array($home_result)){

    $uni = $home_row['uni'];

                if($uni === "University of Zimbabwe"){
        $folder = "uzpictures";

    }elseif($uni === "Midlands State University"){
        $folder = "msupictures";

    }elseif($uni === "Africa Univeristy"){
        $folder = "aupictures";
            
    }elseif($uni === "Bindura State University"){
        $folder = "bsupictures";

    }elseif($uni ==="Chinhoyi University of Science and Technology"){
        $folder = "cutpictures";

    }elseif($uni === "Great Zimbabwe University"){
        $folder = "gzpictures";
            
    }elseif($uni === "Harare Institute of Technology"){
        $folder = "hitpictures";

    }elseif($uni === "National University of Science and Technology"){
        $folder = "nustpictures";

    }
        echo '<a href="house.php?home_id='.$home_row['home_id'].'&folder='.$folder.'" target="" class="listings">
            <img src="../housepictures/'.$folder.'/'.$home_row['image1'].'" id ='.$home_row['home_id'].'alt="" title="tap to manage" >
        </a>';
            
    }
        $total_records = mysqli_num_rows($home_result);
        if($total_records < 100){
            echo '<div class="listings" onclick="AddHouse()">
                    <img src="../images/add.png" alt="" class="add" title="tap to add listing" style="box-shadow: 0 0 0 0";>
                </div>';
        }
    ?>
   
</div>
<div class="footer">
            <h3 class="abt">
              <a href="../aboutus.php">About</a> CasaMax
            </h3>
            <p>
              Looking for a House to Rent?
          Welcome to CasaMax, where we provide all the available
          Homes and Rental properties at the tip of your fingers
          </p>
         
      
        <div class="socialicons">
        <a href="https://www.facebook.com/Homerunzim-102221862615717/" data-tabs="timeline" target="blank"><img src="../images/facebook.png" alt="" title="Our-Facebook-page"></a>
          <a href="https://www.instagram.com/casamax.co.zw/" target="blank"><img src="../images/instagram.png" alt="" title="Our-Instagram-page"></a>
          <a href="https://wa.me/+263786989144" target="blank"> <img src="../images/whatsapp.png" alt="" title="Our-WhatsApp-page"></a>
          <a href="mailto:casamaxzim@gmail.com?subject=Feedback to CasaMax&cc=c" target="blank"> <img src="../images/mail.png" alt="" title="Email" ></a>
          <a href="" target="blank"><img src="../images/twitter.png" alt="" title="Our-twitter-page"></a>
      </div>
    </div>
  </div>
  <?php
  
        require 'add_house.html';

        require 'agent_change_info.html';
    ?>

<script src="./agent_script.js"></script>
<script>
    setTimeout(() => {
  const box = document.getElementById('error');

  //removes element from DOM
box.style.display = 'none';
}, 5000); // time in milliseconds
</script>
</body>
</html>