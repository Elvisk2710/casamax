const express = require("express");
const http = require("http");
const socketIo = require("socket.io");
const axios = require("axios");
const cors = require("cors");
const rateLimit = require("express-rate-limit");
const { createLogger, transports, format } = require("winston");
require("dotenv").config(); // To load environment variables from .env file

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Logger setup using Winston
const logger = createLogger({
  level: "info",
  format: format.combine(
    format.timestamp(),
    format.json()
  ),
  transports: [
    new transports.Console(),
    new transports.File({ filename: "combined.log" })
  ]
});

// Configurations
const CHAT_POLLING_INTERVAL = 3500; // 3.5 seconds
const POLLING_INTERVAL = 3500; // 3.5 seconds

// Retrieve environment variables
const phpApiUrl = process.env.PHP_API_URL || "https://casamax.co.zw/chat/server/";

// Configure CORS
app.use(
  cors({
    origin: "*", // Consider restricting origins in production
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],
  })
);

// Rate limiting
const limiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutes
  max: 100, // Limit each IP to 100 requests per windowMs
  message: "Too many requests from this IP, please try again later."
});

app.use(limiter);

// Body parser middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Define a simple route to test connectivity
app.get("/", (req, res) => {
  res.send("Socket.IO server is running");
});

// Error handling middleware
app.use((err, req, res, next) => {
  logger.error("Unhandled error: ", err);
  res.status(500).send("Internal Server Error");
});

// Handle connection
io.on("connection", (socket) => {
  logger.info("New client connected");

  socket.on("ping", () => {
    logger.info("Ping received from client");
    socket.emit("pong");
  });

  // Update is read
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
      logger.error("Error sending message:", error);
    }
  });

  // Handle join event
  socket.on("join", async (data) => {
    try {
      const endpoint = data.type === "student"
        ? `${phpApiUrl}show_users.php?student=${data.user}&responseType=json`
        : `${phpApiUrl}show_users.php?landlord=${data.user}&responseType=json`;

      const response = await axios.get(endpoint);
      socket.emit("newChatList", response.data);
      startPolling(socket, data.user, data.type);
    } catch (error) {
      logger.error("Error fetching data from PHP:", error);
    }
  });

  // Handle join room event
  socket.on("joinRoom", async (data) => {
    logger.info(`User joined room: ${data.roomId}`);
    socket.join(data.roomId);
    try {
      const response = await axios.get(
        `${phpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${data.user}&incoming_id=${data.receiver}`
      );
      io.to(data.roomId).emit("newChatMessage", response.data);
      startPollingChat(socket, data.user, data.receiver, data.roomId, data.type);
    } catch (error) {
      logger.error("Error fetching messages:", error);
    }
  });

  // Handle disconnection
  socket.on("disconnect", () => {
    logger.info("Client disconnected");
  });

  // Handle send message
  socket.on("sendMessage", async (data) => {
    try {
      const formData = new URLSearchParams();
      formData.append('outgoing_id', data.outgoing_id);
      formData.append('incoming_id', data.incoming_id);
      formData.append('message', data.message);

      const response = await axios.post(`${phpApiUrl}insert_chat.php?responseType=json&mobile_api=true`, formData, {
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
      });

      if (response.status >= 200 && response.status < 300) {
        const { roomId, message } = data;
        io.to(roomId).emit("message", { sender: socket.id, message });
        logger.info("Message sent successfully to the PHP backend and clients");
      } else {
        logger.error("API call was not successful:", response.status, response.statusText);
      }
    } catch (error) {
      logger.error("Error sending message:", error);
    }
  });

  // Error handling for socket errors
  socket.on("error", (error) => {
    logger.error("Socket error: ", error);
  });
});

// Function to start polling for new messages
function startPollingChat(socket, userId, receiver, roomId, type) {
  setInterval(async () => {
    try {
      const response = await axios.get(
        `${phpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${userId}&incoming_id=${receiver}`
      );
      const messages = Array.isArray(response.data.chats) ? response.data.chats : [];
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
      logger.error("Error fetching messages:", error);
    }
  }, CHAT_POLLING_INTERVAL);
}

// Function to start polling for new chats
function startPolling(socket, userId, type) {
  const userType = type;
  setInterval(async () => {
    try {
      const endpoint = userType === "student"
        ? `${phpApiUrl}show_users.php?student=${userId}&responseType=json`
        : `${phpApiUrl}show_users.php?landlord=${userId}&responseType=json`;

      const response = await axios.get(endpoint);

      if (response && response.data) {
        const newChatList = response.data.chats || [];
        if (!Array.isArray(newChatList)) {
          logger.error("Expected 'chats' to be an array but got:", newChatList);
          return;
        }

        const previousChatList = chatLists[userId]?.list || [];

        if (!Array.isArray(previousChatList)) {
          logger.error("Previous chat list is not an array:", previousChatList);
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
      logger.error("Error fetching chat list:", error);
    }
  }, POLLING_INTERVAL);
}

server.listen(process.env.PORT || 5000, () => {
  logger.info("Server listening on port 5000");
});
