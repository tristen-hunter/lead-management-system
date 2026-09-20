<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VoiceAI Demo</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

<nav class="navbar">
    <div class="container">

        <div class="navbar-brand">
            VoiceAI
        </div>

        <div class="navbar-links">
            <a href="#">Platform</a>
            <a href="#">Solutions</a>
            <a href="#">About</a>
            <a href="lead-form.php">Contact</a>
            <a href='login-form.php'>
              <button class='btn btn-primary'>
                Login
              </button>
            </a>
        </div>

    </div>
</nav>

<main>
    <div class="container">

        <?php if (isset($_GET['success'])): ?>
          <div class="toast">
            <span>
              Submitted successfully! Our Voice AI will call you now.
            </span>
            <button 
              class="toast-close" 
              onclick="this.parentElement.remove()"
            >
              ×
            </button>
          </div>        
        <?php endif; ?>

        <section class="hero">
            <h1>Try Our AI Voice Agent</h1>

            <p>
                Experience a custom voice agent designed to speak with
                your customers, answer questions, and handle conversations.
            </p>

            <a href="lead-form.php">
                <button class="btn btn-primary">Call Me</button>
            </a>
        </section>

    </div>
</main>

<footer class="footer">
  <div class="container">
    <p>© 2026 VoiceAI. All rights reserved.</p>

    <div class="footer-links">
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="#">Contact</a>
    </div>
  </div>
</footer>

</body>
</html>
