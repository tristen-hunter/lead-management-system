const fs = require("fs");
const path = require("path");
const { client } = require("../config/twilio");

const LOG_DIR = path.join(__dirname, "../../logs");   // /app/logs in the container
const LOG_FILE = path.join(LOG_DIR, "calls.md");
const FINAL_STATUSES = ["completed", "busy", "no-answer", "failed", "canceled"];

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

function writeEntry(md) {
  fs.mkdirSync(LOG_DIR, { recursive: true });
  fs.appendFileSync(LOG_FILE, md);
}

async function trackCall({ sid, leadId }) {
  try {
    for (let i = 0; i < 40; i++) {            // about 3 minutes max
      await sleep(5000);
      const call = await client.calls(sid).fetch();

      if (FINAL_STATUSES.includes(call.status)) {
        writeEntry(
          `## Call ${call.sid}

| Field | Value |
|---|---|
| Lead ID | ${leadId} |
| To | ${call.to} |
| From | ${call.from} |
| Status | **${call.status}** |
| Duration | ${call.duration ?? 0}s |
| Started | ${call.startTime?.toISOString() ?? "n/a"} |
| Ended | ${call.endTime?.toISOString() ?? "n/a"} |
| Price | ${call.price ?? "pending"} ${call.priceUnit ?? ""} |

---

`);
        return;
      }
    }
    writeEntry(`## Call ${sid}\n\nStill not finished after 3 minutes, gave up tracking.\n\n---\n\n`);
  } catch (err) {
    console.error("Call tracking failed:", err.message);
  }
}

module.exports = { trackCall };
