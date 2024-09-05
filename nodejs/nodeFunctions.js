const axios = require('axios');

function generateWhatsAppLink(phoneNumber) {
    const message = "Hello found your boarding house on casamax.co.zw. Is your house still available?";
    
    // Encode the message to make it URL safe
    const encodedMessage = encodeURIComponent(message);
    
    // Construct the WhatsApp URL
    const whatsappLink = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodedMessage}`;
    
    return whatsappLink;
}

async function makeBDApiCall(uni, price, gender) {
    // Base URL of your API
    const apiUrl = `https://casamax.co.zw/homerunphp/whatsapp_reply.php?university=${uni}&price=${price}&gender=${gender}`;

    try {
        // Make a GET request with query parameters
        const response = await axios.get(apiUrl);

        // Handle the response
        console.log('Response Data:', response.data);
        return response.data;  // Return the data or handle as needed

    } catch (error) {
        // Handle error
        console.error('Error making API call:', error);
        throw error;
    }
}

// Export the functions
module.exports = {
    makeBDApiCall,
    generateWhatsAppLink
};