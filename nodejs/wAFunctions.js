const axios = require("axios");
const {
  intents,
  greetingKeywords,
  maleKeywords,
  femaleKeywords,
  goodbyeKeywords,
} = require("./intents"); // Import the intents file
require("dotenv").config();
const whatsAppDbApi = process.env.WA_DB_API_URL;

// Function to generate a WhatsApp link
async function generateWhatsAppLink(phoneNumber) {
  try {
    // Ensure the phone number is valid
    if (
      !phoneNumber ||
      typeof phoneNumber !== "string" ||
      !/^\+?\d{1,15}$/.test(phoneNumber)
    ) {
      throw new Error(
        "Invalid phone number format. Please provide a valid phone number."
      );
    }

    const message =
      "Hello found your boarding house on casamax.co.zw. Is your house still available?";

    // Safely encode the message to prevent any injection attacks
    const encodedMessage = encodeURIComponent(message);

    // Create the WhatsApp URL with the phone number and encoded message
    const longUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodedMessage}`;

    // Optionally, you can shorten the URL using a service like TinyURL
    // const shortUrl = await minifyWithTinyURL(longUrl);

    return longUrl; // You can return `shortUrl` if TinyURL is used
  } catch (error) {
    console.error("Error generating WhatsApp link:", error.message);
    throw new Error("Failed to generate WhatsApp link");
  }
}

// Function to get houses from the database
async function makeBDApiCall(uni, price, gender) {
  try {
    // Validate inputs to prevent potential security issues
    if (!uni || typeof uni !== "string" || uni.trim().length === 0) {
      throw new Error("Invalid university input.");
    }

    if (!price || isNaN(price)) {
      throw new Error("Invalid price input.");
    }

    if (!gender) {
      throw new Error("Invalid gender input. Must be 'male' or 'female'.");
    }

    // Construct the API URL with query parameters
    const apiUrl = `https://casamax.co.zw/homerunphp/whatsapp_reply.php?university=${encodeURIComponent(
      uni
    )}&price=${encodeURIComponent(price)}&gender=${encodeURIComponent(gender)}`;

    // Make the API call
    const response = await axios.get(apiUrl);

    // Ensure the response is an array
    const houses = ensureArray(response.data);

    return houses;
  } catch (error) {
    // Log detailed error information
    console.error("Error making API call:", error.message);
    // If the error is caused by a specific issue, throw that error
    throw new Error("Failed to fetch house listings. Please try again later.");
  }
}

// Function to generate a link to the website
async function generateWebLink(home_id) {
  try {
    // Validate the home_id input
    if (
      !home_id ||
      typeof home_id !== "string" ||
      home_id.trim().length === 0
    ) {
      throw new Error("Invalid home_id input.");
    }

    // Construct the long URL
    const longUrl = `https://casamax.co.zw/listingdetails.php?clicked_id=${encodeURIComponent(
      home_id
    )}`;

    // Generate the short URL
    const shortUrl = await minifyWithTinyURL(longUrl);

    if (!shortUrl) {
      throw new Error("Failed to generate short URL.");
    }

    return shortUrl;
  } catch (error) {
    // Log the error for debugging purposes
    console.error("Error generating web link:", error.message);
    throw new Error("Failed to generate the web link. Please try again later.");
  }
}

// generate the full casamax link
async function generateFullCasamaxLink(university, budget, gender) {
  try {
    if (!university) {
      throw new Error("University is undefined or null");
    }

    console.log("University input:", university);
    console.log("Intents object:", intents);

    let pageUrl;

    // Ensure the intents object is correctly defined and processed
    if (!intents || typeof intents !== "object") {
      throw new Error("Invalid intents object.");
    }

    for (let key in intents) {
      const intent = intents[key];

      // Ensure intent has the necessary properties
      if (!intent || !intent.name || !intent.nicknames) {
        console.log(`Skipping invalid intent at key: ${key}`);
        continue;
      }

      console.log("Processing intent:", intent.name);
      console.log("Comparing with university:", university);
      console.log("Nicknames:", intent.nicknames);

      // Case-insensitive comparison of university name and nicknames
      if (
        intent.name?.trim().toLowerCase() === university.trim().toLowerCase() ||
        intent.nicknames.some(
          (nickname) =>
            nickname?.trim().toLowerCase() === university.trim().toLowerCase()
        )
      ) {
        pageUrl = intent.page;
        break;
      }
    }

    if (!pageUrl) {
      throw new Error(
        `No matching page URL found for university: ${university}`
      );
    }

    // Construct the full URL
    const fullUrl = `https://casamax.co.zw/unilistings/${pageUrl}?gender=${gender}&price=${budget}&filter_set=1`;

    // Validate input parameters (gender and budget)
    if (typeof gender !== "string" || gender.trim().length === 0) {
      throw new Error("Invalid gender parameter.");
    }
    if (isNaN(budget) || budget <= 0) {
      throw new Error("Invalid budget parameter.");
    }

    // Minify the URL using TinyURL
    const shortUrl = await minifyWithTinyURL(fullUrl);

    if (!shortUrl) {
      throw new Error("Failed to generate short URL.");
    }

    return "View the full list on CasaMax: " + shortUrl + "\n";
  } catch (error) {
    console.error("Error generating full CasaMax link:", error.message);
    throw new Error(
      "Failed to generate the full CasaMax link. Please try again later."
    );
  }
}
// converting to proper case
function toProperCase(str) {
  try {
    if (typeof str !== "string") {
      throw new Error("Input is not a valid string.");
    }

    return str
      .toLowerCase() // Convert the entire string to lowercase
      .split(" ") // Split the string into an array of words
      .map((word) => {
        // Capitalize the first letter of each word
        if (word.length > 0) {
          return word.charAt(0).toUpperCase() + word.slice(1);
        }
        return word; // Return the word as is if it's empty
      })
      .join(" "); // Join the words back into a single string
  } catch (error) {
    console.error("Error in toProperCase:", error.message);
    return str; // Return the original string in case of error
  }
}

// generate google maps link
async function generateGoogleMapsLink(address) {
  try {
    // Ensure the address is a valid string
    if (typeof address !== "string" || address.trim() === "") {
      throw new Error("Invalid address provided.");
    }

    const baseUrl = "https://www.google.com/maps/search/?api=1&query=";
    const encodedAddress = encodeURIComponent(address); // Encode the address for a URL
    const longAddressUrl = `${baseUrl}${encodedAddress}`;

    // Generate the shortened URL using TinyURL
    const shortMapAddress = await minifyWithTinyURL(longAddressUrl);

    // Return the shortened Google Maps URL
    return shortMapAddress;
  } catch (error) {
    console.error("Error generating Google Maps link:", error.message);
    throw new Error("Failed to generate Google Maps link.");
  }
}

// Function to generate messages for each house object
async function generateMessages(houses) {
  // Check if houses is an array
  if (!Array.isArray(houses)) {
    throw new Error("Expected houses to be an array.");
  }

  try {
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

        // Validate input fields
        if (!home_id || !price || !contact || !adrs) {
          throw new Error(`Missing required fields for home_id: ${home_id}`);
        }

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
          `Phone Number: ${contact}\n` +
          `Casamax Link:${webLink}\n` +
          `Maps Link: ${mapsLink}` +
          (amenities ? `\n*Amenities:*\n${amenities}` : "");

        return message;
      })
    );

    // Return the array of generated messages
    return messagesArray;
  } catch (error) {
    console.error("Error generating messages:", error.message);
    throw new Error("Failed to generate house messages.");
  }
}

// Ensuring the response.body is an array
function ensureArray(responseBody) {
  try {
    if (Array.isArray(responseBody)) {
      return responseBody;
    } else if (typeof responseBody === "object" && responseBody !== null) {
      return [responseBody];
    } else {
      throw new Error("Expected responseBody to be an array or an object.");
    }
  } catch (error) {
    console.error("Error in ensureArray:", error.message);
    throw new Error("Failed to process responseBody into an array.");
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
    // Check if templateName and receiver are provided
    if (!templateName || !receiver) {
      throw new Error("Invalid template name or receiver.");
    }

    // Send the request to the WhatsApp API
    const response = await axios({
      url: `${process.env.WHATSAPP_API_URL}/messages`, // Use environment variable for URL
      method: "post",
      headers: {
        Authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`, // Using the token securely from environment variables
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
    // Handle errors by logging specific details
    console.error("Error sending template message:", error.message);

    // Check if the error has a response (e.g., from the WhatsApp API)
    if (error.response) {
      console.error("API Response:", error.response.data);
    }

    // Re-throw the error after logging it, to allow for higher-level error handling if needed
    throw new Error("Failed to send template message.");
  }
}

// send text message
async function sendTextMessage(body, receiver) {
  try {
    // Check if both body and receiver are provided
    if (!body || !receiver) {
      throw new Error("Invalid message body or receiver.");
    }

    // Send the request to the WhatsApp API
    const response = await axios({
      url: `${process.env.WHATSAPP_API_URL}/messages`, // Use environment variable for URL
      method: "post",
      headers: {
        Authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`, // Secure token from environment variables
        "Content-Type": "application/json",
      },
      data: {
        messaging_product: "whatsapp",
        to: receiver,
        type: "text",
        text: {
          body: body, // The body of the message
        },
      },
    });

    console.log("Text Message Sent. Response:", response.data);
    return response.data;
  } catch (error) {
    // Handle and log errors with additional context
    console.error("Error sending text message:", error.message);

    // If the error includes a response from the API, log that as well
    if (error.response) {
      console.error("API Response:", error.response.data);
    }

    // Re-throw the error to allow higher-level handling if needed
    throw new Error("Failed to send text message.");
  }
}

// add conversation to database
async function callWhatsAppDbApi(contact, status, date) {
  try {
    // Validate inputs
    if (!contact || !status || !date) {
      throw new Error("Missing required parameters: contact, status, or date.");
    }

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
    // Detailed error handling
    console.error("Error making API call:", error.message);

    // If the error has a response from the server, log it as well
    if (error.response) {
      console.error("API Response:", error.response.data);
    }

    // Re-throw the error for higher-level handling if necessary
    throw new Error("Failed to make the API call to WhatsApp DB.");
  }
}

// Function to update conversation status
async function updateConversationStatus(contact, status) {
  try {
    // Validate inputs
    if (!contact || !status) {
      throw new Error("Missing required parameters: contact or status.");
    }

    // The URL of the PHP API you want to call
    const apiUrl = `${whatsAppDbApi}/update_initiated_conversations.php`; // Update with the correct URL

    // Prepare the data to send in the POST request
    const data = {
      contact: contact,
      status: status,
    };

    // Make the POST request to the PHP API
    const response = await axios.post(apiUrl, data);

    // Check the response from the PHP API
    if (response.data.success) {
      console.log("Conversation status updated successfully:", response.data);
    } else {
      console.log("Error updating status:", response.data.error);
    }
  } catch (error) {
    // Detailed error handling
    console.error("Error calling the API:", error.message);

    // If the error has a response from the server, log it as well
    if (error.response) {
      console.error("API Response:", error.response.data);
    }

    // Re-throw the error for higher-level handling if necessary
    throw new Error("Failed to update conversation status.");
  }
}

// function to send houses to the client
async function sendHouses(conversation, res, fromNumber) {
  // Initialize responseMessage to ensure it's scoped correctly
  console.log("conversation", conversation);
  let responseMessage;

  try {
    // Ensure the conversation is valid
    if (!conversation || !conversation.data) {
      throw new Error("Invalid conversation object.");
    }

    // Destructure necessary data from the conversation object
    const { university, budget, gender } = conversation.data;

    // Validate inputs
    if (!university || !budget || !gender) {
      throw new Error(
        "Missing required fields: university, budget, or gender."
      );
    }

    // Update conversation status
    await updateConversationStatus(fromNumber, "completed");

    // Fetch houses from the external API based on user criteria
    const response = await makeBDApiCall(university, budget, gender);

    // Generate a full URL related to the house listings
    let casaFullUrl = await generateFullCasamaxLink(university, budget, gender);

    // Check if the API returned any house listings
    if (response && response.length > 0) {
      // Generate an array of message strings based on the house listings
      const messagesArray = await generateMessages(response);

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
