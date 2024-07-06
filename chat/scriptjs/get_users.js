userList = document.querySelector(".container .chat_list_container .chat_list");
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "https://localhost/casamax/chat/server/show_users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        console.log(userList);
        userList.innerHTML = data;
      }
    }
  };
  xhr.send();
},500);
