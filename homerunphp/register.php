<?php
$sec = "0.1";
 //add database connection
 require 'homerunuserdb.php';

if(isset($_POST['submit'])){

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $confirmpass = $_POST['confirmpassword'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $uni = $_POST['university'];

    $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    $firstname = filter_var($firstname,FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($lastname,FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_var($gender,FILTER_SANITIZE_SPECIAL_CHARS);
    $contact = filter_var($contact,FILTER_SANITIZE_NUMBER_INT);


    if (empty($firstname) or empty($lastname) or empty($password) or empty($confirmpass) or empty($email) or empty($dob) or empty($gender) or empty($contact) or $uni=="none"){

        header("refresh:$sec;  ../signup.php?error=emptyfields&firstname=".$firstname);
        exit();
    }elseif($password !== $confirmpass ) {

        header("refresh:$sec; ../signup.php?error=passwordsdonotmatch".$firstname);
        exit();
    }else{
        $sql = "SELECT email FROM homerunuserdb WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        // preparing sql statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("refresh:$sec;  ../signup.php?error=sqlerror");
            exit();

        }else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);
            
            if($rowCount>0) {
                header("refresh:$sec; ../signup.php?error=emailalreadyinuse");
                echo '<script type="text/javascript"> alert("OOPS! EMAIL ALREADY EXISTS") </script>';
                exit();
            }else{

                $hashedpass = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO homerunuserdb ( firstname, lastname, passw, email, dob, sex, contact, university ) VALUES ('$firstname', '$lastname', '$hashedpass', '$email', '$dob', '$gender', '$contact', '$uni');";
                
                $result = mysqli_query($conn,$sql);
                 
                    if(!$result){
                        echo '<script type="text/javascript"> alert("SORRY!! Failed to Register") </script>';
                    }else{
    
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
                    
                    $query_code = "UPDATE homerunuserdb SET userid = '" .$userid. "' WHERE id = '" .$lastid."'";
                    $res = mysqli_query($conn,$query_code);
    
                    if($res){
                        header("refresh:$sec; ../login.php?youhavesuccessfullyregistered");
                        echo '<script type="text/javascript"> alert("YOU HAVE SUCCESSFULLY REGISTERED!") </script>';
    
                    }else{
                        $query_code = "DELETE FROM homerunuserdb WHERE email ='$email";
                        $res = mysqli_query($conn,$query_code); 
                        header("refresh:$sec; ./index.php?FailedToGenerateID");
                        echo '<script type="text/javascript"> alert("Sorry Failed to generate agent ID!") </script>';
    
                    }
                    exit();
                }   
            }
        }
    }
}
?>