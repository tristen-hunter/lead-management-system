<div align="center">

# 𝐋𝐄𝐀𝐃 𝐌𝐀𝐍𝐀𝐆𝐄𝐌𝐄𝐍𝐓 𝐒𝐘𝐒𝐓𝐄𝐌

**PHP CRM · Express API · MySQL · Docker · Twilio**

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge\&logo=php\&logoColor=white)
![Node.js](https://img.shields.io/badge/Node.js-24-339933?style=for-the-badge\&logo=node.js\&logoColor=white)
![Express](https://img.shields.io/badge/Express-5-000000?style=for-the-badge\&logo=express\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge\&logo=docker\&logoColor=white)
![Twilio](https://img.shields.io/badge/Twilio-Voice-F22F46?style=for-the-badge\&logo=twilio\&logoColor=white)

*A small distributed application demonstrating PHP/Node service integration, Docker networking and outbound telephony.*

</div>

---

## Contents

* [Overview](#overview)
* [Architecture](#architecture)
* [How It Works](#how-it-works)
* [Tech Stack](#tech-stack)
* [Running Locally](#running-locally)
* [API](#api)
* [Project Structure](#project-structure)
* [Engineering Notes](#engineering-notes)
* [Current Status](#current-status)

---

## Overview

This project is a small lead-management system with an integrated outbound calling service.

The main application is written in **PHP** and backed by **MySQL**. Calling is deliberately separated into a **Node.js/Express service**, which communicates with **Twilio's Voice API**.

The separation means the PHP application does not need to know anything about the Twilio SDK. It simply requests a call through an internal HTTP API.

---

## Architecture

```text
                         Docker Compose

 ┌──────────────┐
 │    Browser   │
 └──────┬───────┘
        │
        ▼
 ┌─────────────────┐
 │   PHP / Apache  │
 │     :8000       │
 └──────┬──────┬───┘
        │      │
        │      └────────────────┐
        ▼                       ▼
 ┌─────────────┐       ┌─────────────────┐
 │    MySQL    │       │ Node / Express  │
 │    :3306    │       │      :3000      │
 └─────────────┘       └────────┬────────┘
                                │
                                │ Twilio API
                                ▼
                         ┌──────────────┐
                         │    Twilio    │
                         │ Voice API    │
                         └──────┬───────┘
                                │
                                ▼
                           Lead's phone
```

### Why two backend services?

The PHP application owns the **business application**:

* Authentication
* Lead management
* Database access
* Web interface

Express owns the **calling integration**:

* HTTP API
* Phone-number normalisation
* Twilio SDK
* Call-status tracking

This keeps the Twilio-specific implementation isolated from the PHP application.

---

## How It Works

```text
1. Lead submits their information
              ↓
2. PHP stores the lead in MySQL
              ↓
3. Admin requests a call
              ↓
4. PHP sends lead ID + phone number to Express
              ↓
5. Express normalises the number to E.164
              ↓
6. Express creates the call through Twilio
              ↓
7. Twilio plays the configured TwiML message
              ↓
8. Express polls Twilio for the final call status
              ↓
9. Call details are written to logs/calls.md
```

The current TwiML is intentionally simple:

```xml
<Response>
    <Say>
        Hi, thanks for your enquiry. A consultant will be in touch shortly.
    </Say>
</Response>
```

After the message is played, the call ends.

---

## Tech Stack

| Layer             | Technology             |
| ----------------- | ---------------------- |
| Web application   | PHP 8.2 + Apache       |
| Database          | MySQL 8.0              |
| Calling API       | Node.js 24 + Express 5 |
| Telephony         | Twilio Voice API       |
| PHP dependencies  | Composer               |
| Node dependencies | npm                    |
| Infrastructure    | Docker Compose         |

---

## Running Locally

### Requirements

* Docker
* Docker Compose
* Twilio account with Voice API credentials
* Twilio phone number

### 1. Configure environment variables

Create a `.env` file:

```env
DB_NAME=...
DB_USER=...
DB_PASSWORD=...
DB_ROOT_PASSWORD=...

TWILIO_ACCOUNT_SID=...
TWILIO_AUTH_TOKEN=...
TWILIO_PHONE_NUMBER=...
```

Keep real credentials out of source control.

### 2. Start the application

```bash
docker compose up --build
```

The services will be available at:

```text
PHP       http://localhost:8000
Express   http://localhost:3000
MySQL     localhost:3306
```

Open `http://localhost:8000` to access the application.

---

## API

### `POST /calls`

Requests an outbound call.

PHP sends the request internally to:

```text
http://express-service:3000/calls
```

Example payload:

```json
{
  "leadId": "8a91b9ba-5392-405c-99c2-f93b457765c2",
  "phoneNumber": "+27821234567"
}
```

Example response:

```json
{
  "message": "Call started",
  "leadId": "8a91b9ba-5392-405c-99c2-f93b457765c2",
  "callSid": "CA..."
}
```

The Express service also converts South African local numbers such as:

```text
0821234567
```

to:

```text
+27821234567
```

before sending them to Twilio.

---

## Project Structure

```text
.
├── db/
│   └── schema.sql
│
├── docker-compose.yml
│
├── express-service/
│   ├── Dockerfile
│   ├── package.json
│   ├── logs/
│   └── src/
│       ├── app.js
│       ├── server.js
│       ├── config/
│       │   └── twilio.js
│       ├── controllers/
│       │   └── callController.js
│       ├── routes/
│       │   └── callRoutes.js
│       └── services/
│           ├── callLogService.js
│           └── twilioService.js
│
└── php-app/
    ├── Dockerfile
    ├── composer.json
    ├── public/
    └── src/
        ├── Admins/
        ├── Config/
        ├── Integrations/
        └── Leads/
```

---

## Engineering Notes

### Docker service discovery

The PHP container does **not** call Express using `localhost`.

Inside Docker:

```text
PHP → http://express-service:3000
```

From the host machine:

```text
localhost:3000
```

Docker Compose provides internal DNS using the service names defined in `docker-compose.yml`.

### Service boundaries

PHP communicates with Express through a small `ExpressClient` abstraction rather than embedding Twilio logic inside the PHP application.

```text
PHP
 ↓
ExpressClient
 ↓ HTTP
Express API
 ↓
Twilio Service
 ↓
Twilio
```

### Call tracking

Twilio returns a Call SID immediately after creating a call.

The Express service uses that SID to periodically query Twilio until the call reaches a final state:

```text
completed
busy
no-answer
failed
canceled
```

The final call information is then written to:

```text
express-service/logs/calls.md
```

This includes the lead ID, numbers, status, duration, timestamps and price information returned by Twilio.

---

## Current Status

### Implemented

* Lead submission
* Admin authentication
* Lead management
* MySQL persistence
* Dockerised PHP application
* Dockerised Express service
* Dockerised MySQL
* PHP → Express HTTP integration
* Twilio outbound calling
* Phone-number normalisation
* TwiML voice response
* Call-status tracking
* Call logging

### Current limitation

The voice interaction is currently a basic demonstration. Twilio plays a predefined message after the call is answered and then terminates the call.

---

## Project Facts

```text
30 source files
1,082 lines of code
17 PHP files
7 JavaScript files
2 Dockerfiles
1 SQL schema
1 Docker Compose configuration
```

The project is intentionally small: the focus is on demonstrating **service separation, HTTP communication, Docker networking, API integration and external-service handling** rather than building a large application.