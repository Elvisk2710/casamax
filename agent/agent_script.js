    function close_edit_agent_info(){
        document.getElementById("agent_change_info").style.display ="none"
    }
    function deletefn(){
        document.getElementById("delete_form").style.display ="block"

    }
     var navBar = document.getElementById("navBar")
    
    function togglebtn(){

        navBar.classList.toggle("hidemenu")
    }

    var dropdown = document.getElementById("dropdown")

    function togglebtn1(){

        navBar.classList.toggle("hideuni")
    
    }
    function AddHouse(){
        document.getElementById("add_info_container").style.display = "block"
    }
    function close_add(){
        document.getElementById("add_info_container").style.display = "none"

    }
    function openHouse() {
        document.getElementById("home_info_popup").style.display = "block";
        
    }
    
    function closeHouse() {
        document.getElementById("home_info_popup").style.display = "none";
       
    }
    function open_agent_change_info(){
        document.getElementById("agent_change_info").style.display = "block";

    }
    function open_edit(){
        document.getElementById("home_info_popup").style.display = "none";
        document.getElementById("edit_info_container").style.display = "block";
    }
    var navBar = document.getElementById("navBar");

    function togglebtn(){

        navBar.classList.toggle("hidemenu")
    }

    var dropdown = document.getElementById("dropdown");

    function togglebtn1(){

        navBar.classList.toggle("hideuni")
    
    }
    function close_edit(){
        document.getElementById("home_info_popup").style.display = "block";
        document.getElementById("edit_info_container").style.display = "none";
    }
