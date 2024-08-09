const form = document.querySelector(".text_area");
inputField = form.querySelector(".input_field");
sendBtn = form.querySelector("button");
chatBox = document.querySelector(".chat_container");
const outgoing_id = document.querySelector(".outgoing_id").value;
const incoming_id = document.querySelector(".incoming_id").value;


form.onsubmit = (e) => {
  e.preventDefault();
};
sendBtn.onclick = () => {
  if (inputField.value != "" && inputField.value != null) {
    let xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "https://localhost/casamax/chat/server/insert_chat.php",
      true
    );
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          inputField.value = ""; //resets the value of the input
          scrollToBottom();
          let data = xhr.response;
          console.log(data);
        }
      }
    };
    let formData = new FormData(form);
    xhr.send(formData);
  }
};

// deteching touch for mobile to stop scrolling
// Add event listeners for touch events
chatBox.addEventListener("touchstart", handleTouchStart);
chatBox.addEventListener("touchmove", handleTouchStart);
chatBox.addEventListener("touchend", handleTouchStart);
chatBox.addEventListener("touchcancel", handleTouchStart);

function handleTouchStart(event) {
  // Get the touch information
  chatBox.classList.add("active");
}

// senses mouse events
chatBox.addEventListener("mouseenter", () => {
  chatBox.classList.add("active");
});
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `https://localhost/casamax/chat/server/get_chat_msg.php?outgoing_id=${outgoing_id}&incoming_id=${incoming_id}`,
    true
  );
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        // serts data into the chat
        chatBox.innerHTML = data;
        if (!chatBox.classList.contains("active")) {
          //if it is not active it will automatically scroll
          scrollToBottom();
        }
      }
    }
  };

  let formData = new FormData(form);
  xhr.send(formData);
}, 1200);

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}
// update the  is_read attribute
function updateRead(element) {
  const msgId = element.getAttribute("data-msg-id");
  console.log(msgId);
  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "https://localhost/casamax/chat/server/update_is_read.php",
    true
  );
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        // serts data into the chat
        console.log(data);
      }
    }
  };

  xhr.send(JSON.stringify({ msg_id: msgId }));
}
