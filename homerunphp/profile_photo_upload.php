<?php
session_start();
$status = ''; 
$sec = 0.1;
    // checks if user has logged in or not.

if(isset($_POST['profile_photos']) and (!empty($_SESSION['sessionowner']))){
    
    /* 
    * Custom function to compress image size and 
    * upload to the server using PHP 
    */ 
    function compressImage($source, $destination, $quality) { 
        // Get image info 
        $imgInfo = getimagesize($source); 
        $mime = $imgInfo['mime']; 
        
        // Create a new image from file 
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($source); 
                break; 
            case 'image/png': 
                $image = imagecreatefrompng($source); 
                break; 
            case 'image/gif': 
                $image = imagecreatefromgif($source); 
                break; 
            default: 
                $image = imagecreatefromjpeg($source); 
        } 
        
        // Save image 
        imagejpeg($image, $destination, $quality); 
        
    // Return compressed image 
    return $destination; 
    }
    // database connection
    require 'advertisesdb.php';
    
    $name = "image";
    $countfiles = 8;
    $count = 0;
    for($i=0;$i<$countfiles;$i++){
        switch($i){
            case 0:
                if(!empty($_FILES['image']['name'][$i])){
                    $image1 = $_FILES['image']['name'][$i];
                    $count ++;
                }else{
                    $image1 = "";
                }
                break;
                case 1:
                      if(!empty($_FILES['image']['name'][$i])){
                        $image2 = $_FILES['image']['name'][$i];
                        $count ++;
                        }else{
                            $image2 = "";
                        }
                    break;
                    case 2:
                          if(!empty($_FILES['image']['name'][$i])){
                            $image3 = $_FILES['image']['name'][$i];
                            $count ++;
                            }else{
                                $image3 = "";
                            }
                        break;
                        case 3:
                              if(!empty($_FILES['image']['name'][$i])){
                                    $image4 = $_FILES['image']['name'][$i];
                                    $count ++;
                                }else{
                                    $image4 = "";
                                }
                            break;
                            case 4:
                                  if(!empty($_FILES['image']['name'][$i])){
                                    $image5 = $_FILES['image']['name'][$i];
                                    $count ++;
                                    }else{
                                        $image5 = "";
                                    }
                                break;
                                case 5:
                                      if(!empty($_FILES['image']['name'][$i])){
                                        $image6 = $_FILES['image']['name'][$i];
                                        $count ++;
                                        }else{
                                            $image6 = "";
                                        }
                                    break;
                                    case 6:
                                          if(!empty($_FILES['image']['name'][$i])){
                                            $image7 = $_FILES['image']['name'][$i];
                                            $count ++;
                                            }else{
                                                $image7 = "";
                                            }
                                        break;
                                        case 7:
                                              if(!empty($_FILES['image']['name'][$i])){
                                            $image8 = $_FILES['image']['name'][$i];
                                            $count ++;
                                            }else{
                                                $image8 = "";
                                            }
                                            break;
        }
    }
    $email = $_SESSION['sessionowner'];
    $sql = "SELECT * FROM  homerunhouses WHERE email = '$email' ";
    
    if (!$rs_result = mysqli_query($conn,$sql)){
        echo mysqli_error($conn);
        
    }else{
        $row = mysqli_fetch_array($rs_result);
        $uni = $row['uni'];

        $sql = "UPDATE homerunhouses SET image1=? ,image2=? ,image3=? ,image4=? ,image5=? ,image6=? ,image7=? ,image8=?  WHERE email=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("refresh:$sec;  ../profile.php?error=sqlerror");
            echo '<script type="text/javascript"> alert("SQL ERROR") </script>';
            exit();
        }else{  
            mysqli_stmt_bind_param($stmt,'sssssssss', $image1,$image2,$image3,$image4,$image5,$image6,$image7,$image8,$email);
            // runs sql
            if(mysqli_stmt_execute($stmt)){
                if($uni === "University of Zimbabwe"){
                    for ($num = 0; $num < $count; $num++){ 
                        $imageUploadPath = '../housepictures/uzpictures/' . basename($_FILES["$name"]["name"][$num]);
                        require '../homerunphp/upload.php';
                        }
                        
                }elseif($uni === "Midlands State University"){
                    for ($num = 0; $num < $count; $num++){ 
                        $imageUploadPath = '../housepictures/msupictures/' . basename($_FILES["$name"]["name"][$num]);
                        require '../homerunphp/upload.php';
                        }
                        
                }elseif($uni === "Africa Univeristy"){
                    for ($num = 0; $num < $count; $num++){ 
                        $imageUploadPath = '../housepictures/aupictures/' . basename($_FILES["$name"]["name"][$num]);
                        require '../homerunphp/upload.php';
                        }
                        
                }elseif($uni === "Bindura State University"){
                    for ($num = 0; $num < $count; $num++){ 
                        $imageUploadPath = '../housepictures/bsupictures/' . basename($_FILES["$name"]["name"][$num]);
                        require '../homerunphp/upload.php';
                        }
                        
                }elseif($uni ==="Chinhoyi University of Science and Technology"){
                    for ($num = 0; $num < $count; $num++){ 
                        $imageUploadPath = '../housepictures/cutpictures/' . basename($_FILES["$name"]["name"][$num]);
                        require '../homerunphp/upload.php';
                        }
                        
                }elseif($uni === "Great Zimbabwe University"){
                    for ($num = 0; $num < $count; $num++){ 
                        $imageUploadPath = '../housepictures/gzpictures/' . basename($_FILES["$name"]["name"][$num]);
                        require '../homerunphp/upload.php';
                        }
                        
                }elseif($uni === "Harare Institute of Technology"){
                    for ($num = 0; $num < $count; $num++){
                        $imageUploadPath = '../housepictures/hitpictures/' . basename($_FILES["$name"]["name"][$num]);
                        require '../homerunphp/upload.phpupload.php';
                        }
                        
                }elseif($uni === "National University of Science and Technology"){
                    for ($num = 0; $num < $count; $num++){ 
                    $imageUploadPath = '../housepictures/nustpictures/' . basename($_FILES["$name"]["name"][$num]);
                    require '../homerunphp/upload.php';
                    }
            
                    }else{
                        header("refresh:$sec;  ../profile.php?error=FailedtoUploadImages");
                        echo '<script type="text/javascript"> alert("Error while uploading") </script>';

                    }
                    if($status == 'success'){
                        header("refresh:$sec;  ../profile.php?status=Profilecreated");
                        $_SESSION['sessionowner'] = $email;
                        echo '<script type="text/javascript"> alert("Images  Uploaded Successfully") </script>';

                        exit();
                    }else{
                        header("refresh:$sec;  ../profile.php?error=FailedtoUploadImages");
                        echo '<script type="text/javascript"> alert("Failed to Upload Images") </script>';    

                    }
            }else{
                header("refresh:$sec;  ../profile.php?error=FailedtoUploadImages");
                echo '<script type="text/javascript"> alert("Images Not Uploaded") </script>';
            
            }
        }
    }
}
?>