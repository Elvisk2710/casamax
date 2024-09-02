const express = require("express");
const bodyParser = require("body-parser");
const http = require("http");
const socketIo = require("socket.io");
const cors = require("cors");
const axios = require("axios");
const { MessagingResponse, validateRequest } = require("twilio");

// Initialize Express
const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Environment Variables
const accountSid = 'ACc7621dcd3d33b6d756b448a7e17820bb';
const authToken = 'aa379643cb23f785c3fdbabe4a2775b1';

if (!accountSid || !authToken) {
  console.error("Twilio credentials are not set.");
  process.exit(1);
}

try {
  const client = require("twilio")(accountSid, authToken);
  console.log("Twilio client initialized successfully");
} catch (error) {
  console.error("Error initializing Twilio client:", error.message);
}

const phpApiUrl = "https://casamax.co.zw/chat/server/";

// Object to store conversation data
const conversationData = {};

// Middleware for Twilio validation
app.use((req, res, next) => {
  const twilioSignature = req.headers["x-twilio-signature"];
  const url = req.protocol + "://" + req.get("host") + req.originalUrl;

  if (validateRequest(authToken, twilioSignature, url, req.body)) {
    next();
  } else {
    res.status(403).send("Forbidden");
  }
});

// Body Parser Middleware
app.use(bodyParser.urlencoded({ extended: false }));

// CORS Configuration
app.use(
  cors({
    origin: "*",
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],
  })
);

// Route for handling Twilio WhatsApp messages
app.post("/whatsapp", (req, res) => {
  const incomingMessage = req.body.Body;
  const fromNumber = req.body.From;

  // Initialize conversation data for the sender if not already done
  if (!conversationData[fromNumber]) {
    conversationData[fromNumber] = {
      stage: "initial",
      data: {},
    };
  }

  const conversation = conversationData[fromNumber];
  let responseMessage = "";

  switch (conversation.stage) {
    case "initial":
      responseMessage =
        "Hello my name is Casa. \nI am here to help you find the best boarding house for your needs\n\nChoose your university....\n\n(1)University of Zimbabwe\n(2)Midlands State University\n(3)Africa University\n(4)Bindura university of Science and Education\n(5)Chinhoyi University of Science and Technology\n(6)Great Zimbabwe University\n(7)Harare Institute of Technology\n(8)National University of Science and Technology";
      conversation.stage = "university";
      break;

    case "budget":
      conversation.data.university = incomingMessage;
      responseMessage = "What is your budget range?";
      conversation.stage = "gender";
      break;

    case "gender":
      conversation.data.budget = incomingMessage;
      responseMessage = "What is your gender?";
      conversation.stage = "completed";
      break;

    case "university":
      conversation.data.gender = incomingMessage;
      responseMessage = `Thank you for providing the details. Here’s a summary:
            \nUniversity: ${conversation.data.university}
            \nBudget: ${conversation.data.budget}
            \nGender: ${conversation.data.gender}
            \nWe are finding the best boarding-houses for you`;
      conversation.stage = "budget";
      break;

    case "completed":
      responseMessage =
        "Your request has been completed. Is there anything else I can help you with?";
      break;

    default:
      responseMessage =
        "I’m not sure how to help with that. Could you please provide more details?";
  }

  // Store the incoming and outgoing messages in the conversation object
  conversationData[fromNumber].data.messages =
    conversationData[fromNumber].data.messages || [];
  conversationData[fromNumber].data.messages.push({
    direction: "incoming",
    message: incomingMessage,
  });
  conversationData[fromNumber].data.messages.push({
    direction: "outgoing",
    message: responseMessage,
  });

  const twiml = new MessagingResponse();
  twiml.message(responseMessage);

  res.writeHead(200, { "Content-Type": "text/xml" });
  res.end(twiml.toString());
});

// Socket.IO Configuration
io.on("connection", (socket) => {
  console.log("New client connected");

  socket.on("ping", () => {
    console.log("Ping received from client");
    socket.emit("pong");
  });

  // Update is read
  socket.on("updateIsRead", async (data) => {
    try {
      await withTimeout(
        axios.post(
          `${phpApiUrl}update_is_read.php?mobile_api=true&responseType=json`,
          data,
          {
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
          }
        )
      );
      startPolling(socket, data.user, data.type);
    } catch (error) {
      console.error("Error sending message:", error);
    }
  });

  // Handle join event
  socket.on("join", async (data) => {
    try {
      let response;
      if (data.type == "student") {
        response = await withTimeout(
          axios.get(
            `${phpApiUrl}show_users.php?student=${data.user}&responseType=json`
          )
        );
      } else if (data.type == "landlord") {
        response = await withTimeout(
          axios.get(
            `${phpApiUrl}show_users.php?landlord=${data.user}&responseType=json`
          )
        );
      }
      socket.emit("newChatList", response.data);
      startPolling(socket, data.user, data.type);
    } catch (error) {
      console.error("Error fetching data from PHP:", error);
    }
  });

  // Handle join room event
  socket.on("joinRoom", async (data) => {
    console.log(`user joined room: ${data.roomId}`);
    socket.join(data.roomId);
    try {
      const response = await withTimeout(
        axios.get(
          `${phpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${data.user}&incoming_id=${data.receiver}`
        )
      );
      io.to(data.roomId).emit("newChatMessage", response.data);
    } catch (error) {
      console.error("Error fetching messages:", error);
    }
    startPollingChat(socket, data.user, data.receiver, data.roomId, data.type);
  });

  // Handle send message event
  socket.on("sendMessage", async (data) => {
    try {
      const formData = new URLSearchParams();
      formData.append("outgoing_id", data.outgoing_id);
      formData.append("incoming_id", data.incoming_id);
      formData.append("message", data.message);

      const response = await withTimeout(
        axios.post(
          `${phpApiUrl}insert_chat.php?responseType=json&mobile_api=true`,
          formData,
          {
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
          }
        )
      );

      if (response.status >= 200 && response.status < 300) {
        const { roomId, message } = data;
        io.to(roomId).emit("message", { sender: socket.id, message });
        console.log("Message sent successfully to the PHP backend and clients");
      } else {
        console.error(
          "API call was not successful:",
          response.status,
          response.statusText
        );
      }
    } catch (error) {
      console.error("Error sending message:", error);
    }
  });

  // Error handling
  socket.on("error", (error) => {
    console.log("Error: ", error);
  });
});

// Function to start polling for new messages
function startPollingChat(socket, userId, receiver, roomId, type) {
  setInterval(async () => {
    try {
      const response = await withTimeout(
        axios.get(
          `${phpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${userId}&incoming_id=${receiver}`
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
            `${phpApiUrl}show_users.php?student=${userId}&responseType=json`
          )
        );
      } else if (type === "landlord") {
        response = await withTimeout(
          axios.get(
            `${phpApiUrl}show_users.php?landlord=${userId}&responseType=json`
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
            lastMsgId:
              newChatList.length > 0
                ? newChatList[newChatList.length - 1].lastMsgId
                : "",
          };
          socket.emit("updateChatList", response.data);
        }
      }
    } catch (error) {
      console.error("Error fetching chat list:", error);
    }
  }, POLLING_INTERVAL);
}

// Timeout wrapper function
function withTimeout(promise, timeout = 5000) {
  let timer;
  const timeoutPromise = new Promise(
    (_, reject) =>
      (timer = setTimeout(
        () => reject(new Error("Request timed out")),
        timeout
      ))
  );
  return Promise.race([promise, timeoutPromise]).finally(() =>
    clearTimeout(timer)
  );
}

// Start the server
const PORT = process.env.PORT || 5000;
server.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
