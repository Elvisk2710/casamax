<style>
    .gallery_container {
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        scroll-behavior: smooth;
        background-size: cover;
        transition: opacity 1s, visibility 1s;
        background: rgba(8, 8, 12, 0.8);
    }

    .slider-inner-container {
        height: 100%;
        width: 100%;
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
        height: 90%;
        margin: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        background: transparent;
        overflow: hidden;
    }

    .image-container img {
        max-height: 100%;
        max-width: 100%;
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
        background-color: white;
        border: none;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10000;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .controls .prev img,
    .controls .next img {
        width: 1.5rem;
        height: 1.5rem;
    }

    .controls .prev:hover,
    .controls .next:hover {
        transform: scale(1.05);
        transition: all 0.3s ease-in-out;
        background-color: rgb(252, 153, 82);
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
        position: absolute;
        bottom: 2vh;
    }

    .close button {
        width: fit-content;
        margin: 0vh 0vw;
        border: none;
        border-radius: 20px;
        text-align: center;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        color: rgba(8, 8, 12);
        background-color: rgb(252, 153, 82);
        font-size: 1rem;
    }

    .gallery-icons {
        position: absolute;
        bottom: 10vh;
        display: flex;
        gap: 10px;
    }

    .icon-btn {
        background-color: white;
        border: none;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10000;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .icon-btn img {
        height: 1.5rem;
        width: 1.5rem;
    }

    .icon-btn:hover {
        background-color: rgb(252, 153, 82);
        transition: all 0.3s ease-in-out;
    }

    @media only screen and (max-width: 700px) {
        .gallery_container {
            display: none;
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
            width: 1.5rem;
            height: 1.5rem;
        }

        .gallery-icons {
            position: absolute;
            bottom: 20vh;
            display: flex;
            justify-content: space-around;
            gap: 10px;
            width: 100%;
        }

        .close {
            position: absolute;
            bottom: 10vh;
        }

        .close button {
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
            <div class="prev"><img src="./images/previous.png" alt="Prev" title="Previous"></div>
            <div class="next"><img src="./images/next.png" alt="Next" title="Next"></div>
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
        </div>
        <div class="gallery-icons">
            <button onclick="toggleFullscreen()" class="icon-btn"><img src="./images/fullScreen.png" alt="full-screen" title="Full-screen"></button>
            <button onclick="downloadImage()" class="icon-btn"><img src="./images/download.png" alt="download" title="Download"></button>
            <button onclick="zoomIn()" class="icon-btn"><img src="./images/zoomIn.png" alt="zoom in" title="Zoom In"></button>
            <button onclick="zoomOut()" class="icon-btn"><img src="./images/zoomOut.png" alt="zoom out" title="Zoom Out"></i></button>
            <button onclick="rotateImage()" class="icon-btn"><img src="./images/rotate.png" alt="rotate" title="Rotate"></button>
        </div>
        <div class="close">
            <button onclick="close_gallery()">Close</button>
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