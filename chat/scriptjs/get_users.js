// Select elements
const userList = document.querySelector(".container .chat_list_container .chat_list");
const searchInput = document.querySelector("#searchInput");

// Function to fetch chat data
function fetchChatData(query = '') {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "https://localhost/casamax/chat/server/show_users.php?responseType=html&search=" + encodeURIComponent(query), true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        userList.innerHTML = data;
      }
    }
  };
  xhr.send();
}

// Fetch chat data every second
setInterval(() => {
  const query = searchInput.value.trim();
  fetchChatData(query);
}, 1000);

// Fetch chat data initially
fetchChatData();

// Update the is_read attribute
function updateRead(element) {
  const msgId = element.getAttribute('data-msg-id');
  console.log(msgId);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "https://localhost/casamax/chat/server/update_is_read.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        // Process the response if needed
        console.log(data);
      }
    }
  };
  xhr.send(JSON.stringify({ "msg_id": msgId }));
}

// Add event listener for the search input
searchInput.addEventListener('input', () => {
  const query = searchInput.value.trim();
  fetchChatData(query);
});
