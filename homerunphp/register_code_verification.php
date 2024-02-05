<?php
$sec = "0.1";
//add database connection
require 'homerunuserdb.php';


if(isset($_POST['register_code'])){
    $code = $_POST['code'];
    // checking if the code is valid
    if($code == $_COOKIE['code']){

        // preparing variables
        $email = $_COOKIE['email'];
        $firstname = $_COOKIE['firstname'];
        $lastname = $_COOKIE['lastname'];
        $password = $_COOKIE['password'];
        $confirmpass = $_COOKIE['confirmpass'];
        $dob = $_COOKIE['dob'];
        $gender = $_COOKIE['gender'];
        $contact = $_COOKIE['contact'];
        $uni = $_COOKIE['uni'];
        
                $lastid = mysqli_insert_id($conn);

                    $randcode = rand(1,99999);
                    switch ($uni){
                        case "University of Zimbabwe":
                            $uni_code = "uz";
                            break;
                            case "Midlands State University":
                                $uni_code = "msu";
                                break;
                                case "Africa Univeristy":
                                    $uni_code = "au";
                                    break;
                                    case "Bindura State University":
                                        $uni_code = "bsu";
                                        break;
                                        case "Chinhoyi University of Science and Technology":
                                            $uni_code = "cut";
                                            break;
                                            case "Great Zimbabwe University":
                                                $uni_code = "gzu";
                                                break;
                                                case "Harare Institute of Technology":
                                                    $uni_code = "hit";
                                                    break;
                                                    case "National University of Science and Technology":
                                                        $uni_code = "nust";
                                                        break;
                    }
                        
                
                $userid = $uni_code."_".$randcode."_".$lastid;
                
               
            // preparing sql statement
          
            $user_id = rand(1,999999);
            $sql = "INSERT INTO homerunuserdb ( userid, firstname, lastname, passw, email, dob, sex, contact, university ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // header("refresh:$sec; ../signup.php?error=sqlerror");
                echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
                exit();
            }else{
                
                $hashedpass = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "sssssssss", $userid, $firstname, $lastname, $hashedpass, $email, $dob, $gender, $contact, $uni);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                
                    setcookie("firstname", $firstname, time() + (-900 * 1), "/");  
                    setcookie("lastname", $lastname, time() + (-900 * 1), "/");  
                    setcookie("password", $password, time() + (-900 * 1), "/");  
                    setcookie("confirmpass", $confirmpass, time() + (-900 * 1), "/"); 
                    setcookie("email", $email, time() + (-900 * 1), "/");   
                    setcookie("dob", $dob, time() + (-900 * 1), "/");  
                    setcookie("gender", $gender, time() + (-900 * 1), "/");  
                    setcookie("contact", $contact, time() + (-900 * 1), "/");  
                    setcookie("uni", $uni, time() + (-900 * 1), "/");  
                    header("refresh:$sec; ../login.php?youhavesuccessfullyregistered");
                    echo '<script type="text/javascript"> alert("YOU HAVE SUCCESSFULLY REGISTERED!") </script>';
                    exit();

                }
                exit();
            
        }
        else{
            
            header("Refresh:0.1, ../required/code_register.php");
            echo '<script type="text/javascript"> alert("SORRY YOUR CODE DOES NOT MATCH!!") </script>';

    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}


?>