const axios = require("axios");

// Function to generate a WhatsApp link
function generateWhatsAppLink(phoneNumber) {
  const message =
    "Hello found your boarding house on casamax.co.zw. Is your house still available?";
  const encodedMessage = encodeURIComponent(message);
  return `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodedMessage}`;
}

// Function to get houses from the database
async function makeBDApiCall(uni, price, gender) {

  const apiUrl = `https://casamax.co.zw/homerunphp/whatsapp_reply.php?university=${uni}&price=${price}&gender=${gender}`;

  try {
    const response = await axios.get(apiUrl);
    houses = ensureArray(response.data);
    return houses;
  } catch (error) {
    console.error("Error making API call:", error);
    throw error;
  }
}

// Function to generate a link to the website
function generateWebLink(home_id) {
  return `https://casamax.co.zw/listingdetails.php?clicked_id=${home_id}`;
}

// Function to generate messages for each house object
function generateMessages(houses) {
    // Check if houses is an array
    if (!Array.isArray(houses)) {
      throw new Error('Expected houses to be an array.');
    }
  
    // Create an array to store the generated messages
    const houseMessage = 'Here are some *Boarding-Houses* we found for you \n';
  
    // Loop through each house object and generate the message
    houses.forEach((house) => {
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
      const webLink = generateWebLink(home_id);
  
      // Generate the message
      const message =
        `*${firstname} ${lastname}'s house*\n\n` +
        `*Amenities available:*\n` +
        `Price: *$${price}*\n` +
        `It is located in ${adrs}\n\n` +
        `You can get in touch with the landlord or agent using this link: ${generateWhatsAppLink(
          contact
        )}\n\n` +
        `View the house images and full details using the link below on our website:\n` +
        `${webLink}\n\n`;
  
      // Add the generated message to the messagesArray
      houseMessage += message;
    });
    // Return the array of generated messages
    console.log(houseMessage);
    return houseMessage;
  }
  

  // ensuring the response.body is an array 
  function ensureArray(responseBody) {
    if (Array.isArray(responseBody)) {
        // If responseBody is already an array, return it as is
        return responseBody;
    } else if (typeof responseBody === 'object' && responseBody !== null) {
        // If responseBody is an object, wrap it in an array
        return [responseBody];
    } else {
        // If responseBody is neither an array nor an object, handle the error
        throw new Error('Expected responseBody to be an array or an object.');
    }
}

// Export the functions if needed
module.exports = {
  makeBDApiCall,
  generateWhatsAppLink,
  generateMessages,
};
