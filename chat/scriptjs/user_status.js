myStatusContainer = document.querySelector(".status");

setInterval(() => {
  const now = Date.now();
  if (now - lastActivityTime >= 10000) {
    lastActivityTime = now;
    // Send AJAX request to update user's status
    let xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "https://localhost/casamax/chat/server/post_user_status.php",
      true
    );
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          // Handle the response data here
        }
      }
    };
    let requestBody = JSON.stringify({ status: "offline" });
    xhr.send(requestBody);
  } else {
    // Send AJAX request to get user's status
    let xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "https://localhost/casamax/chat/server/post_user_status.php",
      true
    );
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          // Handle the response data here
        }
      }
    };
    let requestBody = JSON.stringify({ status: "active" });
    xhr.send(requestBody);
  }
}, 10000);

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
 