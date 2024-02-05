<style>
    .gallery_container {
        height: 100vh;
        position: absolute;
        top: 0;
        width: 100vw;
        display: hidden;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        scroll-behavior: smooth;
        background-size: cover;
        transition: opacity 1s, visibility 1s;
        background: rgba(8, 8, 12, 0.6);

    }

    .slider-inner-container {
        height: 80vh;
        width: 80vw;
        display: flex;
        flex-direction: column;
    }

    .full_container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        justify-items: center;
        align-items: center;
        height: 100%;
        width: 100%;
    }

    .slide {
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 1;
        display: none;
    }

    .slide.active {
        display: flex;
    }

    .image-container {
        width: 100%;
        height: 30%;
        margin: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        box-shadow: 0px 0px 2200px 500px rgba(8, 8, 12, 0.8);
        background: transparent;
        background-color: red;

    }

    .image-container {
        right: 0px;
        background: transparent;
        border-radius: 10px;
        height: 100%;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        margin: auto;
        border-radius: 10px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        /* box-shadow: 0px 0px 2200px 500px rgba(8, 8, 12, 0.8); */
    }

    /* controls */
    .controls {
        top: 50%;
        display: flex;
        flex-direction: column;
        text-align: center;
        align-items: center;
        justify-content: center;
        width: 100vw;
    }

    .controls .prev,
    .controls .next {
        position: absolute;
        top: 50%;
        z-index: 20;
        margin: auto;
        text-align: center;
        cursor: pointer;
        color: rgb(252, 153, 82);
        width: 10px;
        height: 10px;
    }

    .controls .prev:hover,
    .controls .next:hover {
        opacity: 0.8;
    }

    .controls .prev {
        right: 90%;
    }

    .controls .next {
        left: 90%;
    }

    .close {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        width: 100%;
        margin-top: 10px;
        position: relative;

    }

    .close button {
        width: 20vw;
        margin: 0vh 0vw;
        border: none;
        border-radius: 10px;
        text-align: center;
        padding: 1vh 2vw;
        font-weight: 600;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: 0.3s all;
        color: white;
        text-align: center;
        background-color: rgb(252, 153, 82);
    }

    @media only screen and (max-width: 700px) {
        .controls .prev {
            right: 90%;
        }

        .controls .next {
            left: 90%;
        }

        .slider-inner-container {
            height: 100%;
            width: 100vw;
            display: flex;
            flex-direction: column;
        }


        .full_container {
            height: 30%;
            display: block;
            width: 100%;
        }

        .slide {
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 1;
            display: none;
        }

    }
</style>
<?php
if ($row['uni'] == "University of Zimbabwe") {
    $location = "housepictures/uzpictures/";
} elseif ($row['uni'] == "Midlands State University") {
    $location = "housepictures/msupictures/";
} elseif ($row['uni'] == "Africa Univeristy") {
    $location = "housepictures/aupictures/";
} elseif ($row['uni'] == "Bindura State University") {
    $location = "housepictures/bsupictures/";
} elseif ($row['uni'] == "Chinhoyi University of Science and Technology") {
    $location = "housepictures/cutpictures/";
} elseif ($row['uni'] == "Great Zimbabwe University") {
    $location = "housepictures/gzpictures/";
} elseif ($row['uni'] == "Harare Institute of Technology") {
    $location = "housepictures/hitpictures/";
} elseif ($row['uni'] == "National University of Science and Technology") {
    $location = "housepictures/hitpictures/";
} else {
    header("Location:../index.php?error=sqlerror");
}

?>
<div class="gallery_container" id="gallery_container">
    <div class="full_container">
        <div class="controls">
            <div class="next"><i class="fa fa-chevron-circle-right" style="font-size: 34px;"></i></div>
            <div class="prev"><i class="fa fa-chevron-circle-left" style="font-size: 34px;"></i></div>
        </div>
        <div class="slider-inner-container">
            <?php

            for ($x = 1; $x < 9; $x++) {
                $check = $x;

                if (!empty($row['image' . $check])) {
                    if ($check == 1) {
                        echo '
                    <div class="slide active">
             
                    <div class="image-container">
                        <img src="' . $location . $row['image' . $check] . '">
                    </div>
                    </div>';
                    } else {
                        echo '
                    <div class="slide ">
              
                    <div class="image-container">
                        <img src="' . $location . $row['image' . $check] . '">
                        </div>
                    </div>
                    ';
                    }
                } else {
                    echo '
                <div class="slide ">
          
                <div class="image-container">
                    <img src="./images/no_image.png">
                    </div>
                </div>
                ';
                }
            }

            ?>
           
        </div>
        <div class="close">
                <button onclick="close_gallery()">
                    close
                </button>
            </div>
    </div>
</div>

<script src="./jsfiles/script.js">
</script>