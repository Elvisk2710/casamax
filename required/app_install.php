    <div class="app_install_container" id="app_install_container_div" style="display: none;">
        <div class="app_install">
            <div >
                <img style="margin-bottom: 10px;" src="./images/logoblack.png" class="logo" alt="">
            </div>
            <div class="text">
                <p>
                    Install <br> Casamax.co.zw
                </p>
            </div>
            <div class="button_app_install">
                    <button  id="install">
                        INSTALL
                    </button>
                    <br>
                    <button onclick="close_ad()">
                        CANCEL
                    </button>
                    <script>
                            // fn to close app install
                        function close_ad(){
                            document.getElementById("app_install_container_div").style.display = "none";
                        }
                    </script>
            </div>
        </div>
    </div>
    <script>
        function isInstalled() {
            if(window.navigator.standalone){         // For iOS
                return true;
            }else if(window.matchMedia('(display-mode: standalone)').matches){         // If neither is true, it's not installed
                return true;
            } else{
                return false         // For Android
            }
        }
        if( isInstalled() === false){
            let defferedPrompt;
            const addbtn = document.querySelector('#install');
            const appdiv = document.querySelector('#app_install_container_div');

            window.addEventListener('beforeinstallprompt', event => {
                event.preventDefault();
                defferedPrompt = event
                appdiv.style.display = 'flex';
            });

            addbtn.addEventListener('click', event => {
                defferedPrompt.prompt();

                defferedPrompt.userChoice.then(choice => {
                    if(choice.outcome === 'accepted'){
                        console.log('user accepted the prompt')
                        appdiv.style.display = 'none';

                    }
                    defferedPrompt = null;
                })
            })
        }

        </script>

