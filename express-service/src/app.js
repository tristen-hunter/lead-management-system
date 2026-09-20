const express = require("express");
const app = express();

app.use(
  express.json({
    verify: (req, res, buf) => {
      req.rawBody = buf.toString("utf8");
    },
  })
);

app.use((req, res, next) => {
  console.log("\n=== EXPRESS RECEIVED REQUEST ===");
  console.log(`${req.method} ${req.originalUrl} HTTP/${req.httpVersion}`);
  console.log("Headers:", req.headers);
  console.log("Raw body:", req.rawBody);
  console.log("Parsed body:", req.body);
  next();
});

app.get("/", (req, res) => {
  res.json({ message: "Express is working" });
});

app.use("/calls", require("./routes/callRoutes"));

// error handler stays LAST
app.use((err, req, res, next) => {
  console.error("Express error:", err.message);
  res.status(400).json({ error: err.message });
});

module.exports = app;
