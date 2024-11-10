const express = require("express");
const bodyParser = require("body-parser");
const http = require("http");
const socketIo = require("socket.io");
const cors = require("cors");
const twilio = require("twilio");
const { MessagingResponse } = require("twilio").twiml;
const intents = require("./intents"); // Import the intents file
const accountSid = process.env.TWILIO_ACCOUNT_SID;
const authToken = process.env.TWILIO_AUTH_TOKEN;
const client = twilio(accountSid, authToken);
const axios = require("axios");

console.log("TWILIO_ACCOUNT_SID:", process.env.TWILIO_ACCOUNT_SID);
console.log("TWILIO_AUTH_TOKEN:", process.env.TWILIO_AUTH_TOKEN);

const {
  makeBDApiCall,
  generateWhatsAppLink,
  generateMessages,
  generateFullCasamaxLink,
} = require("./nodeFunctions"); // Import the intents file

// Initialize Express
const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Object to store conversation data
const conversationData = {};
// Define greeting keywords
const greetingKeywords = [
  "hello",
  "hi",
  "hey",
  "greetings",
  "good morning",
  "good afternoon",
  "good evening",
  "what's up",
  "howdy",
  "yo",
  "hiya",
  "hallo",
  "wadi",
  "ndeip",
  "zvirisei",
  "sei",
];
// male keywords
const maleKeywords = [
  "male",
  "man",
  "m",
  "he",
  "him",
  "gentleman",
  "boy",
  "guy",
  "gents",
  "dude",
  "fella",
  "bloke",
  "chap",
  "sir",
  "bro",
  "fellow",
  "mister",
  "male gender",
  "male sex",
  "gees",
  "jees",
  "jisani",
  "vakomana",
  "mukomana",
  "gomana",
];
// female kewords
const femaleKeywords = [
  "female",
  "woman",
  "f",
  "she",
  "her",
  "lady",
  "girl",
  "gals",
  "gal",
  "dame",
  "miss",
  "madam",
  "female gender",
  "female sex",
  "womanhood",
  "queen",
  "lady friend",
  "chick",
  "musikana",
  "chisikana",
  "chick",
  "female person",
];

// Define goodbye keywords
const goodbyeKeywords = [
  "bye",
  "goodbye",
  "see you",
  "later",
  "farewell",
  "take care",
  "have a nice day",
  "catch you later",
  "see ya",
  "so long",
  "adieu",
  "cheerio",
  "no",
  "thank you",
  "thanks",
  "cool",
  "fine",
  "great",
];

const chatPhpApiUrl = "https://casamax.co.zw/chat/server/";
const whatsAppDbApi = "https://casamax.co.zw/homerunphp/";

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
app.post("/whatsapp", async (req, res) => {
  try {
    const incomingMessage = req.body.Body.trim().toLowerCase(); // Normalize input
    const fromNumber = req.body.From;

    // Initialize conversation data for the sender if not already present
    if (!conversationData[fromNumber]) {
      conversationData[fromNumber] = {
        stage: "initial",
        data: {},
      };
    }

    const conversation = conversationData[fromNumber];

    // Check if the message is a greeting
    if (greetingKeywords.some((keyword) => incomingMessage.includes(keyword))) {
      conversation.stage = "initial"; // Reset to initial stage if needed
    }

    // Check if the message is a goodbye
    if (goodbyeKeywords.some((keyword) => incomingMessage.includes(keyword))) {
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
        responseMessage =
          "Hello! My name is Casa.\nI am here to help you find the best boarding house for your needs.\n\nChoose your university by replying with the corresponding number:\n\n" +
          "1. University of Zimbabwe\n" +
          "2. Midlands State University\n" +
          "3. Africa University\n" +
          "4. Bindura University of Science and Education\n" +
          "5. Chinhoyi University of Science and Technology\n" +
          "6. Great Zimbabwe University\n" +
          "7. Harare Institute of Technology\n" +
          "8. National University of Science and Technology";
        conversation.stage = "university";
        let intPhoneNumber = parseInt(fromNumber, 10); // Converts to integer (base 10)
        callWhatsAppDbApi(intPhoneNumber, "initiated", currentDateTime);
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
          responseMessage =
            "Oh Great!! " +
            matchedUniversity.name +
            ". What is your budget? (e.g. 160)";
          conversation.stage = "budget"; // Move to the next stage
        } else {
          responseMessage =
            "Invalid selection. Please choose a valid university number or name from the list.";
        }
        break;

      case "budget":
        updateConversationStatus(fromNumber, "budget");
        const budget = parseFloat(incomingMessage);
        if (!isNaN(budget) && budget > 0) {
          conversation.data.budget = budget;
          responseMessage = "What is your gender? \n1. Male \n2. Female";
          conversation.stage = "gender";
        } else {
          responseMessage = "Please enter a valid budget (e.g. 180).";
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
          conversation.stage = "goodbye"; // Set stage after fetching houses
        } else if (
          femaleKeywords.some(
            (keyword) =>
              incomingMessage.includes(keyword) || incomingMessage === "2"
          )
        ) {
          conversation.data.gender = "girls";
          responseMessage = await sendHouses(conversation, res, fromNumber);
          conversation.stage = "goodbye";
        } else {
          responseMessage =
            "Invalid selection. Please choose between: \n1. for Male \nor \n2. for Female.";
        }
        break;

      case "goodbye":
        responseMessage =
          "Thank you for using Casa. \nFor the full experience please visit: https://casamax.co.zw/ where you can view all listings, view their pictures, contact landlord or agent and find the boarding house that is just right for you";
        // Optionally, you can reset the conversation or delete the conversation data
        // delete conversationData[fromNumber];
        break;

      default:
        responseMessage =
          "I’m not sure how to help with that. Can you please give a valid response!!";
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

    // Generate TwiML response
    const twiml = new MessagingResponse();
    twiml.message(responseMessage);

    // Send the TwiML response
    res.writeHead(200, { "Content-Type": "text/xml" });
    res.end(twiml.toString());

    // Log the response for debugging purposes
  } catch (error) {
    console.error("Error processing WhatsApp message:", error);
    const twiml = new MessagingResponse();
    twiml.message(
      "Sorry, there was an error processing your request. Please try again later."
    );
    res.writeHead(500, { "Content-Type": "text/xml" });
    res.end(twiml.toString());
  }
});

// Generic message sending
const sendMessage = async (to, message) => {
  try {
    const response = await client.messages.create({
      from: "whatsapp:" + process.env.TWILIO_PHONE_NUMBER, // Your Twilio WhatsApp number
      to: `whatsapp:${to}`, // Recipient's WhatsApp number
      body: message, // Message content
    });
    console.log("Message sent:", response.sid);
  } catch (error) {
    console.error("Error sending message:", error);
  }
};

// add conversation to database
async function callWhatsAppDbApi(contact, status, date) {
  try {
    // Define the API endpoint
    const apiUrl = `${whatsAppDbApi}/add_initiated_conversations.php`; // Update with your PHP API URL
    // Prepare the data to send to the PHP API
    const data = {
      contact: contact,
      status: status,
      date: date,
    };
    // Make the POST request to the PHP API
    const response = await axios.post(apiUrl, data);
    // Handle the response
    if (response.data.success) {
      console.log("API call successful:", response.data);
    } else {
      console.log("API call failed:", response.data);
    }
  } catch (error) {
    console.error("Error making API call:", error.message);
  }
}

// Function to update conversation status
async function updateConversationStatus(contact, status) {
  try {
    // The URL of the PHP API you want to call
    const apiUrl = `${whatsAppDbApi}update_initiated_conversations.php`; // Update with the correct URL
    // Prepare the data to send in the PUT request
    const data = {
      contact: contact,
      status: status,
    };
    // Make the PUT request to the PHP API
    const response = await axios.post(apiUrl, data);
    // Check the response from the PHP API
    if (response.data.success) {
      console.log("Conversation status updated successfully:", response.data);
    } else {
      console.log("Error updating status:", response.data.error);
    }
  } catch (error) {
    console.error("Error calling the API:", error.message);
  }
}

// function to send houses to the client
async function sendHouses(conversation, res, fromNumber) {
  // Initialize responseMessage to ensure it's scoped correctly
  let responseMessage;
  updateConversationStatus(fromNumber, "university");

  try {
    // Destructure necessary data from the conversation object
    const { university, budget, gender } = conversation.data;

    // Fetch houses from the external API based on user criteria
    const response = await makeBDApiCall(university, budget, gender);

    // Generate a full URL related to the house listings
    let casaFullUrl = await generateFullCasamaxLink(university, budget, gender);

    // Check if the API returned any house listings
    if (response && response.length > 0) {
      // Generate an array of message strings based on the house listings
      const messagesArray = await generateMessages(
        response,
        university,
        budget,
        gender
      );

      // Check if message generation was successful and contains messages
      if (messagesArray && messagesArray.length > 0) {
        // Initialize responseMessage with the generated URL
        responseMessage = casaFullUrl;

        // Append the concatenated messages, separated by two newline characters for readability
        responseMessage += messagesArray.join("\n\n");

        // Send the response message back to the client
        return responseMessage;
      } else {
        // If message generation failed or returned no messages
        responseMessage = "Sorry! No houses found at the moment.";

        // Send the fallback message to the client
        return responseMessage;
      }
    } else {
      // If the API returned no house listings matching the criteria
      responseMessage =
        "Sorry! No houses found at the moment matching your criteria.";

      // Send the fallback message to the client
      return responseMessage;
    }
  } catch (error) {
    // Log the actual error details for debugging
    console.error("Error in sendHouses:", error);

    // Set a generic error message for the user
    responseMessage = "Sorry! Fetching Error. Please try again later.";

    // Send the error message back to the client
    return responseMessage;
  }
}

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
          `${chatPhpApiUrl}update_is_read.php?mobile_api=true&responseType=json`,
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
            `${chatPhpApiUrl}show_users.php?student=${data.user}&responseType=json`
          )
        );
      } else if (data.type == "landlord") {
        response = await withTimeout(
          axios.get(
            `${chatPhpApiUrl}show_users.php?landlord=${data.user}&responseType=json`
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
          `${chatPhpApiUrl}get_chat_msg.php?responseType=json&student=true&outgoing_id=${data.user}&incoming_id=${data.receiver}`
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
          `${chatPhpApiUrl}insert_chat.php?responseType=json&mobile_api=true`,
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

// Listen on port 3000
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));
