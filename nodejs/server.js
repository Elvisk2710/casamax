const express = require("express");
const http = require("http");
const socketIo = require("socket.io");
const axios = require("axios");
const cors = require("cors"); // Import the cors package
const { log } = require("console");

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

const chatLists = {}; // An empty object to store chat lists for each user
// chat details polling
const CHAT_POLLING_INTERVAL = 3500; // 1 seconds
let lastMessageId = null;
// chat list polling
const POLLING_INTERVAL = 3500; // 1 seconds

// Replace with your PHP API URL
const phpApiUrl = "https://casamax.co.zw/chat/server/";
// const phpApiUrl = "http://192.168.1.14:81/casamax/chat/server/";

// Configure CORS
app.use(
  cors({
    origin: "*", // Allow all origins; you can specify specific origins if needed
    methods: ["GET", "POST"], // Allow specific methods
    allowedHeaders: ["Content-Type"], // Allow specific headers
  })
);

// Define a simple route to test connectivity
app.get("/", (req, res) => {
  res.send("Socket.IO server is running");
});

// Handle connection
io.on("connection", (socket) => {
  console.log("New client connected");

  socket.on("ping", () => {
    console.log("Ping received from client");
    socket.emit("pong");
  });
  // update is read
  socket.on("updateIsRead", async (data) => {
    try {
      await axios.post(
        `${phpApiUrl}update_is_read.php?mobile_api=true&responseType=json`,
        data,
        {
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
        }
      );
      startPolling(socket, data.user, data.type);
    } catch (error) {
      console.error("Error sending message:", error);
    }
  });
  // Handle join event
  socket.on("join", async (data) => {
    try {
      // checking is the user is a student
      if (data.type == "student") {
        const response = await axios.get(
          `${phpApiUrl}show_users.php?student=${data.user}&responseType=json`
        );
        socket.emit("newChatList", response.data);
        startPolling(socket, data.user, data.type);
      } else if (data.type == "landlord") {
        // checking is the user is a landlord
        const response = await axios.get(
          `${phpApiUrl}show_users.php?landlord=${data.user}&responseType=json`
        );
        socket.emit("newChatList", response.data);
        startPolling(socket, data.user, data.type);
      }
    } catch (error) {
      console.error("Error fetching data from PHP:", error);
    }
  });

  // Handle join event
  socket.on("joinRoom", async (data) => {
    console.log(`user joined room: ${data.roomId}`);
    socket.join(data.roomId);
    try {
      const response = await axios.get(
        `${phpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${data.user}&incoming_id=${data.receiver}`
      );
      io.to(data.roomId).emit("newChatMessage", response.data);
    } catch (error) {
      console.error("Error fetching messages:", error);
    }
    startPollingChat(socket, data.user, data.receiver, data.roomId, data.type);
  });

  // Handle disconnection
  socket.on("disconnect", () => {
    console.log("Client disconnected");
  });

  socket.on("sendMessage", async (data) => {
    try {
      const formData = new URLSearchParams();
      formData.append('outgoing_id', data.outgoing_id);
      formData.append('incoming_id', data.incoming_id);
      formData.append('message', data.message);
  
      const response = await axios.post(`${phpApiUrl}insert_chat.php?responseType=json&mobile_api=true`, formData, {
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
      });
  
      // Check if the API call was successful (status code 200-299)
      if (response.status >= 200 && response.status < 300) {
        // Emit message to all clients after successfully sending to PHP backend
        const { roomId, message } = data;
        io.to(roomId).emit("message", { sender: socket.id, message });
        console.log("Message sent successfully to the PHP backend and clients");
      } else {
        console.error("API call was not successful:", response.status, response.statusText);
      }
    } catch (error) {
      console.error("Error sending message:", error);
    }
  });
  
  // error handling
  socket.on("error", (error) => {
    console.log("Error: ", error);
  });
});
// Function to start polling for new messages
function startPollingChat(socket, userId, receiver, roomId, type) {
  setInterval(async () => {
    try {
      const response = await axios.get(
        `${phpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${userId}&incoming_id=${receiver}`
      );
      // handle empty messages
      const messages = Array.isArray(response.data.chats)
        ? response.data.chats
        : [];
      if (messages.length > 0) {
        const latestMessage = messages[messages.length - 1];
        const latestMessageId = latestMessage.id;
        // if the last message is the same as the latest message
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
        response = await axios.get(
          `${phpApiUrl}show_users.php?student=${userId}&responseType=json`
        );
      } else if (type === "landlord") {
        response = await axios.get(
          `${phpApiUrl}show_users.php?landlord=${userId}&responseType=json`
        );
      }

      if (response && response.data) {
        const newChatList = response.data.chats || [];
        if (!Array.isArray(newChatList)) {
          console.error("Expected 'chats' to be an array but got:", newChatList);
          return;
        }

        // Initialize or retrieve previous chat list
        const previousChatList = (chatLists[userId] && Array.isArray(chatLists[userId].list))
          ? chatLists[userId].list
          : [];

        // Ensure previousChatList is an array
        if (!Array.isArray(previousChatList)) {
          console.error("Previous chat list is not an array:", previousChatList);
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

        const hasUpdates = newMsgs.some((newMsg, index) => {
          const previousMsg = previousMsgs[index] || {};
          return (
            newMsg.lastMsgId !== previousMsg.lastMsgId ||
            newMsg.isRead !== previousMsg.isRead
          );
        });

        if (hasUpdates) {
          chatLists[userId] = {
            list: newChatList,
            lastMsgId: newChatList.length > 0 ? newChatList[newChatList.length - 1].lastMsgId : "",
          };
          socket.emit("updateChatList", response.data);
        }
      }
    } catch (error) {
      console.error("Error fetching chat list:", error);
    }
  }, POLLING_INTERVAL);
}



server.listen(5000, () => {
  console.log("Server listening on port 5000");
});
