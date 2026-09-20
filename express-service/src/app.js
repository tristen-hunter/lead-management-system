const express = require("express");

const app = express();

app.use(express.json());

app.get("/", (req, res) => {
  res.json({
    message: "Express is working"
  });
});

app.post("/calls", (req, res) => {
  console.log("=== EXPRESS RECEIVED REQUEST ===");
  console.log("Request body:");
  console.log(req.body);

  res.json({
    message: "Express received the request",
    received: req.body
  });
});

module.exports = app;
