<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
$table = $_COOKIE['page_pass'];

require 'homerunuserdb.php';

if(isset($_POST['submit_code'])){
    $code = $_POST['code'];

    if($code == $_COOKIE['code']){
        $email = $_COOKIE['email'];
       
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
      
        $sql ="SELECT * FROM  $table WHERE email = '$email'";
           
            $results = mysqli_query($conn,$sql);
           
            if($row = mysqli_fetch_assoc($results)){
        
                $hashed_password = password_hash($_COOKIE['password'], PASSWORD_DEFAULT);
                $sqlupdate = "UPDATE $table SET passw  = '$hashed_password' WHERE email = '$email' ";
                $updatesql = mysqli_query($conn,$sqlupdate);

                if($sqlupdate){
                    setcookie("code", '', time() + (-900 * 1), "/");    
                    setcookie("password", '', time() + (-900 * 1), "/"); 
                    header("Refresh:0.1, ../".$_COOKIE['loginPage']."");
                    echo '<script type="text/javascript"> alert(" YOU HAVE SUCCESSFULLY CHANGED YOUR PASSWORD") </script>';


                }
            }
           
    }else{
        header("Refresh:0.1, ../required/code.php");
        echo '<script type="text/javascript"> alert("SORRY YOUR CODE DOES NOT MATCH!!") </script>';

    }
}elseif(isset($_POST['submit'])){
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
   
    if($password != $confirm_pass){
        echo'<script type="text/javascript"> alert("OOPS! Passwords Do Not Match") </script>';
        header("Refresh:0.1, ../required/fpass.php");
        if(empty($email) or empty($password) or empty($confirm_pass)){
            echo'<script type="text/javascript"> alert("Please Fill Out The Form") </script>';
        }

    }else{
        setcookie("password", $password, time() + (900 * 1), "/");  

        $sql ="SELECT * FROM $table WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("refresh:s$sec; ../".$_COOKIE['loginPage']."?error=sqlerror");
            echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
            exit();

        }else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($results)){



require '../phpMailer/PHPMailer-master/src/Exception.php';
require '../phpMailer/PHPMailer-master/src/PHPMailer.php';
require '../phpMailer/PHPMailer-master/src/SMTP.php';
$firstname = $row['firstname'];
$rand = rand(10000,1000000);
setcookie("code", $rand, time() + (900 * 1), "/");  
setcookie("email", $email, time() + (900 * 1), "/");  

$subject = 'code to change password';
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
                <h1>CODE FOR YOUR NEW</h1>
                </header>
                
                <h2>HEY!! '.$firstname.'<h2><br>
                <h3>Your CasaMax Code is:</h3><br>
                    <h1>'.$rand.'</h1>
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
    $mail -> isSMTP();
    $mail->Host = 'smtp.gmail.com';
    
    $mail->SMTPAuth = true;
    $mail->Username ='casamaxzim@gmail.com';
    $mail->Password = 'slqbgtkppyrljpek';
    
    $mail->SMTPSecure = 'ssl';
    $mail->Port = '465';
    
    $mail->setFrom('casamaxzim@gmail.com');
    
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail -> Body = $message;
                
$mail->send();

    header("refresh:0.1; ../required/code.php");
    echo"<script>
            alert('Email has been sent successfully')
        </script>";
            }else{
                header("Refresh:0.1, ../required/fpass.php");
                echo '<script> alert("No user found with this email!!")</script>';

            }
        }
    }
}
?>