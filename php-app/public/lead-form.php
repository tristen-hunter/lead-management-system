<!DOCTYPE html>
<html>
<head>
    <title>Add Lead</title>
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

        <div class="lead-form">
            <h1>Enter Your Info To Get A Call</h1>

            <?php if (isset($_GET['error'])): ?>
                <p class="form-error">
                    <?= htmlspecialchars($_GET['error']) ?>
                </p>
            <?php endif; ?>

            <form action="submit-lead.php" method="POST">

                <label>First Name:</label>
                <input type="text" name="first_name">

                <label>Last Name:</label>
                <input type="text" name="last_name">

                <label>Phone Number:</label>
                <input type="text" name="phone_number">

                <label>Email:</label>
                <input type="text" name="email">

                <label>Notes:</label>
                <textarea name="notes"></textarea>

                <button class="btn btn-primary" type="submit">
                    Submit
                </button>

            </form>
        </div>

    </div>
</main>

</body>
</html>
