<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

    <main>
      <div class='container'>

        <div class="lead-form">
          <h1>Enter You Credentials</h1>

          <?php if (isset($_GET['error'])): ?>
            <p class='form-error'>
              <?= htmlspecialchars($_GET['error']) ?>
            </p>
          <?php endif; ?>

          <form action="login.php" method="POST">
            <label>Email Address:</label>
            <input type='text' name='email'>

            <label>Password</label>
            <input type='password' name='password'>

            <button class="btn btn-primary" type="submit">
              Submit
            </button>
          </form>

        </div>
      </div>
    </main>

</body>

</html>

