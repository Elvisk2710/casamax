const express = require("express");
const bodyParser = require("body-parser");
const http = require("http");
const socketIo = require("socket.io");
const cors = require("cors");
const axios = require("axios");
const {
  intents,
  greetingKeywords,
  maleKeywords,
  femaleKeywords,
  goodbyeKeywords,
} = require("./intents"); // Import the intents file
const {
  makeBDApiCall,
  generateWhatsAppLink,
  callWhatsAppDbApi,
  generateMessages,
  generateFullCasamaxLink,
  sendTemplateMessage,
  updateConversationStatus,
  sendTextMessage,
  sendHouses,
} = require("./wAFunctions"); // Import the node functions file
const { startPolling, startPollingChat } = require("./chatFunctions");
// Initialize Express
const app = express();
const server = http.createServer(app);
const io = socketIo(server);
require("dotenv").config();

// Object to store conversation data
const conversationData = {};

const chatPhpApiUrl = process.env.CHAT_PHP_API_URL;

// Body Parser Middleware
app.use(bodyParser.json()); // To parse JSON payloads
app.use(bodyParser.urlencoded({ extended: false })); // For form data

// CORS Configuration
app.use(
  cors({
    origin: "*",
    methods: ["GET", "POST"],
    allowedHeaders: ["Content-Type"],
  })
);

// Route for handling Twilio WhatsApp messages
const token = process.env.WHATSAPP_TOKEN;
const myToken = process.env.WHATSAPP_TOKEN;

// app.get("/webhook", async (req, res) => {
//   const mode = req.query["hub.mode"];
//   const challenge = req.query["hub.challenge"];
//   const token = req.query["hub.verify_token"];

//   // Log the incoming request details for debugging
//   console.log("Received webhook verification request:");
//   console.log(`Mode: ${mode}`);
//   console.log(`Challenge: ${challenge}`);
//   console.log(`Token: ${token}`);

//   if (mode && token) {
//     // Check if the mode is "subscribe" and the token matches
//     if (mode == "subscribe" && token == myToken) {
//       res.status(200).send(challenge); // Respond with the challenge code
//       console.log("Webhook verified successfully.");
//     } else {
//       res.status(403).send("Forbidden"); // Forbidden if the token doesn't match
//       console.log("Failed webhook verification.");
//     }
//   } else {
//     res.status(400).send("Bad Request"); // Respond with 400 if required parameters are missing
//     console.log("Missing required parameters.");
//   }
// });

// app.post("/webhook", (req, res) => {
//   let body_param = req.body;
//   // console.log("request", body_param);

//   console.log(JSON.stringify(body_param, null, 2));
//   if (body_param.object) {
//     if (
//       body_param.entry &&
//       Array.isArray(body_param.entry) &&
//       body_param.entry[0].changes &&
//       Array.isArray(body_param.entry[0].changes) &&
//       body_param.entry[0].changes[0].value.messages &&
//       Array.isArray(body_param.entry[0].changes[0].value.messages) &&
//       body_param.entry[0].changes[0].value.messages[0]
//     ) {
//       let phone_no_id =
//         body_param.entry[0].changes[0].value.metadata.phone_number_id;
//       let from = body_param.entry[0].changes[0].value.messages[0].from;
//       let msg_body = body_param.entry[0].changes[0].value.messages[0].text.body;

//       console.log("Sending message to:", from);
//       console.log("Message Body:", msg_body);
//       console.log("Phone Number ID:", phone_no_id);

//       axios({
//         method: "POST",
//         url: `https://graph.facebook.com/v21.0/${phone_no_id}/messages`,
//         headers: {
//           Authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`,
//           "Content-Type": "application/json",
//         },
//         data: {
//           messaging_product: "whatsapp",
//           to: from,
//           type: "text",
//           text: {
//             body: "Hello, this is Elvis",
//           },
//         },
//       })
//         .then((response) => {
//           console.log("Message sent successfully:", response.data);
//         })
//         .catch((error) => {
//           console.error(
//             "Error sending message:",
//             error.response?.data || error.message
//           );
//         });
//       res.sendStatus(200);
//     } else {
//       res.sendStatus(404);
//     }
//   }
// });

// app.get("/",(req,res)=>{
//   res.status(200).send("lol vghvhgvgh");
// })
// Socket.IO Configuration
const processedMessages = new Set();

app.post("/webhook", async (req, res) => {
  try {
    const body = req.body;
    
    // Validate incoming webhook data
    if (!body || !body.object || !body.entry || !body.entry[0]?.changes[0]?.value?.messages) {
      return res.status(400).send("Invalid webhook data.");
    }

    const entry = body.entry[0];
    const message = entry.changes[0].value.messages[0];

    if (!message) {
      return res.status(404).send("Message data not found.");
    }

    const messageId = message.id;
    const fromNumber = message.from;
    const incomingMessage = message.text?.body?.trim().toLowerCase();

    // Prevent duplicate message processing
    if (processedMessages.has(messageId)) {
      console.log(`Message ${messageId} already processed.`);
      return res.status(200).send("Already processed");
    }
    processedMessages.add(messageId);

    // Initialize conversation data if not present
    if (!conversationData[fromNumber]) {
      conversationData[fromNumber] = {
        stage: "initial",
        data: {},
      };
    }

    const conversation = conversationData[fromNumber];
    
    // Handle greetings or goodbye messages
    if (greetingKeywords.some((keyword) => incomingMessage.includes(keyword))) {
      conversation.stage = "initial";
    }

    if (goodbyeKeywords.some((keyword) => incomingMessage.includes(keyword))) {
      conversation.stage = "goodbye";
    }

    let responseMessage;

    const currentDateTime = new Date().toISOString().slice(0, 19).replace("T", " "); // 'YYYY-MM-DD HH:mm:ss'

    // Switch based on conversation stage
    switch (conversation.stage) {
      case "initial":
        conversation.stage = "university";
        await sendTemplateMessage("choose_uni", fromNumber);
        await callWhatsAppDbApi(fromNumber, "initiated", currentDateTime);
        break;

      case "university":
        await updateConversationStatus(fromNumber, "university");
        let matchedUniversity = findMatchedUniversity(incomingMessage);

        if (matchedUniversity) {
          conversation.data.university = matchedUniversity.name;
          conversation.stage = "budget";
          await sendTemplateMessage("budget", fromNumber);
        } else {
          await sendTemplateMessage("error", fromNumber);
        }
        break;

      case "budget":
        await updateConversationStatus(fromNumber, "budget");
        const budget = parseFloat(incomingMessage);
        if (isValidBudget(budget)) {
          conversation.data.budget = budget;
          conversation.stage = "gender";
          await sendTemplateMessage("gender", fromNumber);
        } else {
          await sendTextMessage("Please enter a valid budget (e.g., 180).", fromNumber);
        }
        break;

      case "gender":
        await updateConversationStatus(fromNumber, "gender");
        const gender = await handleGenderStage(incomingMessage, conversation, fromNumber);
        if (gender) {
          conversation.data.gender = gender;
          responseMessage = await sendHouses(conversation, res, fromNumber);
          await sendTextMessage(responseMessage, fromNumber);
          conversation.stage = "goodbye";
        } else {
          await sendTemplateMessage("error", fromNumber);
        }
        break;

      case "goodbye":
        await sendTextMessage(
          "Thank you for using Casa. For the full experience, please visit: https://casamax.co.zw/ where you can view all listings, pictures, contact the landlord or agent, and find the perfect boarding house.",
          fromNumber
        );
        break;

      default:
        await sendTextMessage("I’m not sure how to help with that. Can you please give a valid response?", fromNumber);
        break;
    }

    // Log incoming and outgoing messages
    conversation.data.messages = conversation.data.messages || [];
    conversation.data.messages.push({
      direction: "incoming",
      message: incomingMessage,
    });
    conversation.data.messages.push({
      direction: "outgoing",
      message: responseMessage,
    });

    return res.status(200).send("Message processed");

  } catch (error) {
    console.error("Error processing WhatsApp message:", error);
    return res.status(500).send("Internal Server Error");
  }
});

// Helper functions

function findMatchedUniversity(incomingMessage) {
  let matchedUniversity = null;

  // Check for number-based selection
  if (intents[incomingMessage]) {
    matchedUniversity = intents[incomingMessage];
  } else if (!isNaN(incomingMessage) && intents[incomingMessage]) {
    matchedUniversity = intents[incomingMessage];
  } else {
    // Check for nickname or full name
    for (let key in intents) {
      const intent = intents[key];
      if (
        intent.name.toLowerCase() === incomingMessage ||
        (intent.nicknames &&
          intent.nicknames.some(
            (nickname) => nickname.toLowerCase() === incomingMessage
          ))
      ) {
        matchedUniversity = intent;
        break;
      }
    }
  }
  return matchedUniversity;
}

function isValidBudget(budget) {
  return !isNaN(budget) && budget > 0;
}

async function handleGenderStage(incomingMessage, conversation, fromNumber) {
  if (
    maleKeywords.some(
      (keyword) =>
        incomingMessage.includes(keyword) || incomingMessage === "1"
    )
  ) {
    conversation.data.gender = "boys";
    return "boys";
  } else if (
    femaleKeywords.some(
      (keyword) =>
        incomingMessage.includes(keyword) || incomingMessage === "2"
    )
  ) {
    conversation.data.gender = "girls";
    return "girls";
  }
  return null;
}


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
          `${chatPhpApiUrl}/update_is_read.php?mobile_api=true&responseType=json`,
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
            `${chatPhpApiUrl}/show_users.php?student=${data.user}&responseType=json`
          )
        );
      } else if (data.type == "landlord") {
        response = await withTimeout(
          axios.get(
            `${chatPhpApiUrl}/show_users.php?landlord=${data.user}&responseType=json`
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
          `${chatPhpApiUrl}/get_chat_msg.php?responseType=json&student=true&outgoing_id=${data.user}&incoming_id=${data.receiver}`
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
          `${chatPhpApiUrl}/insert_chat.php?responseType=json&mobile_api=true`,
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

// Listen on port 3000
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));
