<?php
$redirect = '';
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    custonAlert($error);
}
if (isset($_GET['redirect'])) {
    $redirect = $_GET['redirect'];
}
function redirectAlert($message, $location)
{
    header("location: $location");
    echo ' <div class="alert_container">
            <div class="alert">
                <div class="alert_msg">
                    <h2>
                        ' . $message . '
                    </h2>
                </div>
            </div>
        </div>';
}
function custonAlert($message)
{
    echo ' <div class="alert_container">
            <div class="alert">
                <div class="alert_msg">
                    <h2>
                        ' . $message . '
                    </h2>
                </div>
            </div>
        </div>';
}
function redirect($redirect)
{
    header("location: $redirect");
}
?>
<style>
    .alert_container {
        width: 100vw;
        height: 100vh;
        display: flex;
        position: absolute;
        background-color: rgba(255, 255, 255, 0.2);
        justify-content: center;

    }

    @keyframes openAnimation {
        0% {
            opacity: 0%;
        }

        50% {
            opacity: 50%;
        }

        100% {
            opacity: 100%
        }
    }

    @keyframes closeAnimation {
        0% {
            opacity: 100%;
        }

        50% {
            opacity: 60%;
        }

        100% {
            opacity: 0%;
        }
    }

    .close {
        display: none;
        animation: closeAnimation;
        animation-duration: 500ms;
        animation-name: closeAnimation;
        animation-timing-function: ease-in;
        animation-iteration-count: 1;
    }

    .alert {
        width: 400px;
        height: fit-content;
        background-color: rgba(252, 153, 82);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        animation: openAnimation;
        animation-duration: 300ms;
        animation-name: openAnimation;
        animation-timing-function: ease-in;
    }

    .alert_btn_div button {
        width: fit-content;
        height: fit-content;
        border: none;
        border-radius: 8px;
        text-align: center;
        padding: 5px 30px;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
        transition: 0.3s all;
        color: rgb(8, 8, 12);
        text-align: center;
        background-color: rgb(252, 153, 82);
        cursor: pointer;
        transition: 300ms all;
    }

    .alert_msg h2 {
        font-size: 18px;
        font-weight: 600;
        margin: 20px 0;
        color: white;

    }
</style>

<script>
    count = 0;
    limit = 4;
    setInterval(() => {
        if (count > limit) {
            document.querySelector("body").classList.remove("scrollable");
            document.querySelector(".alert_container").classList.add("close");
        } else {
            count++
        }
    }, 500)
    document.querySelector("body").classList.add("scrollable");

    function removeAlert() {
        console.log("clicked")
        document.querySelector("body").classList.remove("scrollable");
        document.querySelector(".alert_container").classList.add("close");
    }
</script>