userList = document.querySelector(".container .chat_list_container .chat_list");
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "https://localhost/casamax/chat/server/show_users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        userList.innerHTML = data;
      }
    }
  };
  xhr.send();
},1000);


// update the  is_read attribute
function updateRead(element) {
  const msgId = element.getAttribute('data-msg-id');
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

  xhr.send(JSON.stringify({ "msg_id": msgId }));

}