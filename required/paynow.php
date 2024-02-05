<?php 
try{
    $phone = $_POST["phone_number"]; // Sanitize data
    $platform = "";
    
    require_once '../Paynow-PHP-SDK-master/autoloader.php';
    
    $paynow = new Paynow\Payments\Paynow(
        '15123 ',
        '6e65b63a-6da2-4685-a277-855713f19af1',
        'http://example.com/gateways/paynow/update',
        // The return url can be set at later stages. You might want to do this if you want to pass data to the return url (like the reference of the transaction)
        'http://example.com/return?gateway=paynow'
    );
    
    # $paynow->setResultUrl('');
    # $paynow->setReturnUrl('');
    $invoice_name = "Invoice " . time();
    $user_email = filter_var($_COOKIE['emailstudent'], FILTER_SANITIZE_EMAIL);
    if(!$payment = $paynow->createPayment($invoice_name, 'casamaxzim@gmail.com')){
        echo '<script>
                alert("Failed to connect to Paynow Connection Time-Out");
            </script>';
    }else{
        $payment->add($sub_type, $amount);
        
        // Detect platform and send payment
            if(str_starts_with($phone, '071')){
                $platform= "onemoney";
            }else if(str_starts_with($phone, '073')){
            $platform = "telecash";
            }else{
            $platform = "ecocash";
            }

        if(!$response = $paynow->sendMobile($payment, $_POST['phone_number'], $platform)){
            echo '<script>
                    alert("Failed to send SSD");
                </script>';
                exit();
        }else{

            if($response->success()){

                $pollUrl = $response->pollUrl();
                
                //listen to status update changes using ajax after test
                $timeout = 9;
                $count = 0;
                $success = false;
                $status = $paynow->pollTransaction($pollUrl);

                while($success == false){

                        sleep(3);
                        // get status of the transaction

                        // check if paid
                        if($status->paid()) {     
                        $success = true;
                        setcookie("success", "true", time() + (8600 * 1), "/");
                        require_once 'payment_btn_content.php';
                        }

                    $count++;
                    
                    if ($count > $timeout){
                        header('location: ../payment.php?error=TransactionTimeoutReached&success=false');
                        echo '<script> alert("Transaction Timeout Reached")</script>';
                        exit();
                        }
                }
            }else{
                header('location: ../payment.php?success=false');
                echo "<script> alert('Transaction failed') </script>";
                exit();

            }
        }
    }
}catch(Exception $ex){
    header("location: ../payment.php?error=FailedToConnectToPayNow");
}
?>