const axios = require("axios");
const intents = require("./intents"); // Import the intents file

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
  let pageUrl;
  for (let key in intents) {
    const intent = intents[key];

    if (
      intent.name.toLowerCase() === university.toLowerCase() ||
      intent.nicknames.some(
        (nickname) => nickname.toLowerCase() === university.toLowerCase()
      )
    ) {
      pageUrl = intent.page;
      break;
    }
  }

  fullUrl = `https://casamax.co.zw/unilistings/${pageUrl}?gender=${gender}&price=${budget}&filter_set=1`;
  const shortUrl = await minifyWithTinyURL(fullUrl);
  const text = "View the full list on CasaMax: " + shortUrl + "\n";
  return text;
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

// Export the functions if needed
module.exports = {
  makeBDApiCall,
  generateWhatsAppLink,
  generateMessages,
  generateFullCasamaxLink,
};
