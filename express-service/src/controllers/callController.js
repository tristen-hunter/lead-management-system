const { startCall } = require("../services/twilioService");
const { trackCall } = require("../services/callLogService");

function toE164(raw) {
  const digits = raw.replace(/[^\d+]/g, "");
  if (digits.startsWith("+")) return digits;
  if (digits.startsWith("0")) return "+27" + digits.slice(1); // assumes South Africa
  return "+" + digits;
}


async function createCall(req, res) {
  const { leadId, phoneNumber } = req.body;

  if (!phoneNumber) {
    return res.status(400).json({ error: "phoneNumber is required" });
  }

  try {
    const callSid = await startCall(toE164(phoneNumber));
    res.json({ message: "Call started", leadId, callSid });

    trackCall({ sid: callSid, leadId });
  } catch (err) {
    console.error("Twilio error:", err.message);
    res.status(502).json({ error: err.message });
  }
}

module.exports = { createCall };
