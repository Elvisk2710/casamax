<?php
session_start();
$sec = "0.1";

if (isset($_POST['submit'])) {

   require 'homerunuserdb.php';

     $email = $_POST['email'];
     $password = $_POST['password'];
   
     $email = filter_var($email,FILTER_SANITIZE_EMAIL);
 
    if (empty($email) or empty($password)){ 
        header("refresh:$sec; ../login.php?error=emptyfields");
        echo '<script type="text/javascript"> alert("Empty Fields") </script>';
        exit();
    }else{
        $sql ="SELECT * FROM homerunuserdb WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
       header("refresh:s$sec; ../login.php?error=sqlerror");
       echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
       exit();

    }else{
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($results)){
        $passcheck = password_verify($password, $row['passw']);
        //  checking if the password is equal to the stored password
        if($passcheck == false){
            header("Refresh: $sec; URL = ../login.php?error=wrongpass");
            echo '<script type="text/javascript"> alert("Wrong Password!") </script>';

        }elseif($passcheck == true) {
            $email = $row['email'];
            $userid = $row['userid'];
            $uni =  $row['university'];

// query for subscribers table
            $sub_check = "SELECT * FROM subscribers WHERE userid = '".$userid."'";
            $sub_db_check = mysqli_query($conn,$sub_check);
                                        
// check if the user is subscribed.
            if (!$sub_db_check) {
                header("refresh:$sec;  ../login.php?error=sqlerror");
                exit();          
            }else{ 
                $rowCount = mysqli_num_rows($sub_db_check);
                        
// checking if the user id is in the subcribers database
                if(!$rowCount > 0) {
                    setcookie("cookiestudent", $userid, time() + (86400 * 1), "/");
                    setcookie("emailstudent", $email, time() + (86400 * 1), "/");
                    header("location: ../payment.php?subscribe");
                    echo '<script type="text/javascript"> alert("Enjoy Our Full Services By Subscribing!!") </script>';
                                          
                }else{
                    $results = mysqli_fetch_array($sub_db_check);
                    $today = strtotime(date('y-m-d'));
                                
                    if(strtotime($results['end_of_sub']) < $today){

                        $sub_check = "DELETE FROM subscribers WHERE userid = '".$userid."'";

                        if($sub_remove = mysqli_query($conn,$sub_check)){
                            header("refresh:0.1; ../payment.php?subscription has ended");               
                            echo '<script type="text/javascript"> alertpl("Subscription Has Ended!") </script>';                       
                            exit();
                        }else{
                            header("refresh:$sec;  ./index.php?error=sqlerror");
                            echo '<script type="text/javascript"> alert("SQL ERROR!!")</script>';
                            exit();   
                        }
                                 
                    }else{
                        $_SESSION['sessionstudent'] = $email;
                        // the page where there will be directed to
 
                        if($uni == "University of Zimbabwe" ){
                            header("Location: ../unilistings/uzlisting.php?success=". $email);
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                        
                        }elseif($uni =="Midlands State University"){
                            header("Location: ../unilistings/msulisting.php?success=". $email);
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                            
                        }elseif($uni =="Africa Univeristy"){
                            header("Location: ../unilistings/aulisting.php?success=". $email);
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                            
                        }elseif($uni =="Bindura State University"){
                            header("Location: ../unilistings/bsulisting.php?success=". $email );
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                            
                        }elseif($uni =="Chinhoyi University of Science and Technology"){
                            header("Location: ../unilistings/cutlisting.php?success=". $email );
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                            
                        }elseif($uni =="Great Zimbabwe University"){
                            header("Location: ../unilistings/gzlisting.php?success=". $email );
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                            
                        }elseif($uni =="Harare Institute of Technology"){
                            header("Location: ../unilistings/hitlisting.php?success=". $email );
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                            
                        }elseif($uni =="National University of Science and Technology"){
                            header("Location: ../unilistings/nustlisting.php?success=". $email);
                            echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }else{
            // for the wrong password
            header("refresh:$sec; ../login.php?error=wrongpass");
            echo '<script type="text/javascript"> alert("Wrong Password") </script>';
            exit();
            
        }
        
    }else{
        // if user is not found
        header("Refresh:$sec; ../login.php?error=UserNotFound");
        echo '<script type="text/javascript"> alert("OOPS! Could Not Find User") </script>';
        exit();
        
    }
        
    }
        
    }

 // logging out 
 }elseif(isset($_POST['logout'])){
    
    if(isset($_SESSION['sessionstudent'])){
        session_destroy();
        
    }
    header("refresh:$sec; ../index.php?error=LoggedOut");
    echo '<script type="text/javascript"> alert("You Have Successfully Logged Out") </script>';
    exit();
}

?>