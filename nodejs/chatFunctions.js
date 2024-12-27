require("dotenv").config();
const chatPhpApiUrl = process.env.CHAT_PHP_API_URL;

// Function to start polling for new messages
function startPollingChat(socket, userId, receiver, roomId, type) {
  setInterval(async () => {
    try {
      const response = await withTimeout(
        axios.get(
          `${chatPhpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${userId}&incoming_id=${receiver}`
        )
      );
      const messages = Array.isArray(response.data.chats)
        ? response.data.chats
        : [];
      if (messages.length > 0) {
        const latestMessage = messages[messages.length - 1];
        const latestMessageId = latestMessage.id;
        if (latestMessageId > lastMessageId) {
          lastMessageId = latestMessageId;
          io.to(roomId).emit("message", response.data);
          startPolling(socket, userId, type);
        }
      }
    } catch (error) {
      console.error("Error fetching messages:", error);
    }
  }, CHAT_POLLING_INTERVAL);
}

// Function to start polling for new chats
function startPolling(socket, userId, type) {
  setInterval(async () => {
    try {
      let response;
      if (type === "student") {
        response = await withTimeout(
          axios.get(
            `${chatPhpApiUrl}show_users.php?student=${userId}&responseType=json`
          )
        );
      } else if (type === "landlord") {
        response = await withTimeout(
          axios.get(
            `${chatPhpApiUrl}show_users.php?landlord=${userId}&responseType=json`
          )
        );
      }

      if (response && response.data) {
        const newChatList = response.data.chats || [];
        if (!Array.isArray(newChatList)) {
          console.error(
            "Expected 'chats' to be an array but got:",
            newChatList
          );
          return;
        }

        const previousChatList =
          chatLists[userId] && Array.isArray(chatLists[userId].list)
            ? chatLists[userId].list
            : [];

        if (!Array.isArray(previousChatList)) {
          console.error(
            "Previous chat list is not an array:",
            previousChatList
          );
          chatLists[userId] = { list: newChatList };
          return;
        }

        const previousMsgs = previousChatList.map((chat) => ({
          lastMsgId: chat.lastMsgId || "",
          isRead: typeof chat.isRead !== "undefined" ? chat.isRead : false,
        }));
        const newMsgs = newChatList.map((chat) => ({
          lastMsgId: chat.lastMsgId || "",
          isRead: typeof chat.isRead !== "undefined" ? chat.isRead : false,
        }));

        const changesDetected =
          previousMsgs.length !== newMsgs.length ||
          previousMsgs.some(
            (prevMsg, index) =>
              prevMsg.lastMsgId !== newMsgs[index].lastMsgId ||
              prevMsg.isRead !== newMsgs[index].isRead
          );

        if (changesDetected) {
          chatLists[userId] = { list: newChatList };
          socket.emit("newChatList", response.data);
          console.log("Emitted new chat list to the client");
        }
      }
    } catch (error) {
      console.error("Error fetching data from PHP:", error);
    }
  }, CHAT_POLLING_INTERVAL);
}

module.exports = {
  startPolling,
  startPollingChat,
};
