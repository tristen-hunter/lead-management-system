const { client, fromNumber } = require("../config/twilio");

async function startCall(to) {
  const call = await client.calls.create({
    to,
    from: fromNumber,
    twiml: "<Response><Say>Hi, thanks for your enquiry. A consultant will be in touch shortly.</Say></Response>",
  });

  return call.sid;
}

module.exports = { startCall };
