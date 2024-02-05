<?php
// pagination
 $num_per_page = 10;

if(isset($_GET["page"])){
    $page = $_GET["page"];
}else{
    $page = 1;
}
$start_from = ($page-1) * 10;


// query
$sql = "SELECT * FROM  homerunhouses WHERE uni = '$university' LIMIT $start_from,$num_per_page ";
$rs_result = mysqli_query($conn,$sql);

?>