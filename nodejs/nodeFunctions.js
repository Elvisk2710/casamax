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
    return response.data; // Return the data or handle as needed
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
    const messagesArray = [];
  
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
  
      // Create a string of available amenities
      const amenities = [
        kitchen && "Kitchen",
        fridge && "Fridge",
        wifi && "WiFi",
        borehole && "Borehole",
        transport && "Transport",
      ]
        .filter(Boolean)
        .join("\n");
  
      // Generate the message
      const message =
        `Here is a house that we have found that suits your needs\n\n` +
        `${firstname} ${lastname}'s house\n` +
        `Amenities available:\n` +
        `${amenities}\n\n` +
        `Price: *$${price}*\n` +
        `It is located at ${adrs}\n` +
        `You can get in touch with the landlord or agent using this link: ${generateWhatsAppLink(
          contact
        )}\n\n` +
        `View the house images and full details using the link below on casamax.co.zw:\n` +
        `${webLink}`;
  
      // Add the generated message to the messagesArray
      messagesArray.push(message);
    });
    // Return the array of generated messages
    return messagesArray;
  }
  

// Export the functions if needed
module.exports = {
  makeBDApiCall,
  generateWhatsAppLink,
  generateMessages,
};
