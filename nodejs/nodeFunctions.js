const axios = require("axios");

// Function to generate a WhatsApp link
async function generateWhatsAppLink(phoneNumber) {
  const message =
    "Hello found your boarding house on casamax.co.zw. Is your house still available?";
  const encodedMessage = encodeURIComponent(message);
  const longUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodedMessage}`;
  const shortUrl = await shortenWithIsGd(longUrl);
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
function generateWebLink(home_id) {
  const longUrl = `https://casamax.co.zw/listingdetails.php?clicked_id=${home_id}`;
  // const shortUrl = await shortenWithIsGd(longUrl);
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
      // const [webLink, whatsAppLink] = await Promise.all([
      //   generateWebLink(home_id),
      //   generateWhatsAppLink(contact),
      // ]);
      // generate web link
      webLink = generateWebLink(home_id);
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
        `*${ucfirst(firstname)} ${ucfirst(lastname)}'s house*\n` +
        `Price: *$${price}*\n` +
        `It is located at ${adrs}\n` +
        `Contact: ${contact}\n` +
        `Casamax.co.zw link: ${webLink}`;

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
// shortening url
async function shortenWithIsGd(longUrl) {
  try {
    const response = await axios.get(`https://is.gd/create.php?format=simple&url=${encodeURIComponent(longUrl)}`);
    return response.data;
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
