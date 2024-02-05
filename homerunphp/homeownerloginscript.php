<?php
session_start();
$sec = "0.1";
setcookie("scriptPage","homeownerloginscript.php",time()+(900 * 1), "/");

if (isset($_POST['submit'])) {

    require 'homerunuserdb.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
   
    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
   
    if (empty($email) or empty($password)){ 
        header("refresh:$sec;  ../homeownerlogin.php?error=emptyfields");
        echo '<script type="text/javascript"> alert("Empty Fields") </script>';
        exit();
    }else{
        $sql ="SELECT * FROM homerunhouses WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("refresh:$sec;  ../homeownerlogin.php?error=sqlerror");
            echo '<script type="text/javascript"> alert("SQL Error") </script>';
            exit();

        }else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($results)){

                $passcheck = password_verify($password, $row['passw']);

                if($passcheck == false){
                    header("refresh:$sec; ../homeownerlogin.php?error=wrongpass");
                    echo '<script type="text/javascript"> alert("Wrong Password") </script>';
                exit();

                }elseif($passcheck == true) {
                    $_SESSION['sessionowner'] = $row['email'];
                    header("refresh:$sec;  ../profile.php?loginsuccess");
                    echo '<script type="text/javascript"> alert("You Have Logged-In Successfully") </script>';
                    exit();
                }
            }else{
                header("refresh:$sec;  ../homeownerlogin.php?error=UserNotFound");
                echo '<script type="text/javascript"> alert("User Not Found") </script>';
                exit();

            }
        }
    }


}elseif(isset($_POST['logout'])){
    if(isset($_SESSION['sessionowner'])){
        session_destroy();
            header("refresh:$sec; ../index.php?error=LoggedOut");
            echo '<script type="text/javascript"> alert("You Have Successfully Logged Out") </script>';
        exit();
    }else{
            header("refresh:$sec; ../index.php");
            echo '<script type="text/javascript"> alert("You Have Successfully Logged Out") </script>';
        exit();
    }
    
}else{
    header("refresh:$sec;  ../index.php?error=accessdenied");
    echo '<script type="text/javascript"> alert("Access Denied") </script>';
    exit();

}

?>