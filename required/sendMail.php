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

    $message =
        '<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Using Casamax.co.zw</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: rgb(8, 8, 12);
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: rgb(252, 153, 82);
        }
        .verification-code {
            margin-top: 20px;
            font-size: 18px;
            padding: 10px;
            background-color: rgb(252, 153, 82);
            color: white;
            border-radius: 4px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: rgb(8, 8, 12);
        }
        .footer a {
            color: rgb(8, 8, 12);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Thank You for Using Casamax.co.zw</h2>
        <p>Dear' . ucfirst(htmlspecialchars($firstname)) . ',</p>
        <p>Thank you for choosing Casamax.co.zw. Your satisfaction is important to us.</p>
        <p>Below is your verification code:</p>
        <div class="verification-code">' . $rand . '</div>
        <p>If you have any questions or need further assistance, please feel free to contact us.</p>
        <div class="footer">
            <p>This email is sent from Casamax.co.zw. For more information, please review our <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a>.</p>
        </div>
    </div>
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
        redirect(' ../agent/agent_register.php?error=Invalid email address!');
        exit();
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
    redirect(' ../agent/agent_register.php?error=SMTP connection failed: ' . $e->getMessage());
    exit();
}
