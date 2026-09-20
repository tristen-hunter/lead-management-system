const router = require("express").Router();
const { createCall } = require("../controllers/callController");

router.post("/", createCall);

module.exports = router;
