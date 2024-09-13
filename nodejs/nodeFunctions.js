const axios = require("axios");

// Function to generate a WhatsApp link
async function generateWhatsAppLink(phoneNumber) {
  const message =
    "Hello found your boarding house on casamax.co.zw. Is your house still available?";
  const encodedMessage = encodeURIComponent(message);
  const longUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodedMessage}`;
  const shortUrl = await minifyWithTinyURL(longUrl);
  return shortUrl;
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
      const [webLink, whatsAppLink] = await Promise.all([
        generateWebLink(home_id),
        generateWhatsAppLink(contact),
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
        `*${firstname} ${lastname}'s house*\n` +
        `Price: *$${price}*\n` +
        `It is located at ${adrs}\n` +
        `WhatsApp link: ${whatsAppLink}\n` +
        `Casamax Link:${webLink}`;

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

// Export the functions if needed
module.exports = {
  makeBDApiCall,
  generateWhatsAppLink,
  generateMessages,
};
