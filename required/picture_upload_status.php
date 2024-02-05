    <div class="container_loader ">
        <div class="ring"></div>
        <div class="ring"></div>
        <span class="loading"> Creating Proflie <br> Please Wait....</span>
    </div>
    <style>

        .container_loader{
            width: 100%;
            height: 100vh;
            position:fixed;
            display: flex;
            background-size: cover;
            justify-content: center;
            align-items: center;
            background-color: rgb(255, 255, 255);
            transition: opacity 1s, visibility 1s;
            z-index: 99999;
            overflow: hidden;
        }
        .container_loader--hidden{
            opacity: 0;
            visibility: hidden;
            display: none;
        }
        .ring{
            width: 200px;
            height: 200px;
            border: 0px solid rgb(8, 8, 12);
            border-radius: 50%;
            position: absolute;
        }

        .ring:nth-child(1){
            border-bottom-width: 8px;
            border-color: rgb(252, 153, 82);
            animation: rotate1 2s linear infinite;
        }
        .ring:nth-child(2){
            border-right-width: 8px;
            border-color: rgb(8, 8, 12);
            animation: rotate2 2s linear infinite;
        }
        .loading{
            color: rgb(8, 8, 12);
            font-size: 18px;
            font-family: 'Hind', sans-serif;
            animation: pulse 4s ease infinite;
        }
       
        @keyframes pulse {
            100%{
                opacity: 0%;
                color: rgb(8, 8, 12);
            }
           
            75%{
                color: rgb(8, 8, 12);
                opacity: 100%;
            }
           
            50%{
                color: rgb(8, 8, 12);
                opacity: 0%;
            }
           
            25%{
                color: rgb(252, 153, 82);
                opacity: 100%;
            }
            
            0%{
                color: rgb(252, 153, 82);
                opacity: 0%;
            }
           
        }
        @keyframes rotate1 {
            0%{
                transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
            
            }
            100%{
                transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
              
            }
        }
        @keyframes rotate2 {
            0%{
                transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
            }
            100%{
                transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);

            }
        }
    </style>
    <script>
        window.addEventListener("load", () =>{
            document.querySelector(".container_loader").classList.add("container_loader--hidden");
            document.querySelector("body").classList.remove("scrollable");
        });
    </script> 
