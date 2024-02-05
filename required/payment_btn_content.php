<?php
    $sql = "SELECT * FROM homerunuserdb WHERE userid = ?";
    $stmt = mysqli_stmt_init($conn);
   
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("refresh:s$sec; ../payment.php?error=sqlerror");
        echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
        exit();

    }else{
        mysqli_stmt_bind_param($stmt, "s",$_COOKIE['cookiestudent']);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($results)){

            $userid = $row['userid'];
            $uni =  $row['university'];
            $firstname = $row['firstname'];
            $email = $row['email'];
            $check_sub = "SELECT * FROM subscribers WHERE userid ='" .$userid."'";
            $sub_db_check = mysqli_query($conn,$check_sub);

            if(!$sub_db_check){
                header("refresh:$sec;../payment.php?PleaseSubscribe");
                    exit();
            }else{
                $rowCount = mysqli_num_rows($sub_db_check);
                if($rowCount > 0){
                    header("Refresh:0.1; ../index.php?Already_Subscibed");
                    echo '<script type="text/javascript"> alert("You Are Already Subscribed!!") </script>';

                }else{
                   
                    $this_date = date('y-m-d');
                    $start_at = strtotime(date($this_date));
                    $next = get_next_billing_date($start_at,null,$time_unit,$period);
                    $next_date = date('Y-m-d', $next);
                   
                    $sql = "INSERT INTO subscribers (userid, date_of_sub, type_of_sub, end_of_sub) VALUES ('".$userid."' , '".$this_date."','".$sub_type."', '".$next_date."')";

                 if(mysqli_query($conn, $sql)){

                    header("refresh:$sec;../thank_you.php?university=".$uni."&firstname=". $firstname);
                    echo '<script type="text/javascript"> alert("You have successfully subscribed for our '.$sub_type.' package. ENJOY!!") </script>';
                    
                    $_SESSION['sessionstudent'] = $email;

                }else{
                    header("Location: ../payment.php");
                    echo '<script type="text/javascript"> alert("Sorry!! we are facing difficulties with your subscription") </script>';
            
                }
                }
            }
        }
    }
?>