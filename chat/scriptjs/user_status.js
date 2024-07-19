// Define the last activity time
let lastActivityTime = Date.now();

// Select the status container element
const myStatusContainer = document.querySelector(".status");

// Function to update user status
function updateUserStatus(status) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "https://localhost/casamax/chat/server/post_user_status.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        // Handle the response data here if needed
        console.log("Status updated:", data);
      }
    }
  };
  let requestBody = JSON.stringify({ status: status });
  xhr.send(requestBody);
}

// Add event listeners to detect user activity
document.addEventListener("mousemove", () => {
  lastActivityTime = Date.now();
});
document.addEventListener("keydown", () => {
  lastActivityTime = Date.now();
});
document.addEventListener("scroll", () => {
  lastActivityTime = Date.now();
});

// Function to check activity and update status
function checkActivityAndUpdateStatus() {
  const now = Date.now();
  if (now - lastActivityTime >= 10000) {
    // If the user is inactive for 10 seconds, update status to 'offline'
    updateUserStatus("offline");
  } else {
    // If the user is active, update status to 'active'
    updateUserStatus("active");
  }
}

// Set interval to check activity and update status every 10 seconds
setInterval(checkActivityAndUpdateStatus, 10000);

// Initial call to set the user status to 'active' when the page loads
updateUserStatus("active");
