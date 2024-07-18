<?php
require '../required/alerts.php';
if (isset($_POST['pricesearch']) and isset($_POST['university'])) {

    $unisearch = $_POST['university'];
    $pricesearch = $_POST['pricesearch'];

    $pricesearch = filter_var($pricesearch, FILTER_SANITIZE_NUMBER_INT);

    // this is for folder alocations.
    if ($unisearch == "University of Zimbabwe") {
        $unilocation = "uzlisting.php";
    } elseif ($unisearch == "Midlands State University") {
        $unilocation = "msulisting.php";
    } elseif ($unisearch == "Africa Univeristy") {
        $unilocation = "aulisting.php";
    } elseif ($unisearch == "Bindura State University") {
        $unilocation = "bsulisting.php";
    } elseif ($unisearch == "Chinhoyi University of Science and Technology") {
        $unilocation = "cutlisting.php";
    } elseif ($unisearch == "Harare Institute of Technology") {
        $unilocation = "hitlisting.php";
    } elseif ($unisearch == "National University of Science and Technology") {
        $unilocation = "nustlisting.php";
    } elseif ($unisearch == "Great Zimbabwe University") {
        $unilocation = "gzlisting.php";
    } else {
        header("refresh:0.1;  ../index.php?error=Please Select University On Search");
        echo '<script type="text/javascript"> alert("Please Enter a Univeristy on Search") </script>';
        exit();
    }

    redirect("../unilistings/" . $unilocation . "?price=" . $pricesearch);
}
