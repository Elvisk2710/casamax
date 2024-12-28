const axios = require("axios");
const intents = require("./intents"); // Import the intents file
require("dotenv").config();
const whatsAppDbApi = process.env.WA_DB_API_URL;

// Function to generate a WhatsApp link
async function generateWhatsAppLink(phoneNumber) {
  const message =
    "Hello found your boarding house on casamax.co.zw. Is your house still available?";
  const encodedMessage = encodeURIComponent(message);
  const longUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodedMessage}`;
  // const shortUrl = await minifyWithTinyURL(longUrl);
  return phoneNumber;
}

// Function to get houses from the database
async function makeBDApiCall(uni, price, gender) {
  const apiUrl = `https://casamax.co.zw/homerunphp/whatsapp_reply.php?university=${uni}&price=${price}&gender=${gender}`;

  try {
    const response = await axios.get(apiUrl);
    const houses = ensureArray(response.data);
    return houses;
  } catch (error) {
    console.error("Error making API call:", error);
    throw error;
  }
}

// Function to generate a link to the website
async function generateWebLink(home_id) {
  const longUrl = `https://casamax.co.zw/listingdetails.php?clicked_id=${home_id}`;
  const shortUrl = await minifyWithTinyURL(longUrl);
  return shortUrl;
}

// generate the full casamax link
async function generateFullCasamaxLink(university, budget, gender) {
  if (!university) {
    throw new Error("University is undefined or null");
  } else {
    console.log("university", university);
  }

  let pageUrl;

  for (let key in intents) {
    const intent = intents[key];

    console.log("Processing intent:", intent.name);
    console.log("Comparing with university:", university);
    console.log("Nicknames:", intent.nicknames);

    // Normalize and compare names
    if (
      intent.name?.trim().toLowerCase() === university.trim().toLowerCase() ||
      (intent.nicknames &&
        intent.nicknames.some(
          (nickname) =>
            nickname?.trim().toLowerCase() === university.trim().toLowerCase()
        ))
    ) {
      pageUrl = intent.page;
      break;
    }
  }

  if (!pageUrl) {
    throw new Error(`No matching page URL found for university: ${university}`);
  }

  const fullUrl = `https://casamax.co.zw/unilistings/${pageUrl}?gender=${gender}&price=${budget}&filter_set=1`;

  try {
    const shortUrl = await minifyWithTinyURL(fullUrl);
    const text = "View the full list on CasaMax: " + shortUrl + "\n";
    return text;
  } catch (error) {
    console.error("Error generating short URL:", error);
    throw new Error("Failed to generate short URL");
  }
}

// converting to proper case
function toProperCase(str) {
  return str
    .toLowerCase() // Convert the entire string to lowercase
    .split(" ") // Split the string into an array of words
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize the first letter of each word
    .join(" "); // Join the words back into a single string
}

// generate google maps link
async function generateGoogleMapsLink(address) {
  const baseUrl = "https://www.google.com/maps/search/?api=1&query=";
  const encodedAddress = encodeURIComponent(address); // Encode the address for a URL
  longAddressUrl = `${baseUrl}${encodedAddress}`;
  const shortMapAddress = await minifyWithTinyURL(longAddressUrl);
  return shortMapAddress;
}

// Function to generate messages for each house object
async function generateMessages(houses) {
  // Check if houses is an array
  if (!Array.isArray(houses)) {
    throw new Error("Expected houses to be an array.");
  }

  // Use Promise.all to handle asynchronous operations in parallel
  const messagesArray = await Promise.all(
    houses.map(async (house) => {
      const {
        home_id,
        price,
        firstname,
        lastname,
        kitchen,
        fridge,
        wifi,
        borehole,
        transport,
        contact,
        adrs,
      } = house;

      // Generate the link to the house on casamax.co.zw
      const [webLink, whatsAppLink, mapsLink] = await Promise.all([
        generateWebLink(home_id),
        generateWhatsAppLink(contact),
        generateGoogleMapsLink(adrs),
      ]);

      // Create a string of available amenities
      const amenities = [
        kitchen && "- Kitchen",
        fridge && "- Fridge",
        wifi && "- WiFi",
        borehole && "- Borehole",
        transport && "- Transport",
      ]
        .filter(Boolean)
        .join("\n");

      // Generate the message
      const message =
        `\n*${toProperCase(firstname)} ${toProperCase(lastname)}'s House*\n` +
        `Price: *$${price}*\n` +
        `Located at: ${adrs}\n` +
        `Phone Number: ${whatsAppLink}\n` +
        `Casamax Link:${webLink}\n` +
        `Maps Link: ${mapsLink}`;

      return message;
    })
  );

  // Return the array of generated messages
  return messagesArray;
}

// Ensuring the response.body is an array
function ensureArray(responseBody) {
  if (Array.isArray(responseBody)) {
    return responseBody;
  } else if (typeof responseBody === "object" && responseBody !== null) {
    return [responseBody];
  } else {
    throw new Error("Expected responseBody to be an array or an object.");
  }
}

// Function to minify URL using TinyURL
async function minifyWithTinyURL(longUrl) {
  try {
    const response = await axios.get(
      `https://tinyurl.com/api-create.php?url=${encodeURIComponent(longUrl)}`
    );
    return response.data; // Returns the shortened URL
  } catch (error) {
    console.error("Error shortening URL:", error);
    return null;
  }
}

// send template message
async function sendTemplateMessage(templateName, receiver) {
  try {
    if (!templateName || !receiver) {
      throw new Error("Invalid template name or receiver.");
    }

    const response = await axios({
      url: `${process.env.WHATSAPP_API_URL}/messages`, // Use environment variable for URL
      method: "post",
      headers: {
        Authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`,
        "Content-Type": "application/json",
      },
      data: {
        messaging_product: "whatsapp",
        to: receiver,
        type: "template",
        template: {
          name: templateName,
          language: {
            code: "en_US", // Customize language if necessary
          },
        },
      },
    });

    console.log("Template Message Sent. Response:", response.data);
    return response.data;
  } catch (error) {
    console.error("Error sending template message:", error.message);
    if (error.response) {
      console.error("API Response:", error.response.data);
    }
  }
}

// send text message
async function sendTextMessage(body, receiver) {
  try {
    if (!body || !receiver) {
      throw new Error("Invalid message body or receiver.");
    }

    const response = await axios({
      url: `${process.env.WHATSAPP_API_URL}/messages`, // Use environment variable for URL
      method: "post",
      headers: {
        Authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`,
        "Content-Type": "application/json",
      },
      data: {
        messaging_product: "whatsapp",
        to: receiver,
        type: "text",
        text: {
          body: body,
        },
      },
    });

    console.log("Text Message Sent. Response:", response.data);
    return response.data;
  } catch (error) {
    console.error("Error sending text message:", error.message);
    if (error.response) {
      console.error("API Response:", error.response.data);
    }
  }
}

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
    const apiUrl = `${whatsAppDbApi}/update_initiated_conversations.php`; // Update with the correct URL
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
  console.log("conversation", conversation);
  let responseMessage;
  updateConversationStatus(fromNumber, "completed");

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
// Export the functions if needed
module.exports = {
  makeBDApiCall,
  generateWhatsAppLink,
  generateMessages,
  generateFullCasamaxLink,
  sendTemplateMessage,
  sendTextMessage,
  callWhatsAppDbApi,
  updateConversationStatus,
  sendHouses,
};
