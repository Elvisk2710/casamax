<?php 
  
    $status = $statusMsg = 'failed'; 
 
    if(!empty($_FILES["$name"]["name"][$num])) { 
        echo 3;
        // File info 
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION); 
        strtolower($fileType);
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','heic'); 
        if(in_array($fileType, $allowTypes)){ 
            // Image temp source 
            $imageTemp = $_FILES["$name"]["tmp_name"][$num]; 
            // Compress size and upload image 
             
            if(compressImage($imageTemp, $imageUploadPath, 50)){ 
                $status = 'success'; 
                $statusMsg = 'images uploaded successfully';
                // $statusMsg = "Image compressed successfully."; 
            }else{
                $status = 'error'; 
                $statusMsg = "Image compress failed!"; 
            }
        }else{ 
            $status = 'file_type_error'; 
            $statusMsg = 'Some images were not uploaded due to unsupported images. Only JPG, JPEG, PNG files are currently supported'; 

        } 
} else{
    echo 'empty images';
}
 
?>