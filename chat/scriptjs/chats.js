const form = document.querySelector(".text_area");
inputField = form.querySelector(".input_field");
sendBtn = form.querySelector("button");
chatBox = document.querySelector(".chat_container");

form.onsubmit = (e) => {
  e.preventDefault();
};
sendBtn.onclick = () => {
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
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
};

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "https://localhost/casamax/chat/server/get_chat_msg.php",
    true
  );
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
      }
    }
  };

  let formData = new FormData(form);
  xhr.send(formData);
}, 500);
