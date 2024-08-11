<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Arvo:wght@700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Hind:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Josefin+Slab:wght@500&family=Lato:wght@300&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"><meta name="description" content="Our staff is committed to help you choose the right Home. Home Student Rental Real Estate Business. ">
<script src="https://kit.fontawesome.com/d7eaee5a56.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../signup.css">
<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">

<?php
    require './alerts.php';
?>
</head

<body onunload="" class="scrollable">
<header>
    <a href="../index.php"><img src="../images/logowhite.png" alt="logo" class="logo"></a>
</header>


<div class="container">
<?php
    if ($_GET['agent'] == true){
        $action = '../agent/agent_register_script.php';
    }else{
        $action = '../homerunphp/register_code_verification.php';

    }
?>
<form action= "<?php echo $action?>" method="post">
        
        <h3 class="h3reg">Enter Code</h3>

        <h4> Email has been sent to <?php echo $_COOKIE['email']; ?></h4>

            <p>Can not find Code? Check in the spam folder</p>

            <div class="input-label">
                <label for="code">Enter Code<span style="color: red; font-size:10px;">*</span></label>
                <input type="number" id="phone" placeholder="Enter Code" name= "code" min="0" required title="Enter your code" >
                
            </div>
            <div class="login">
            <div >
                <button type="submit" name="register_code" class="login_btn" onclick="button_cookie()">
                    REGISTER
                </button>
                <br>
            
            </div>

            </div>
    </form>
</div>

</body>
</html>