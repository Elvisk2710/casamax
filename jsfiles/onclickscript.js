//function for creating a cooking
function setCookie(name, value, daysToExpire) {
    const expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + daysToExpire);
  
    const cookieValue = encodeURIComponent(value) +
      (daysToExpire ? "; expires=" + expirationDate.toUTCString() : "");
  
    document.cookie = name + "=" + cookieValue + "; path=/";
  }

//  functions for selecting images

document.getElementById('image1').onclick = function triggerClick() {
    document.getElementById('inputimage1').click();
}
document.getElementById('image2').onclick = function triggerClick2() {
    document.getElementById('inputimage2').click();
}
document.getElementById('image3').onclick = function triggerClick3() {
    document.getElementById('inputimage3').click();
}
function displayImage(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image1').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage2(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image2').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage3(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image3').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage4(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image4').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage5(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image5').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage6(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image6').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage7(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image7').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

function displayImage8(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.querySelector('#image8').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}
// function for opening and closing the nav bar
function togglebtn1() {
    var dropdown = document.getElementById("dropdown");
    navBar.classList.toggle("hideuni")
}
function togglebtn() {
    var navBar = document.getElementById("navBar");

    navBar.classList.toggle("hidemenu")
}
function togglebtn() {
    var navBar = document.getElementById("navBar");
    navBar.classList.toggle("hidemenu")
}
function togglebtn1() {
    var dropdown = document.getElementById("dropdown");
    navBar.classList.toggle("hideuni")
}

// open add listing form for admin portal

function OpenAddListingForm() {
    var addListingForm = document.getElementById("admin_advertise_form")
    addListingForm.style.display = 'flex'
}
function CloseAddListingForm() {
    var addListingForm = document.getElementById("admin_advertise_form")
    addListingForm.style.display = 'none'
}

// open add agents in admin form for admin portal

function OpenAddAddAgent() {
    var addListingForm = document.getElementById("admin_add_agent_form")
    addListingForm.style.display = 'flex'
}
function CloseAddAddAgent() {
    var addListingForm = document.getElementById("admin_add_agent_form")
    addListingForm.style.display = 'none'
}

// multistep form functions
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab
// agent advertise form 
function submitFn() {
    const button1 = document.getElementById("add_home")
    button1.disabled = true;
    button1.innerText = 'Posting......';
    console.log("button disabled")
    return true;
}
// landlord and admin advertise form
function showTab(n) {
    // This function will display the specified tab of the form ...
    const x = document.querySelectorAll(`div[id^="tab"]`);
    x[n].style.display = "block";
    console.log(n,'this is n');
    console.log("currentTab", currentTab)

    // ... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("cancelBtn").style.display = "inline";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
        document.getElementById("cancelBtn").style.display = "none";

    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submit").style.display = "inline";
    } else {
        document.getElementById("submit").style.display = "none";
        document.getElementById("nextBtn").style.display = "inline";
    }
    // ... and run a function that displays the correct step indicator:
}
function nextPrev(n) {
    // This function will figure out which tab to display
    const x = document.querySelectorAll(`div[id^="tab"]`);
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // if you have reached the end of the form... :
    if (currentTab + 1 >= x.length - 1 && n === 2) {
        //...the form gets submitted:
        document.getElementById("submit").click();
        var addListingForm = document.getElementById("admin_advertise_form")
        // addListingForm.style.display = 'none'
    } else {
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}
function validateForm() {

    // This function deals with validation of the form fields
    var x, y, i, n, valid = true;
    x = document.querySelectorAll(`div[id^="tab"]`);
    y = x[currentTab].getElementsByTagName("input");
    // validating drop downs
    const uni_dropdown = document.getElementById("uni_dropdown");
    const uni_dropdownOptionSelIndex = uni_dropdown.options[uni_dropdown.selectedIndex].value.trim();
    // getting value from dropdown gender_dropdown
    const gender_dropdown = document.getElementById("gender_dropdown");
    const gender_dropdownOptionSelIndex = gender_dropdown.options[gender_dropdown.selectedIndex].value.trim();
    // validating dropdowns

    console.log(x)

    if (x[currentTab] !== x[1]) {
        for (j = 0; j < y.length; j++) {
            if (y[j].value === "") {
                // add an "invalid" class to the field:
                y[j].classList.add("invalid");
                y[j].focus;
                // and set the current valid status to false:
                valid = false;
            }
        }
    }
    if (x[currentTab] === x[1]) {

        console.log(gender_dropdownOptionSelIndex)

        console.log(uni_dropdownOptionSelIndex)
        // getting value from dropdown description
        if (uni_dropdownOptionSelIndex === "" || uni_dropdownOptionSelIndex === null) {
            // add an "invalid" class to the field:
            uni_dropdown.classList.add("invalid");
            uni_dropdown.focus
            // and set the current valid status to false:
            valid = false;
        } else if (gender_dropdownOptionSelIndex === "" || gender_dropdownOptionSelIndex === null) {
            // add an "invalid" class to the field:
            gender_dropdown.classList.add("invalid");
            gender_dropdown.focus
            // and set the current valid status to false:
            valid = false;
        } else if (document.getElementById("price").value === "") {
            // add an "invalid" class to the field:
            document.getElementById("price").classList.add("invalid");
            document.getElementById("price").focus
            // and set the current valid status to false:
            valid = false;
        } else if (document.getElementById("address").value === "") {
            // add an "invalid" class to the field:
            document.getElementById("address").classList.add("invalid");
            document.getElementById("address").focus
            // and set the current valid status to false:
            valid = false;
        } else if (document.getElementById("people").value === "") {
            // add an "invalid" class to the field:
            document.getElementById("people").classList.add("invalid");
            document.getElementById("people").focus
            // and set the current valid status to false:
            valid = false;
        }
    }
    if (x[currentTab] === x[2]) {
        if (document.getElementById("inputimage1").value === "") {
            e.preventDefault();
            // adding classname invalid
            document.getElementById("inputimage1").classList.add("invalid")
            // and set the current valid status to false:
            valid = false;
        }
    }
    if (x[currentTab] === x[3]) {
        if (document.getElementById("inputimage2").value === "") {
            e.preventDefault();
            // adding classname invalid
            document.getElementById("inputimage2").classList.add("invalid")
            // and set the current valid status to false:
            valid = false;
        } else if (document.getElementById("inputimage3").value === "") {
            e.preventDefault();
            // adding classname invalid
            document.getElementById("inputimage3").classList.add("invalid")
            // and set the current valid status to false:
            valid = false;
        }
    }
    return valid; // return the valid status
}
// opening house documents in admin
function openDocs(homeAdminSession) {
    setCookie("homeAdminSession",homeAdminSession,1)
    document.getElementById("view_documents_pop_up").style.display = "flex";
    console.log(homeAdminSession)
}
function closeDocs() {
    document.getElementById("view_documents_pop_up").style.display = "none"
}
// verificatioin pop up in admin 
function openVerify() {
    document.getElementById("verify_pop_up").style.display = "flex";
}
function closeVerify() {
    document.getElementById("verify_pop_up").style.display = "none";
}