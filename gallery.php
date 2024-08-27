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
        background: rgba(8, 8, 12, 0.8);
    }

    .slider-inner-container {
        height: 80vh;
        width: 100vw;
        display: flex;
        flex-direction: column;
        align-items: center;
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
        justify-content: center;
    }

    .image-container {
        width: 100%;
        height: 80vh;
        margin: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        background: transparent;
        overflow: hidden;
    }

    .image-container img {
        max-height: 80vh;
        max-width: 100vw;
        object-fit: contain;
        margin: auto;
        border-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    .controls {
        position: absolute;
        z-index: 2000;
        top: 50%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        width: 100vw;
    }

    .controls .prev,
    .controls .next {
        color: rgb(252, 153, 82);
        margin: 0 10vw;
    }

    /* 

    .controls .prev:hover,
    .controls .next:hover {
        opacity: 0.8;
    }
/* 
    .controls .prev {
        right: 90%;
    }

    .controls .next {
        left: 90%;
    } */

    .close {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        width: 100%;
        margin-top: 10px;
        position: absolute;
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
        color: rgba(8, 8, 12, 0.8);
        text-align: center;
        background-color: rgb(252, 153, 82);
    }

    .gallery-icons {
        position: absolute;
        bottom: 20vh;
        display: flex;
        gap: 10px;
    }

    .icon-btn {
        background-color: rgb(252, 153, 82);
        border: none;
        color: white;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s;
        z-index: 10000;
    }

    .icon-btn:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .icon-btn i {
        font-size: 18px;
    }

    @media only screen and (max-width: 700px) {
        .gallery_container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .slider-inner-container {
            height: 100%;
            width: 100vw;
            display: flex;
            flex-direction: column;
        }

        .full_container {
            height: 100vh;
            display: block;
            width: 100%;
            object-fit: contain;
        }

        .slide {
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 1;
            display: none;
        }

        .image-container img {
            max-height: auto;
            max-width: 100vw;
        }

        .controls .prev,
        .controls .next {
            color: rgb(252, 153, 82);
            margin: 10px;
        }
        .gallery-icons {
        position: absolute;
        bottom: 20vh;
        display: flex;
        gap: 10px;
    }
    .close{
        position: absolute;
        bottom: 20px;
    }
    .close button{
        width: 50vw;
        color: rgba(8, 8, 12, 0.8);
        font-weight: 800;
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
            <div class="prev"><i class="fa fa-chevron-circle-left" style="font-size: 34px;"></i></div>
            <div class="next"><i class="fa fa-chevron-circle-right" style="font-size: 34px;"></i></div>
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
                        <img src="' . $location . $row['image' . $check] . '" id="image-' . $check . '">
                    </div>
                    </div>';
                    } else {
                        echo '
                    <div class="slide ">
                    <div class="image-container">
                        <img src="' . $location . $row['image' . $check] . '" id="image-' . $check . '">
                        </div>
                    </div>';
                    }
                }
            }
            ?>
             <div class="gallery-icons">
            <button onclick="toggleFullscreen()" class="icon-btn"><i class="fa fa-expand"></i></button>
            <button onclick="downloadImage()" class="icon-btn"><i class="fa fa-download"></i></button>
            <button onclick="zoomIn()" class="icon-btn"><i class="fa fa-search-plus"></i></button>
            <button onclick="zoomOut()" class="icon-btn"><i class="fa fa-search-minus"></i></button>
            <button onclick="rotateImage()" class="icon-btn"><i class="fa fa-undo"></i></button>
        </div>
        <div class="close">
            <button onclick="close_gallery()">close</button>
        </div>
        </div>
       
    </div>
</div>


<script src="./jsfiles/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let currentZoom = 1;
        let currentRotation = 0;
        let touchStartDistance = 0;

        function toggleFullscreen() {
            const gallery = document.getElementById('gallery_container');
            if (!document.fullscreenElement) {
                gallery.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        function downloadImage() {
            const activeSlide = document.querySelector('.slide.active img');
            const imageUrl = activeSlide.src;
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = 'image.jpg'; // Change file name if needed
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function zoomIn() {
            const activeSlide = document.querySelector('.slide.active img');
            currentZoom += 0.1;
            activeSlide.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
        }

        function zoomOut() {
            const activeSlide = document.querySelector('.slide.active img');
            currentZoom = Math.max(1, currentZoom - 0.1);
            activeSlide.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
        }

        function rotateImage() {
            const activeSlide = document.querySelector('.slide.active img');
            currentRotation = (currentRotation + 90) % 360;
            activeSlide.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
        }

        function handleTouchStart(e) {
            if (e.touches.length === 2) {
                touchStartDistance = getTouchDistance(e.touches);
            }
        }

        function handleTouchMove(e) {
            if (e.touches.length === 2) {
                const currentDistance = getTouchDistance(e.touches);
                const scaleChange = currentDistance / touchStartDistance;
                touchStartDistance = currentDistance;

                currentZoom *= scaleChange;
                const activeSlide = document.querySelector('.slide.active img');
                activeSlide.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
            }
        }

        function getTouchDistance(touches) {
            const dx = touches[0].clientX - touches[1].clientX;
            const dy = touches[0].clientY - touches[1].clientY;
            return Math.sqrt(dx * dx + dy * dy);
        }

        const galleryContainer = document.getElementById('gallery_container');
        galleryContainer.addEventListener('touchstart', handleTouchStart, {
            passive: true
        });
        galleryContainer.addEventListener('touchmove', handleTouchMove, {
            passive: true
        });

        window.toggleFullscreen = toggleFullscreen;
        window.downloadImage = downloadImage;
        window.zoomIn = zoomIn;
        window.zoomOut = zoomOut;
        window.rotateImage = rotateImage;
    });
</script>