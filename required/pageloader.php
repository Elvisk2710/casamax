<?php
require_once 'alerts.php';
?>
<script>
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Function to get a cookie
    function getCookie(name) {
        const cname = name + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(cname) === 0) {
                return c.substring(cname.length, c.length);
            }
        }
        return "";
    }

    function startTour() {

        const tourSeen = getCookie(tourCookie);
        if (!tourSeen) {
            setCookie(tourCookie, "true", 365);
            const intro = introJs();
            introJs().start();
            introjs - disableInteraction;
        }
    }

    window.addEventListener("load", () => {
        document.querySelector(".container_loader").classList.add("container_loader--hidden");
        document.querySelector("body").classList.remove("scrollable");
        startTour();
    });
</script>
<!-- Include Intro.js JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
<div class="container_loader ">
    <div class="ring"></div>
    <div class="ring"></div>
    <span class="loading">
        <?php
        if (!isset($pageloader)) {
            echo " loading...";
        } else {
            echo $pageloader;
        }
        ?>
    </span>
</div>
<?php
if ((!isset($_GET['chat_id']) && (!isset($_SESSION['sessionAdmin'])) && (!isset($_SESSION['sessionagent']))) || ((isset($_SESSION['sessionowner']))) || (isset($_SESSION['sessionstudent']))) {
?>
    <div class="floating_chat_icon" title="chats">
        <a href="https://casamax.co.zw/chat/screens/">
            <img src="https://casamax.co.zw/images/new-message.png" alt="">
        </a>
    </div>
<?php
}
?>
<style>
    .container_loader {
        width: 100%;
        height: 100vh;
        position: fixed;
        display: flex;
        background-size: cover;
        justify-content: center;
        align-items: center;
        background-color: rgb(255, 255, 255);
        transition: opacity 1s, visibility 1s;
        z-index: 99999;
        overflow: hidden;
    }

    .container_loader--hidden {
        opacity: 0;
        visibility: hidden;
        display: none;
    }

    .ring {
        width: 200px;
        height: 200px;
        border: 0px solid rgb(8, 8, 12);
        border-radius: 50%;
        position: absolute;
    }

    .ring:nth-child(1) {
        border-bottom-width: 8px;
        border-color: rgb(252, 153, 82);
        animation: rotate1 2.5s linear infinite;
    }

    .ring:nth-child(2) {
        border-right-width: 8px;
        border-color: rgb(8, 8, 12);
        animation: rotate2 2s linear infinite;
    }

    .loading {
        color: rgb(8, 8, 12);
        font-size: 18px;
        font-family: 'Hind', sans-serif;
        animation: pulse 4s ease infinite;
    }

    @keyframes pulse {
        100% {
            opacity: 0%;
            color: rgb(8, 8, 12);
        }

        75% {
            color: rgb(8, 8, 12);
            opacity: 100%;
        }

        50% {
            color: rgb(8, 8, 12);
            opacity: 0%;
        }

        25% {
            color: rgb(252, 153, 82);
            opacity: 100%;
        }

        0% {
            color: rgb(252, 153, 82);
            opacity: 0%;
        }

    }

    @keyframes rotate1 {
        0% {
            transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);

        }

        100% {
            transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);

        }
    }

    @keyframes rotate2 {
        0% {
            transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
        }

        100% {
            transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);

        }
    }

    /* floating chat icon */
    .floating_chat_icon {
        background-color: rgb(8, 8, 12);
        width: 60px;
        height: 60px;
        position: fixed;
        bottom: 10vh;
        right: 5vw;
        z-index: 1000;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .floating_chat_icon:active {
        transform: scale(0.95);
        box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.24);
        /* Lowering the shadow */
        transition: 0.3s all;
    }

    .floating_chat_icon a:active {
        transform: scale(0.95);
        box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.24);
        /* Lowering the shadow */
        transition: 0.3s all;
    }

    .floating_chat_icon a img:active {
        transform: scale(0.95);
        box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.24);
        /* Lowering the shadow */
        transition: 0.3s all;
    }

    .floating_chat_icon a {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .floating_chat_icon a img {
        width: 30px;
        height: 30px;
        margin: 0 !important;
    }
</style>
<script src="https://localhost/casamax/chat/scriptjs/user_status.js"></script>