// intents.js

const intents = {
    greeting: {
        keywords: ['hi', 'hello', 'hey', 'greetings'],
        response: 'Hello! How can I assist you today?'
    },
    name: {
        keywords: ['name'],
        response: 'What is your name?'
    },
    farewell: {
        keywords: ['bye', 'goodbye', 'see you'],
        response: 'Goodbye! Have a great day!'
    },
    university: {
        keywords: ['university', 'college', 'school'],
        response: 'Which university or college are you interested in?'
    },
    price: {
        keywords: ['price', 'cost', 'fee'],
        response: 'What is your budget range for the university?'
    },
    gender: {
        keywords: ['gender', 'male', 'female', 'non-binary'],
        response: 'Please specify your gender.'
    },
    default: {
        keywords: [],
        response: 'I’m not sure how to help with that. Could you please provide more details?'
    }
};

// Function to determine the intent based on the message
function getIntent(message) {
    message = message.toLowerCase();
    for (const [key, value] of Object.entries(intents)) {
        if (value.keywords.some(keyword => message.includes(keyword))) {
            return key;
        }
    }
    return 'default';
}

// Function to get the response based on the intent
function getResponse(intent) {
    return intents[intent] ? intents[intent].response : intents['default'].response;
}

module.exports = {
    getIntent,
    getResponse
};
