<?php 
  
    $status = $statusMsg = 'failed'; 
 
    if(!empty($_FILES["$name"]["name"][$num])) { 
        echo 3;
        // File info 
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION); 
        strtolower($fileType);
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg'); 
        if(in_array($fileType, $allowTypes)){ 
            // Image temp source 
            $imageTemp = $_FILES["$name"]["tmp_name"][$num]; 
            echo 1;
            // Compress size and upload image 
             
            if(compressImage($imageTemp, $imageUploadPath, 50)){ 
                echo 2;
                $status = 'success'; 
                // $statusMsg = "Image compressed successfully."; 

            }else{ 
                $statusMsg = "Image compress failed!"; 
            }
        }else{ 
            $statusMsg = 'error'; 

        } 
} 
 
?>