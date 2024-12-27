const intents = {
  1: {
    name: "University of Zimbabwe",
    nicknames: ["UZ", "University of Zimbabwe"],
    response:
      "You have selected the University of Zimbabwe. We will now find suitable boarding houses for you.",
    page: "uzlisting.php",
  },
  2: {
    name: "Midlands State University",
    nicknames: ["MSU", "Midlands State University"],
    response:
      "You have selected Midlands State University. We will now find suitable boarding houses for you.",
    page: "msulisting.php",
  },
  3: {
    name: "Africa University",
    nicknames: ["AU", "Africa University"],
    response:
      "You have selected Africa University. We will now find suitable boarding houses for you.",
    page: "aulisting.php",
  },
  4: {
    name: "Bindura University of Science and Education",
    nicknames: [
      "BUSE",
      "Bindura University of Science and Education",
      "Bindura University",
    ],
    response:
      "You have selected Bindura University of Science and Education. We will now find suitable boarding houses for you.",
    page: "bsulisting.php",
  },
  5: {
    name: "Chinhoyi University of Science and Technology",
    nicknames: [
      "CUT",
      "Chinhoyi University of Science and Technology",
      "Chinhoyi University",
    ],
    response:
      "You have selected Chinhoyi University of Science and Technology. We will now find suitable boarding houses for you.",
    page: "cutlisting.php",
  },
  6: {
    name: "Great Zimbabwe University",
    nicknames: ["GZU", "Great Zimbabwe University", "Great Zimbabwe"],
    response:
      "You have selected Great Zimbabwe University. We will now find suitable boarding houses for you.",
    page: "gzlisting.php",
  },
  7: {
    name: "Harare Institute of Technology",
    nicknames: ["HIT", "Harare Institute of Technology", "Harare Institute"],
    response:
      "You have selected Harare Institute of Technology. We will now find suitable boarding houses for you.",
    page: "hitlisting.php",
  },
  8: {
    name: "National University of Science and Technology",
    nicknames: ["NUST", "National University of Science and Technology"],
    response:
      "You have selected the National University of Science and Technology. We will now find suitable boarding houses for you.",
    page: "nustlisting.php",
  },
};
// Define greeting keywords
const greetingKeywords = [
  "hello",
  "hi",
  "hey",
  "greetings",
  "good morning",
  "good afternoon",
  "good evening",
  "what's up",
  "howdy",
  "yo",
  "hiya",
  "hallo",
  "wadi",
  "ndeip",
  "zvirisei",
  "sei",
];
// male keywords
const maleKeywords = [
  "male",
  "man",
  "m",
  "he",
  "him",
  "gentleman",
  "boy",
  "guy",
  "gents",
  "dude",
  "fella",
  "bloke",
  "chap",
  "sir",
  "bro",
  "fellow",
  "mister",
  "male gender",
  "male sex",
  "gees",
  "jees",
  "jisani",
  "vakomana",
  "mukomana",
  "gomana",
];
// female kewords
const femaleKeywords = [
  "female",
  "woman",
  "f",
  "she",
  "her",
  "lady",
  "girl",
  "gals",
  "gal",
  "dame",
  "miss",
  "madam",
  "female gender",
  "female sex",
  "womanhood",
  "queen",
  "lady friend",
  "chick",
  "musikana",
  "chisikana",
  "chick",
  "female person",
];

// Define goodbye keywords
const goodbyeKeywords = [
  "bye",
  "goodbye",
  "see you",
  "later",
  "farewell",
  "take care",
  "have a nice day",
  "catch you later",
  "see ya",
  "so long",
  "adieu",
  "cheerio",
  "no",
  "thank you",
  "thanks",
  "cool",
  "fine",
  "great",
];

module.exports = {
  intents,
  greetingKeywords,
  maleKeywords,
  femaleKeywords,
  goodbyeKeywords,
};
