const express = require('express');
const bodyParser = require('body-parser');
const { MessagingResponse, validateRequest } = require('twilio');

const app = express();
app.use(bodyParser.urlencoded({ extended: false }));

// Hard-coded Twilio credentials (for demonstration purposes)
const TWILIO_AUTH_TOKEN = TWILIO_AUTH_TOKEN;
const TWILIO_ACCOUNT_SID = TWILIO_ACCOUNT_SID;

// Object to store the conversation data
const conversationData = {};

// Middleware to validate Twilio requests
app.use((req, res, next) => {
    const twilioSignature = req.headers['x-twilio-signature'];
    const url = req.protocol + '://' + req.get('host') + req.originalUrl;

    if (validateRequest(TWILIO_AUTH_TOKEN, twilioSignature, url, req.body)) {
        next();
    } else {
        res.status(403).send('Forbidden');
    }
});

// Route to handle incoming messages
app.post('/whatsapp', (req, res) => {
    const incomingMessage = req.body.Body;
    const fromNumber = req.body.From;

    // Initialize conversation data for the sender if not already done
    if (!conversationData[fromNumber]) {
        conversationData[fromNumber] = {
            stage: 'initial',
            data: {}
        };
    }

    const conversation = conversationData[fromNumber];
    let responseMessage = '';

    switch (conversation.stage) {
        case 'initial':
            responseMessage = 'Hello my name is Casa. \nI am here to help you find the best boarding house for your needs\n\nChoose your university....\n\n(1)University of Zimbabwe\n(2)Midlands State University\n(3)Africa University\n(4)Bindura university of Science and Education\n(5)Chinhoyi University of Science and Technology\n(6)Great Zimbabwe University\n(7)Harare Institute of Technology\n(8)National University of Science and Technology';
            conversation.stage = 'university';
            break;

        case 'university':
            conversation.data.university = incomingMessage;
            responseMessage = 'What is your budget range?';
            conversation.stage = 'budget';
            break;

        case 'budget':
            conversation.data.budget = incomingMessage;
            responseMessage = 'What is your gender?';
            conversation.stage = 'gender';
            break;

        case 'gender':
            conversation.data.gender = incomingMessage;
            responseMessage = `Thank you for providing the details. Here’s a summary:
            \nUniversity: ${conversation.data.university}
            \nBudget: ${conversation.data.budget}
            \nGender: ${conversation.data.gender}
            \nWe are finding the best boarding-houses for you`;
            conversation.stage = 'completed';
            break;

        case 'completed':
            responseMessage = 'Your request has been completed. Is there anything else I can help you with?';
            break;

        default:
            responseMessage = 'I’m not sure how to help with that. Could you please provide more details?';
    }

    // Store the incoming and outgoing messages in the conversation object
    conversationData[fromNumber].data.messages = conversationData[fromNumber].data.messages || [];
    conversationData[fromNumber].data.messages.push({ direction: 'incoming', message: incomingMessage });
    conversationData[fromNumber].data.messages.push({ direction: 'outgoing', message: responseMessage });

    const twiml = new MessagingResponse();
    twiml.message(responseMessage);

    res.writeHead(200, { 'Content-Type': 'text/xml' });
    res.end(twiml.toString());
});

// Start the server
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
