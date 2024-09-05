const axios = require("axios");

function generateWhatsAppLink(phoneNumber) {
  const message =
    "Hello found your boarding house on casamax.co.zw. Is your house still available?";

  // Encode the message to make it URL safe
  const encodedMessage = encodeURIComponent(message);

  // Construct the WhatsApp URL
  const whatsappLink = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodedMessage}`;

  return whatsappLink;
}

// get houses from the database
async function makeBDApiCall(uni, price, gender) {
  // Base URL of your API
  const apiUrl = `https://casamax.co.zw/homerunphp/whatsapp_reply.php?university=${uni}&price=${price}&gender=${gender}`;

  try {
    // Make a GET request with query parameters
    const response = await axios.get(apiUrl);
    // Handle the response
    console.log("Response Data:", response.data);
    return response.data; // Return the data or handle as needed
  } catch (error) {
    // Handle error
    console.error("Error making API call:", error);
    throw error;
  }
}

// generate link to website
function generateWebLink(home_id) {
  link = `https://casamax.co.zw/listingdetails.php?clicked_id=${home_id}`;
  return link;
}
// Function to generate message for each house object
function generateMessages(houses) {
    for(x == 0; x ++ ; x = houses.length-1){
        return houses[x].map((house) => {
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
            // link to casamax.co.zw
            webLink = generateWebLink(home_id);
            // Generate a list of amenities
            const amenities = [
              kitchen && "Kitchen",
              fridge && "Fridge",
              wifi && "WiFi",
              borehole && "Borehole",
              transport && "Transport",
            ]
              .filter(Boolean)
              .join(" \n");
        
            // Generate the message
            const message =
              `Here is a house that we have found that suits your needs\n\n` +
              `${firstname} ${lastname}'s house\n` +
              `Amenities available:\n` +
              `${amenities}\n\n` +
              `Price: *\$${price}*\n` +
              `It is located at ${adrs} \n` +
              `You can get in touch with the landlord or agent using this link: ${generateWhatsAppLink(
                contact
              )}\n\n` +
              `View the house images and full details using the link below on casamax.co.zw:\n` +
              `${webLink}`;
        
            return message;
          });
    }

}

// Export the functions
module.exports = {
  makeBDApiCall,
  generateWhatsAppLink,
  generateMessages,
};
