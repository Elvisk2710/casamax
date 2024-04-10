<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpMailer/PHPMailer-master/src/Exception.php';
require '../phpMailer/PHPMailer-master/src/PHPMailer.php';
require '../phpMailer/PHPMailer-master/src/SMTP.php';

try {
    $rand = rand(10000, 1000000);
    setcookie("code", $rand, time() + (900 * 1), "/");
    $_SESSION['code'] = $rand;

    $message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
        <div class= "container">
        <header>
            <h1>THANK YOU FOR USING CASAMAX</h1>
        </header>
        
        <h2>HEY ' . $firstname . '!!<h2><br>
        <h3>Your CasaMax Code is:</h3><br>
            <h1>' . $rand . '</h1>
        </div>
        </body>
        
        <style>
            *{
                margin: 0;
                padding: 0; 
                box-sizing: border-box;
                -webkit-tap-highlight-color: transparent;
            }
    
            .container{
                margin: 0px 10% auto;
                text-align: justify;
                padding: 8%;
            }
    
            body{
                background-color: white;
                align-items: center;
                background-color: rgb(8, 8, 12);
    
            }
            header{
                background-color: rgb(252, 153, 82);
                text-align: center;
                padding-bottom: 10px;
                background-size: cover;
                border-radius: 10px;
            }
            img{
                width: 5vw;
                min-width: 40px;
                height: 5vw;
                min-height: 40px;
                margin-top: 10px;
   
            }
    
            h1{
                
                font-size: 15vh;
                color: rgb(252, 153, 82);
                font-family: "Playfair Display", serif;    
                text-align: center;
                margin-bottom: 1.4vw;
                line-height: 4vw;
                font-weight: 600;
            }
            h3{
                text-align: center;
                margin: 2rem;
                font-weight: 600;
                font-family: "Lato", sans-serif;
                font-size: 14px;    
                color: rgb(252, 153, 82);
            
            }
            h2{
                text-transform: uppercase;
                color:   rgb(252, 153, 82);
                text-align: center;
                margin: 4rem;
                font-weight: 600;
                font-family: "Josefin Slab", serif; 
                font-size: 30px;    
            
            }
    
        </style>
    
        </body>
        </html>
    ';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;
    $mail->Username = 'casamaxzim@gmail.com';
    $mail->Password = 'znvsyhhgoivwzyds';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('casamaxzim@gmail.com', 'Casamax Investments');

    // Validate and sanitize email address
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        header("location: ./agent_register.php?error=Invalid email address!");
        exit('Invalid email address');
    }

    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if (!$mail->send()) {
        $mailStatus = "failed";
        echo 'Email sending failed: ' . $mail->ErrorInfo;
        echo '<script>alert("Email sending failed: "' . $mail->ErrorInfo . ')</script>';
    } else {
        $mailStatus = "success";
        echo '<script>alert("Email sent successfully")</script>';
    }
} catch (Exception $e) {
    echo 'SMTP connection failed: ' . $e->getMessage();
}
