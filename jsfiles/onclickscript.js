//function for creating a cooking
function setCookie(name, value, daysToExpire) {
  const expirationDate = new Date();
  expirationDate.setDate(expirationDate.getDate() + daysToExpire);

  const cookieValue =
    encodeURIComponent(value) +
    (daysToExpire ? "; expires=" + expirationDate.toUTCString() : "");

  document.cookie = name + "=" + cookieValue + "; path=/";
}

//  functions for selecting images

document.getElementById("image1").onclick = function triggerClick() {
  document.getElementById("inputimage1").click();
};
document.getElementById("image2").onclick = function triggerClick2() {
  document.getElementById("inputimage2").click();
};
document.getElementById("image3").onclick = function triggerClick3() {
  document.getElementById("inputimage3").click();
};
function displayImage(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image1").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

function displayImage2(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image2").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

function displayImage3(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image3").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

function displayImage4(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image4").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

function displayImage5(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image5").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

function displayImage6(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image6").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

function displayImage7(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image7").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

function displayImage8(e) {
  if (e.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      document.querySelector("#image8").setAttribute("src", e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}
// function for opening and closing the nav bar
function togglebtn1() {
  var dropdown = document.getElementById("dropdown");
  navBar.classList.toggle("hideuni");
}
function togglebtn() {
  var navBar = document.getElementById("navBar");

  navBar.classList.toggle("hidemenu");
}
function togglebtn() {
  var navBar = document.getElementById("navBar");
  navBar.classList.toggle("hidemenu");
}
function togglebtn1() {
  var dropdown = document.getElementById("dropdown");
  navBar.classList.toggle("hideuni");
}

// open add listing form for admin portal

function OpenAddListingForm() {
  var addListingForm = document.getElementById("admin_advertise_form");
  addListingForm.style.display = "flex";
}
function CloseAddListingForm() {
  var addListingForm = document.getElementById("admin_advertise_form");
  addListingForm.style.display = "none";
}

// open add agents in admin form for admin portal

function OpenAddAddAgent() {
  var addListingForm = document.getElementById("admin_add_agent_form");
  addListingForm.style.display = "flex";
}
function CloseAddAddAgent() {
  var addListingForm = document.getElementById("admin_add_agent_form");
  addListingForm.style.display = "none";
}

// multistep form functions
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab
// agent advertise form
function submitFn() {
  const button1 = document.getElementById("add_home");
  button1.disabled = true;
  button1.innerText = "Posting......";
  console.log("button disabled");
  return true;
}
// landlord and admin advertise form
function showTab(n) {
  // This function will display the specified tab of the form ...
  const x = document.querySelectorAll(`div[id^="tab"]`);
  x[n].style.display = "block";
  console.log(n, "this is n");
  console.log("currentTab", currentTab);

  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
    document.getElementById("cancelBtn").style.display = "inline";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
    document.getElementById("cancelBtn").style.display = "none";
  }
  if (n == x.length - 1) {
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
    var addListingForm = document.getElementById("admin_advertise_form");
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
  var x,
    y,
    i,
    n,
    valid = true;
  x = document.querySelectorAll(`div[id^="tab"]`);
  y = x[currentTab].getElementsByTagName("input");
  // validating drop downs
  const uni_dropdown = document.getElementById("uni_dropdown");
  const uni_dropdownOptionSelIndex =
    uni_dropdown.options[uni_dropdown.selectedIndex].value.trim();
  // getting value from dropdown gender_dropdown
  const gender_dropdown = document.getElementById("gender_dropdown");
  const gender_dropdownOptionSelIndex =
    gender_dropdown.options[gender_dropdown.selectedIndex].value.trim();
  // validating dropdowns

  console.log(x);

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
    console.log(gender_dropdownOptionSelIndex);

    console.log(uni_dropdownOptionSelIndex);
    // getting value from dropdown description
    if (
      uni_dropdownOptionSelIndex === "" ||
      uni_dropdownOptionSelIndex === null
    ) {
      // add an "invalid" class to the field:
      uni_dropdown.classList.add("invalid");
      uni_dropdown.focus;
      // and set the current valid status to false:
      valid = false;
    } else if (
      gender_dropdownOptionSelIndex === "" ||
      gender_dropdownOptionSelIndex === null
    ) {
      // add an "invalid" class to the field:
      gender_dropdown.classList.add("invalid");
      gender_dropdown.focus;
      // and set the current valid status to false:
      valid = false;
    } else if (document.getElementById("price").value === "") {
      // add an "invalid" class to the field:
      document.getElementById("price").classList.add("invalid");
      document.getElementById("price").focus;
      // and set the current valid status to false:
      valid = false;
    } else if (document.getElementById("address").value === "") {
      // add an "invalid" class to the field:
      document.getElementById("address").classList.add("invalid");
      document.getElementById("address").focus;
      // and set the current valid status to false:
      valid = false;
    } else if (document.getElementById("people").value === "") {
      // add an "invalid" class to the field:
      document.getElementById("people").classList.add("invalid");
      document.getElementById("people").focus;
      // and set the current valid status to false:
      valid = false;
    }
  }
  if (x[currentTab] === x[2]) {
    if (document.getElementById("inputimage1").value === "") {
      e.preventDefault();
      // adding classname invalid
      document.getElementById("inputimage1").classList.add("invalid");
      // and set the current valid status to false:
      valid = false;
    }
  }
  if (x[currentTab] === x[3]) {
    if (document.getElementById("inputimage2").value === "") {
      e.preventDefault();
      // adding classname invalid
      document.getElementById("inputimage2").classList.add("invalid");
      // and set the current valid status to false:
      valid = false;
    } else if (document.getElementById("inputimage3").value === "") {
      e.preventDefault();
      // adding classname invalid
      document.getElementById("inputimage3").classList.add("invalid");
      // and set the current valid status to false:
      valid = false;
    }
  }
  return valid; // return the valid status
}
// opening house documents in admin
function openDocs(homeAdminSession) {
  setCookie("homeAdminSession", homeAdminSession, 1);
  document.getElementById("view_documents_pop_up").style.display = "flex";
  console.log(homeAdminSession);
}
function closeDocs() {
  document.getElementById("view_documents_pop_up").style.display = "none";
}
// verificatioin pop up in admin
function openVerify() {
  document.getElementById("verify_pop_up").style.display = "flex";
}
function closeVerify() {
  document.getElementById("verify_pop_up").style.display = "none";
}
function generatePDF() {
  // Make a GET request to the server
  fetch("../../required/createPdf.php")
    .then((response) => {
      // Check if the response is successful
      if (!response.ok) {
        throw new Error(`HTTP error ${response.status}`);
      }
      // Parse the response as JSON
      return response.json();
    })
    .then((data) => {
      console.log(data);
      // Process the JSON data
      createPDFWindow(data);
    })
    .catch((error) => {
      console.error("Error generating PDF:", error);
      // Display an error message or handle the error in another way
      alert("Failed to generate PDF: " + error.message);
    });
}
function parseHTMLData(htmlData) {
  // Parse the HTML data and extract the necessary information
  // This will depend on the structure of the HTML response
  const parser = new DOMParser();
  const doc = parser.parseFromString(htmlData, "text/html");
  const tableRows = doc.querySelectorAll("table tbody tr");

  const data = [];
  tableRows.forEach((row) => {
    const cells = row.querySelectorAll("td");
    data.push({
      name: cells[0].textContent,
      email: cells[1].textContent,
      age: cells[2].textContent,
    });
  });

  return data;
}

function createPDFWindow(data) {
  // Create a new window/tab and open the PDF page
  const pdfWindow = window.open("", "PDF", "width=800,height=600");
  const verifiedCount = data.filter((item) => item.verified).length;
  console.log(`count for verification is ${verifiedCount}`); // Write the HTML content to the new window, including the dynamic data
  pdfWindow.document.write(`
    <!DOCTYPE html>
<html>
  <head>
    <title>Admin Report</title>
    <style>
      /* Add any styles you want for the PDF page */
      * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  -webkit-tap-highlight-color: transparent;
}
      body {
        font-family: Arial, sans-serif;
      }
      h1 {
        text-align: center;
      }
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th,
      td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
      .logo {
        width: 6vw;
        height: 6vw;
        margin-top: 10px;
      }
      header {
        text-align: left;
        padding: 5px 14px;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        align-items: center;
        border-bottom: 2px solid rgb(252, 153, 82);
      }
      .title h1{
        padding: 14px;
        font-size: 32px;
        font-weight: 700;
        color: rgb(252, 153, 82);
      }
      .title_contiainer{
        display: flex;
        justify-items: center;
        justify-content: center;

      }
      .left_col_top_left{
        text-align: left;
        width: 40%;

      }
      .left_col_top_left_details{
        font-size: 11px;
        padding: 5px;
      }
      .left_col_top_right{
        font-size: 12px;
        font-weight: 600;
        margin-top: 20px;
      }
      h1{
        font-size: 18px;
      }
      table{
        padding: 20px;
      }
      .table_body{
        padding: 2vw;
      }
      footer{
        background-color: rgb(8, 8, 12);
        color: white;
        padding: 10px;
        position: fixed;
        bottom: 0;
        width: 100vw;
        display: flex;
        flex-direction: row;
      }
      .left_footer{
        flex-basis: 40%;
        padding: 10px;
      }
      .righ_footer{
        flex-basis: 60%;
        padding: 10px;
      }
      p{
        padding: 10px;
        font-size: 12px;
      }
      .left_col_top_left_details{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
        justify-items: center;
        padding-left: 10px;
      }
    </style>
  </head>
  <header>
    <div class="title_contiainer"">
      <img src="https://casamax.co.zw/images/logoblack.png" alt="logo" class="logo" />
      <div class="title">
        <h1>
            Casamax.co.zw
        </h1>
    </div>
</div>
 ${data
   .map(
     (item) => `
    <div class="left_col_top_left">
        <div class="left_col_top_left_details">
            <h2>
                Casamax Agent Id:
            </h2>
            <h2>
                ${item.admin_id}
            </h2>
        </div>
        <div class="left_col_top_left_details">
            <h2>
                Total Listings: 
            </h2>
            <h2>
               ${data.length}
            </h2>
        </div>
        <div class="left_col_top_left_details">
            <h2>
                Verified Listings:
            </h2>
            <h2>
               ${verifiedCount}
            </h2>
        </div>
        <div class="left_col_top_right">
            <div class="amount_earned">
                <h2>
                    Amount Earned: 
                </h2>
            </div>
    </div>
  </div>
  </header>
  <body>
    <h1>Data Report</h1>
    <div class="table_body">
    <table>
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Age</th>
          <th>Contact</th>
          <th>Verified</th>
        </tr>
      </thead>
      <tbody>
       
        <tr>
          <td>${item.firstname}</td>
          <td>${item.lastname}</td>
          <td>${item.email}</td>
          <td>${item.age}</td>
          <td>${item.contact}</td>
          <td>${item.verified == 1 ? "Yes" : "No"}</td>
        </tr>
        `
   )
   .join("")}
      </tbody>
    </table>
</div>
  </body>
  <footer>
    <div class="left_footer">
        <h5>
            Phone: +263 78 698 9144
        </h5>
        <h5>
            Email: info@casamax.co.zw
        </h5>
    </div>
    <div class="right_footer">
        <p>
            Looking for off-campus accommodation?
            Welcome to CasaMax, where we provide all the available
            Homes and Rental properties at the tip of your fingers        </p>
        <p>
            visit:https://casamax.co.zw/aboutus.php for more info. <br>
            T&Cs Apply
        </p>

    </div>
  </footer>
</html>
  `);

  // Print the PDF page
  pdfWindow.document.close();
  pdfWindow.focus();
  pdfWindow.print();

  // Close the PDF window
  pdfWindow.close();
}
