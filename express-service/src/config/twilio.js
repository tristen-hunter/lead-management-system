const twilio = require("twilio");

const { TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN, TWILIO_PHONE_NUMBER } = process.env;

if (!TWILIO_ACCOUNT_SID || !TWILIO_AUTH_TOKEN || !TWILIO_PHONE_NUMBER) {
  throw new Error("Missing Twilio env vars");
}

module.exports = {
  client: twilio(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN),
  fromNumber: TWILIO_PHONE_NUMBER,
};
