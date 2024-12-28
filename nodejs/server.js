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
    // Check if the webhook contains messages
    if (body.object) {
      const entry = body.entry[0];
      const message = entry.changes[0]?.value?.messages[0];

      if (message) {
        const messageId = message.id;

        if (processedMessages.has(messageId)) {
          console.log(`Message ${messageId} already processed.`);
          res.status(200).send("Already processed");
          return;
        }
        processedMessages.add(messageId);
        const incomingMessage = message?.text?.body?.trim().toLowerCase(); // Normalize input
        const fromNumber = message?.from;

        // Initialize conversation data for the sender if not already present
        if (!conversationData[fromNumber]) {
          conversationData[fromNumber] = {
            stage: "initial",
            data: {},
          };
        }

        const conversation = conversationData[fromNumber];

        // Check if the message is a greeting
        if (
          greetingKeywords.some((keyword) => incomingMessage.includes(keyword))
        ) {
          conversation.stage = "initial"; // Reset to initial stage if needed
        }

        // Check if the message is a goodbye
        if (
          goodbyeKeywords.some((keyword) => incomingMessage.includes(keyword))
        ) {
          conversation.stage = "goodbye"; // Set stage to completed or end the conversation
        }

        // Initialize responseMessage variable to store the outgoing message
        let responseMessage;
        const currentDateTime = new Date()
          .toISOString()
          .slice(0, 19)
          .replace("T", " "); // Formats as 'YYYY-MM-DD HH:mm:ss'

        // Handle conversation stages
        switch (conversation.stage) {
          case "initial":
            conversation.stage = "university";
            sendTemplateMessage("choose_uni", fromNumber);
            callWhatsAppDbApi(fromNumber, "initiated", currentDateTime);
            break;

          case "university":
            updateConversationStatus(fromNumber, "university");
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

            if (matchedUniversity) {
              conversation.data.university = matchedUniversity.name;
              conversation.stage = "budget"; // Move to the next stage
              sendTemplateMessage("budget", fromNumber);
            } else {
              sendTemplateMessage("error", fromNumber);
            }
            break;

          case "budget":
            updateConversationStatus(fromNumber, "budget");
            const budget = parseFloat(incomingMessage);
            if (!isNaN(budget) && budget > 0) {
              conversation.data.budget = budget;
              conversation.stage = "gender";
              sendTemplateMessage("gender", fromNumber);
            } else {
              sendTextMessage(
                "Please enter a valid budget (e.g. 180).",
                fromNumber
              );
            }
            break;

          case "gender":
            updateConversationStatus(fromNumber, "gender");
            if (
              maleKeywords.some(
                (keyword) =>
                  incomingMessage.includes(keyword) || incomingMessage === "1"
              )
            ) {
              conversation.data.gender = "boys";
              responseMessage = await sendHouses(conversation, res, fromNumber);
              sendTextMessage(responseMessage, fromNumber);
              conversation.stage = "goodbye"; // Set stage after fetching houses
            } else if (
              femaleKeywords.some(
                (keyword) =>
                  incomingMessage.includes(keyword) || incomingMessage === "2"
              )
            ) {
              conversation.data.gender = "girls";
              responseMessage = await sendHouses(conversation, res, fromNumber);
              sendTextMessage(responseMessage, fromNumber);
              conversation.stage = "goodbye";
            } else {
              sendTemplateMessage("error", fromNumber);
            }
            break;

          case "goodbye":
            sendTextMessage(
              "Thank you for using Casa. \nFor the full experience please visit: https://casamax.co.zw/ where you can view all listings, view their pictures, contact landlord or agent and find the boarding house that is just right for you",
              fromNumber
            );
            break;

          default:
            sendTextMessage(
              "I’m not sure how to help with that. Can you please give a valid response!!",
              fromNumber
            );
            break;
        }

        // Store the incoming and outgoing messages in the conversation object
        conversation.data.messages = conversation.data.messages || [];
        conversation.data.messages.push({
          direction: "incoming",
          message: incomingMessage,
        });
        conversation.data.messages.push({
          direction: "outgoing",
          message: responseMessage,
        });
        // Respond to the webhook
        console.log(conversation);
        res.status(200).send("Message processed");
        return;
      } else {
        // No message data found in the webhook
        res.status(404).send("Message data not found.");
        return;
      }
    } else {
      // If no object found, return error
      res.status(400).send("Invalid webhook data.");
    }
  } catch (error) {
    // console.error("Error processing WhatsApp message:", error);
    res.status(500).send("Internal Server Error");
  }
});

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
